<?php

namespace App\Http\Controllers;

use App\Models\MarksEntrantAssignment;
use App\Models\MasterData;
use App\Models\SubjectPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * System Users management (admins + marks entrants).
 *
 * "System users" here means accounts with user_role = 'admin' — the
 * people who log in on the Admin tab, as opposed to students or schools.
 * A system user is either:
 *   - a full Administrator (system_role = null): unrestricted, same as
 *     every admin account that already existed before this feature, or
 *   - a Marks Entrant (system_role = 'marks_entrant'): restricted to the
 *     subjects/papers assigned via marks_entrant_assignments.
 */
class MarksEntrantController extends Controller
{
    /**
     * List every system (admin-tab) user with their assignment summary.
     */
    public function index()
    {
        $users = User::where('user_role', 'admin')
            ->withCount('markAssignments')
            ->orderByDesc('id')
            ->get();

        $catalog = $this->subjectCatalog();

        // Existing assignments per user, so the edit modal can be
        // pre-populated without another round trip.
        $assignmentsByUser = MarksEntrantAssignment::all()
            ->groupBy('user_id')
            ->map(function ($rows) {
                return $rows->map(fn($row) => $row->subject_id . ':' . $row->paper_number)->values();
            });

        return view('marks-entrants.index', compact('users', 'catalog', 'assignmentsByUser'));
    }

    /**
     * Create a new system user (Administrator or Marks Entrant).
     */
    public function store(Request $request)
    {
        $validated = $this->validateUser($request);

        DB::transaction(function () use ($validated, $request) {
            $user = new User();
            $user->name = trim($validated['firstname'] . ' ' . $validated['lastname']);
            $user->firstname = $validated['firstname'];
            $user->lastname = $validated['lastname'];
            $user->username = $validated['username'];
            $user->email = $validated['email'];
            $user->phonenumber = $validated['phonenumber'] ?? null;
            $user->password = Hash::make($validated['password']);
            $user->user_role = 'admin';
            $user->system_role = $validated['system_role'] ?: null;
            $user->is_active = true;
            $user->save();

            if ($user->system_role === 'marks_entrant') {
                $this->syncAssignments($user, $request->input('assignments', []));
            }
        });

        return back()->with('success', 'System user created successfully.');
    }

    /**
     * Update an existing system user's profile, status, role and (if a
     * marks entrant) their subject/paper assignments.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('user_role', 'admin')->findOrFail($id);

        $validated = $this->validateUser($request, $user->id);

        DB::transaction(function () use ($validated, $request, $user) {
            $user->firstname = $validated['firstname'];
            $user->lastname = $validated['lastname'];
            $user->name = trim($validated['firstname'] . ' ' . $validated['lastname']);
            $user->username = $validated['username'];
            $user->email = $validated['email'];
            $user->phonenumber = $validated['phonenumber'] ?? null;
            $user->system_role = $validated['system_role'] ?: null;

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            if ($user->system_role === 'marks_entrant') {
                $this->syncAssignments($user, $request->input('assignments', []));
            } else {
                // Switched back to full Administrator — assignments no
                // longer mean anything, drop them.
                MarksEntrantAssignment::where('user_id', $user->id)->delete();
            }
        });

        return back()->with('success', 'System user updated successfully.');
    }

    /**
     * Enable / disable a system user's login without deleting them.
     */
    public function toggleStatus($id)
    {
        $user = User::where('user_role', 'admin')->findOrFail($id);

        if ($user->id === session('LoggedAdmin')) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account.',
            ], 422);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => $user->is_active ? 'User activated.' : 'User deactivated.',
        ]);
    }

    /**
     * Delete a system user (and, via FK cascade, their assignments).
     */
    public function destroy($id)
    {
        $user = User::where('user_role', 'admin')->findOrFail($id);

        if ($user->id === session('LoggedAdmin')) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted.']);
    }

    private function validateUser(Request $request, $ignoreUserId = null)
    {
        $passwordRules = $ignoreUserId
            ? ['nullable', 'string', 'min:6']
            : ['required', 'string', 'min:6'];

        return $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($ignoreUserId),
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($ignoreUserId),
            ],
            'phonenumber' => ['nullable', 'string', 'max:30'],
            'password' => $passwordRules,
            'system_role' => ['nullable', Rule::in(['marks_entrant'])],
            'assignments' => ['nullable', 'array'],
            'assignments.*' => ['string'],
        ]);
    }

    /**
     * Replace a marks entrant's assignments with the submitted set.
     * $rawAssignments arrives as strings "{subject_id}:{paper_number}".
     */
    private function syncAssignments(User $user, array $rawAssignments)
    {
        MarksEntrantAssignment::where('user_id', $user->id)->delete();

        if (empty($rawAssignments)) {
            return;
        }

        $categoryFor = $this->subjectCategoryMap();

        $rows = [];
        foreach ($rawAssignments as $raw) {
            [$subjectId, $paperNumber] = array_pad(explode(':', $raw, 2), 2, 1);

            if (!is_numeric($subjectId) || !is_numeric($paperNumber)) {
                continue;
            }

            $rows[] = [
                'user_id' => $user->id,
                'subject_id' => (int) $subjectId,
                'paper_number' => (int) $paperNumber,
                'category' => $categoryFor[(int) $subjectId] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Guard against duplicate (subject, paper) submissions from the form.
        $rows = collect($rows)
            ->unique(fn($row) => $row['subject_id'] . '-' . $row['paper_number'])
            ->values()
            ->all();

        if (!empty($rows)) {
            MarksEntrantAssignment::insert($rows);
        }
    }

    /**
     * Every PLE/UCE/UACE subject, grouped by category, annotated with its
     * paper count — the data the assignment picker (and syncAssignments)
     * is built from.
     */
    private function subjectCatalog()
    {
        $categories = [
            // 'PLE' => ['label' => 'PLE', 'master_code' => config('constants.options.PLEPapers')],
            'UCE' => ['label' => 'UCE (O-LEVEL)', 'master_code' => config('constants.options.UCEPapers')],
            'UACE' => ['label' => 'UACE (A-LEVEL)', 'master_code' => config('constants.options.UACEPapers')],
        ];

        $catalog = [];

        foreach ($categories as $code => $meta) {
            $rows = MasterData::where('md_master_code_id', $meta['master_code'])
                ->orderBy('md_name')
                ->get(['md_id', 'md_name', 'md_code', 'md_misc3']);

            $catalog[$code] = [
                'label' => $meta['label'],
                'subjects' => $rows->map(function ($row) {
                    return [
                        'id' => $row->md_id,
                        'name' => $row->md_name,
                        'code' => $row->md_code,
                        'total_papers' => (int) ($row->md_misc3 ?: 1),
                    ];
                })->values(),
            ];
        }

        return $catalog;
    }

    private function subjectCategoryMap(): array
    {
        $map = [];
        foreach ($this->subjectCatalog() as $code => $group) {
            foreach ($group['subjects'] as $subject) {
                $map[$subject['id']] = $code;
            }
        }
        return $map;
    }
}