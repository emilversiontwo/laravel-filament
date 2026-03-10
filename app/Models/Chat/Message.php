<?php

namespace App\Models\Chat;

use App\Models\User;
use App\Policies\Message\MessagePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int $chat_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $body
 * @property Chat $chat
 * @property User $user
 * @property Message $parent
 */
#[UsePolicy(MessagePolicy::class)]
class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chat_id',
        'user_id',
        'parent_id',
        'body',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }
}
