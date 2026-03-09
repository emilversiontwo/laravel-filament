<?php

namespace App\Models\Chat;

use App\Models\User;
use App\Policies\Chat\ChatPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(ChatPolicy::class)]
class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'owner_user_id',
        'title',
    ];

    public function chatParticipants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class, 'chat_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }
}
