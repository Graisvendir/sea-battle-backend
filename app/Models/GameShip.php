<?php

namespace App\Models;

use App\Exceptions\Ship\ShipLengthNotFoundException;
use App\Models\DTO\Ships\ShipDTO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\GameShip
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $game_id
 * @property int $ship_id
 * @property int $user_id
 * @property int $x
 * @property int $y
 * @property string $orientation
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereOrientation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereShipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameShip whereY($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Ship $ship
 */
class GameShip extends Model
{
    use HasFactory;

    protected $table = 'game_ships';

    public static function make(ShipDTO $gameShipDTO): static
    {
        $ship = Ship::getByLength($gameShipDTO->getLenght());

        if (!$ship) {
            throw ShipLengthNotFoundException::make($gameShipDTO->getLenght());
        }

        $gameShip = new GameShip();
        $gameShip->id = $gameShipDTO->getId();
        $gameShip->x = $gameShipDTO->getX();
        $gameShip->y = $gameShipDTO->getY();
        $gameShip->orientation = $gameShipDTO->getOrientation();

        $gameShip->ship_id = $ship->id;

        return $gameShip;
    }

    public function ship(): BelongsTo
    {
        return $this->belongsTo(Ship::class, 'ship_id');
    }

    public function getLength(): int
    {
        return $this->ship->length;
    }
}
