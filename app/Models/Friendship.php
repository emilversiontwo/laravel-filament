<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int $friend_user_id
 * @property string $status
 * @property User $user
 * @property User $friendUser
 */
class Friendship extends Model
{
    protected $fillable = [
        'user_id',
        'friend_user_id',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function friendUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_user_id');
    }
}
