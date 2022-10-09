<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameMessage
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $game_id
 * @property int $user_id
 * @property string $message
 * @method static Builder|GameMessage newModelQuery()
 * @method static Builder|GameMessage newQuery()
 * @method static Builder|GameMessage query()
 * @method static Builder|GameMessage whereCreatedAt($value)
 * @method static Builder|GameMessage whereGameId($value)
 * @method static Builder|GameMessage whereId($value)
 * @method static Builder|GameMessage whereMessage($value)
 * @method static Builder|GameMessage whereUpdatedAt($value)
 * @method static Builder|GameMessage whereUserId($value)
 * @method static Builder|GameMessage loadByLastTime(int $lastTime, int $gameId)
 * @mixin \Eloquent
 */
class GameMessage extends Model
{
    use HasFactory;

    protected $table = 'game_messages';

    public function scopeLoadByLastTime(Builder $query, int $lastTime, int $gameId) {
        $lastTimeDate = now()->setTimestamp($lastTime)->format('Y-m-d H:i:s');

        /** @var static|Builder $query */
        return $query->whereGameId($gameId)
            ->where('created_at', '>', $lastTimeDate);
    }

}
