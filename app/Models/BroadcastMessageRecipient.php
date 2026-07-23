<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastMessageRecipient extends Model
{
    protected $table = 'broadcast_message_recipients';

    protected $fillable = [
        'broadcast_message_id',
        'recipient_type',
        'recipient_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(BroadcastMessage::class, 'broadcast_message_id');
    }

    public function isSchool(): bool
    {
        return $this->recipient_type === 'school';
    }

    public function isUser(): bool
    {
        return $this->recipient_type === 'user';
    }

    /**
     * The House or User this row points at. Not a real Eloquent relation
     * because houses uses a non-standard primary key ("ID"), so it can't
     * be resolved through morphTo().
     */
    public function recipientModel()
    {
        return $this->isSchool()
            ? House::where('ID', $this->recipient_id)->first()
            : User::find($this->recipient_id);
    }

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update(['is_read' => true, 'read_at' => now()]);
        }
    }
}
