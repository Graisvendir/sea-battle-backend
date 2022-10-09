<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameStatus
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $code
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameStatus whereCode($value)
 * @mixin \Eloquent
 */
class GameStatus extends Model
{
    use HasFactory;

    protected $table = 'game_statuses';
}
