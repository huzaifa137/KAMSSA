<?php

namespace App\Http\Controllers;

use App\Models\BroadcastMessage;
use App\Models\BroadcastMessageRecipient;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

/**
 * Notifications / Broadcast Messages.
 *
 * Lets a system user (Administrator) compose a single message and fan it
 * out to any mix of:
 *   - Schools (houses table)              -> all, or a hand-picked subset
 *   - System Users (admins/marks entrants) -> all, or a hand-picked subset
 *
 * The message itself is stored once (broadcast_messages). Delivery is
 * tracked per-recipient (broadcast_message_recipients) so the sender can
 * see who has read it, and each recipient (School portal, or the
 * admin-tab inbox) only ever sees messages actually addressed to them.
 */
class BroadcastMessageController extends Controller
{
    public static $page = "NOTIFICATIONS";

    /**
     * Compose screen + list of everything sent so far.
     */
    public function index()
    {
        $schools = House::orderBy('House')->get([
            'ID', 'House', 'Number', 'district', 'administrator_names', 'administrator_telephones', 'email',
        ]);

        $systemUsers = User::where('user_role', 'admin')
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname', 'username', 'email', 'system_role', 'is_active']);

        $messages = BroadcastMessage::with('sender')
            ->withCount([
                'recipients as read_count' => fn($q) => $q->where('is_read', true),
            ])
            ->latest()
            ->get();

        return view('broadcast-messages.index', compact('schools', 'systemUsers', 'messages'));
    }

    /**
     * Compose & send a new broadcast message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'      => ['required', 'string', 'max:255'],
            'body'         => ['required', 'string'],
            'priority'     => ['nullable', Rule::in(array_keys(BroadcastMessage::PRIORITY_LABELS))],
            'schools_mode' => ['required', Rule::in(['none', 'all', 'selected'])],
            'users_mode'   => ['required', Rule::in(['none', 'all', 'selected'])],
            'schools'      => ['nullable', 'array'],
            'schools.*'    => ['integer'],
            'users'        => ['nullable', 'array'],
            'users.*'      => ['integer'],
        ]);

        // Resolve the actual recipient ID lists from the chosen modes.
        $schoolIds = [];
        if ($validated['schools_mode'] === 'all') {
            $schoolIds = House::pluck('ID')->all();
        } elseif ($validated['schools_mode'] === 'selected') {
            $schoolIds = array_values(array_intersect(House::pluck('ID')->all(), $validated['schools'] ?? []));
        }

        $userIds = [];
        if ($validated['users_mode'] === 'all') {
            $userIds = User::where('user_role', 'admin')->pluck('id')->all();
        } elseif ($validated['users_mode'] === 'selected') {
            $userIds = array_values(array_intersect(
                User::where('user_role', 'admin')->pluck('id')->all(),
                $validated['users'] ?? []
            ));
        }

        if (empty($schoolIds) && empty($userIds)) {
            Alert::error('No Recipients Selected', 'Please choose at least one school or system user to receive this message.');
            return back()->withInput();
        }

        DB::transaction(function () use ($validated, $schoolIds, $userIds) {
            $message = BroadcastMessage::create([
                'subject'          => $validated['subject'],
                'body'             => $validated['body'],
                'sender_id'        => session('LoggedAdmin'),
                'schools_mode'     => $validated['schools_mode'],
                'users_mode'       => $validated['users_mode'],
                'priority'         => $validated['priority'] ?? 'normal',
                'recipients_count' => count($schoolIds) + count($userIds),
                'schools_count'    => count($schoolIds),
                'users_count'      => count($userIds),
            ]);

            $now  = now();
            $rows = [];

            foreach ($schoolIds as $id) {
                $rows[] = [
                    'broadcast_message_id' => $message->id,
                    'recipient_type'       => 'school',
                    'recipient_id'         => $id,
                    'is_read'              => false,
                    'created_at'           => $now,
                    'updated_at'           => $now,
                ];
            }

            foreach ($userIds as $id) {
                $rows[] = [
                    'broadcast_message_id' => $message->id,
                    'recipient_type'       => 'user',
                    'recipient_id'         => $id,
                    'is_read'              => false,
                    'created_at'           => $now,
                    'updated_at'           => $now,
                ];
            }

            foreach (array_chunk($rows, 500) as $chunk) {
                BroadcastMessageRecipient::insert($chunk);
            }
        });

        Alert::success('Message Sent', 'Your message has been delivered to the selected recipients.');
        return redirect()->route('notifications.index');
    }

    /**
     * A single sent message: full content + per-recipient read receipts.
     */
    public function show($id)
    {
        $message = BroadcastMessage::with('sender')->findOrFail($id);

        $schoolRecipients = $message->schoolRecipients()->get();
        $userRecipients   = $message->userRecipients()->get();

        $schoolsById = House::whereIn('ID', $schoolRecipients->pluck('recipient_id'))
            ->get(['ID', 'House', 'Number', 'district'])
            ->keyBy('ID');

        $usersById = User::whereIn('id', $userRecipients->pluck('recipient_id'))
            ->get(['id', 'firstname', 'lastname', 'username', 'email'])
            ->keyBy('id');

        return view('broadcast-messages.show', compact(
            'message', 'schoolRecipients', 'userRecipients', 'schoolsById', 'usersById'
        ));
    }

    /**
     * Delete a sent message (recipients cascade-delete with it).
     */
    public function destroy($id)
    {
        $message = BroadcastMessage::findOrFail($id);
        $message->delete();

        return response()->json(['success' => true, 'message' => 'Message deleted.']);
    }

    /* ===================== ADMIN-TAB INBOX ===================== */

    /**
     * Messages addressed directly to the currently logged-in system user.
     */
    public function inbox()
    {
        $recipientRows = BroadcastMessageRecipient::with('message.sender')
            ->where('recipient_type', 'user')
            ->where('recipient_id', session('LoggedAdmin'))
            ->whereHas('message')
            ->get()
            ->sortByDesc(fn($row) => $row->message->created_at)
            ->values();

        return view('broadcast-messages.inbox', compact('recipientRows'));
    }

    public function markInboxRead($recipientId)
    {
        $row = BroadcastMessageRecipient::where('id', $recipientId)
            ->where('recipient_type', 'user')
            ->where('recipient_id', session('LoggedAdmin'))
            ->firstOrFail();

        $row->markAsRead();

        return response()->json(['success' => true]);
    }

    /* ===================== SCHOOL PORTAL INBOX ===================== */

    /**
     * Messages addressed to the currently logged-in School.
     */
    public function schoolInbox()
    {
        $recipientRows = BroadcastMessageRecipient::with('message.sender')
            ->where('recipient_type', 'school')
            ->where('recipient_id', session('LoggedSchool'))
            ->whereHas('message')
            ->get()
            ->sortByDesc(fn($row) => $row->message->created_at)
            ->values();

        return view('School.messages.index', compact('recipientRows'));
    }

    public function schoolMarkRead($recipientId)
    {
        $row = BroadcastMessageRecipient::where('id', $recipientId)
            ->where('recipient_type', 'school')
            ->where('recipient_id', session('LoggedSchool'))
            ->firstOrFail();

        $row->markAsRead();

        return response()->json(['success' => true]);
    }
}
