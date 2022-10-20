<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\User
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $code
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Game $createdGame
 * @property-read Game $invitedGame
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCode($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id'];

    public function createdGame(): HasOne
    {
        return $this->hasOne(Game::class, 'creator_id');
    }

    public function invitedGame(): HasOne
    {
        return $this->hasOne(Game::class, 'invited_id');
    }

    public function game(): Game
    {
        return $this->createdGame ?: $this->invitedGame;
    }

    /**
     * Создание нового пользователя с заполненным полем код
     *
     * @return static
     * @throws \Throwable
     */
    public static function createWithCode(): static
    {
        $user = new static();
        $user->code = Str::random();
        $user->saveOrFail();

        return $user;
    }
}
