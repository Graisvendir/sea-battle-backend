<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс типов кораблей.
 *
 * Задает длину и максимальное количество на поле
 *
 * App\Models\Ship
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $length
 * @property int $max_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ship query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereMaxCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ship extends Model
{

    use HasFactory;

    const VERTICAL_ORIENTATION = 'vertical';
    const HORIZONTAL_ORIENTATION = 'horizontal';

    protected $table = 'ships';
    protected static array $ships = [];

    public static function getByLength(int $length): ?static
    {
        if (static::$ships) {
            return static::$ships[$length] ?: null;
        }

        static::$ships = static::all()->keyBy('length')->all();

        return static::$ships[$length] ?: null;
    }
}
