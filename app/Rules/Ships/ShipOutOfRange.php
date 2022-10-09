<?php

namespace App\Rules\Ships;

use App\Models\Game;
use App\Models\Ship;
use Illuminate\Contracts\Validation\Rule;

/**
 * Валидация габаритов корабля.
 * Проверяем, что корабль со своей длиной влезает в поле
 */
class ShipOutOfRange implements Rule {

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $x           = (int) $value['x'];
        $y           = (int) $value['y'];
        $length      = (int) $value['length'] - 1; // считаем с 0
        $orientation = $value['orientation'];

        if ($orientation === Ship::HORIZONTAL_ORIENTATION) {
            return ($x + $length) < Game::FIELD_MAX_HORIZONTAL_LENGTH
                && $y < Game::FIELD_MAX_VERTICAL_LENGTH;
        }

        return ($y + $length) < Game::FIELD_MAX_VERTICAL_LENGTH
            && $x < Game::FIELD_MAX_HORIZONTAL_LENGTH;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'Ship  out of range';
    }
}
