<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastMessage extends Model
{
    protected $table = 'broadcast_messages';

    protected $fillable = [
        'subject',
        'body',
        'sender_id',
        'schools_mode',
        'users_mode',
        'priority',
        'recipients_count',
        'schools_count',
        'users_count',
    ];

    public const MODE_LABELS = [
        'none'     => 'None',
        'all'      => 'All',
        'selected' => 'Selected',
    ];

    public const PRIORITY_LABELS = [
        'normal'    => 'Normal',
        'important' => 'Important',
        'urgent'    => 'Urgent',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients()
    {
        return $this->hasMany(BroadcastMessageRecipient::class, 'broadcast_message_id');
    }

    public function schoolRecipients()
    {
        return $this->recipients()->where('recipient_type', 'school');
    }

    public function userRecipients()
    {
        return $this->recipients()->where('recipient_type', 'user');
    }

    /**
     * Human-friendly summary of who this was sent to, e.g.
     * "All Schools + 4 System Users" or "12 Schools" or "All System Users".
     */
    public function getAudienceLabelAttribute(): string
    {
        $parts = [];

        if ($this->schools_mode === 'all') {
            $parts[] = 'All Schools';
        } elseif ($this->schools_mode === 'selected') {
            $parts[] = $this->schools_count . ' School' . ($this->schools_count === 1 ? '' : 's');
        }

        if ($this->users_mode === 'all') {
            $parts[] = 'All System Users';
        } elseif ($this->users_mode === 'selected') {
            $parts[] = $this->users_count . ' System User' . ($this->users_count === 1 ? '' : 's');
        }

        return $parts ? implode(' + ', $parts) : 'No Recipients';
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITY_LABELS[$this->priority] ?? 'Normal';
    }

    /**
     * Excerpt used in the sent-messages list so long messages don't blow
     * up the table layout.
     */
    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->body), 110);
    }
}
