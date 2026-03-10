<?php

namespace App\Models\Chat;

use App\Models\User;
use App\Policies\ChatParticipant\ChatParticipantPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int $chat_id
 * @property int $user_id
 * @property string $role
 * @property Chat $chat
 * @property User $user
 */
#[UsePolicy(ChatParticipantPolicy::class)]
class ChatParticipant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chat_id',
        'user_id',
        'role',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
