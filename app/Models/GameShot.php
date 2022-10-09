<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameShot
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $game_id
 * @property int $user_id
 * @property int $x
 * @property int $y
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShot whereY($value)
 * @mixin \Eloquent
 */
class GameShot extends Model
{
    use HasFactory;

    protected $table = 'game_shots';
}
