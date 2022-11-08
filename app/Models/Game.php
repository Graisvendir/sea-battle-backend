<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $creator_id
 * @property int $invited_id
 * @property int $player_turn_id
 * @property int $status_id
 * @property int $creator_ready
 * @property int $invited_ready
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User $invited
 * @property-read \App\Models\GameStatus $status
 * @property-read int|null $ships_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GameShip[] $ships
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatorReady($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereInvitedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereInvitedReady($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game wherePlayerTurnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereStatusId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GameShip[] $creatorShips
 * @property-read int|null $creator_ships_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GameShip[] $invitedShips
 * @property-read int|null $invited_ships_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GameShot[] $creatorShots
 * @property-read int|null $creator_shots_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GameShot[] $invitedShots
 * @property-read int|null $invited_shots_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GameShot[] $shots
 * @property-read int|null $shots_count
 */
class Game extends Model
{
    use HasFactory;

    // Позиция кораблей считается с 0
    const FIELD_MAX_HORIZONTAL_LENGTH = 10;
    const FIELD_MAX_VERTICAL_LENGTH = 10;

    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function invited(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(GameStatus::class, 'status_id');
    }

    public function ships(): HasMany
    {
        return $this->hasMany(GameShip::class, 'game_id');
    }

    public function creatorShips(): HasMany
    {
        return $this->ships()->where('user_id', $this->creator_id);
    }

    public function invitedShips(): HasMany
    {
        return $this->ships()->where('user_id', $this->invited_id);
    }

    public function getShipsByUserId(int $userId)
    {
        return match ($userId) {
            $this->creator_id => $this->creatorShips,
            $this->invited_id => $this->invitedShips,
            default => collect()
        };
    }

    public function shots(): HasMany
    {
        return $this->hasMany(GameShot::class, 'game_id');
    }

    public function creatorShots(): HasMany
    {
        return $this->shots()->where('user_id', $this->creator_id);
    }

    public function invitedShots(): HasMany
    {
        return $this->shots()->where('user_id', $this->invited_id);
    }

    public function getShotsByUserId(int $userId)
    {
        return match ($userId) {
            $this->creator_id => $this->creatorShots,
            $this->invited_id => $this->invitedShots,
            default => collect()
        };
    }
}
