<?php

namespace App\Http\Requests;

use App\Models\Game;
use App\Models\Ship;
use App\Rules\Ships\ShipOutOfRange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceShipsRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function rules()
    {
        return [
            '*' => ['required', 'array', new ShipOutOfRange()],

            '*.x'           => ['integer', 'min:0', 'max:' . Game::FIELD_MAX_HORIZONTAL_LENGTH],
            '*.y'           => ['integer', 'min:0', 'max:' . Game::FIELD_MAX_VERTICAL_LENGTH],
            '*.id'          => ['nullable', 'integer', 'exists:game_ships,id'],
            '*.length'      => ['integer', 'exists:ships,length'],
            '*.orientation' => ['string', Rule::in([Ship::VERTICAL_ORIENTATION, Ship::HORIZONTAL_ORIENTATION])],
        ];
    }
}
