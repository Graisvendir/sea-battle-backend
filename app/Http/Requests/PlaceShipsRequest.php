<?php

namespace App\Http\Requests;

use App\Models\DTO\DTOInterface;
use App\Models\DTO\Ships\PlaceShipDTO;
use App\Models\Game;
use App\Models\Ship;
use App\Rules\Ships\ShipOutOfRange;
use App\Rules\Ships\ShipsIntersectsRule;
use App\Services\FieldService;
use Illuminate\Validation\Rule;

class PlaceShipsRequest extends BaseRequest
{
    protected $stopOnFirstFailure = false;

    public function rules()
    {
        /** @var FieldService $fieldService */
        $fieldService = $this->container->get(FieldService::class);

        $curFieldMatrix = $fieldService->getCurrentFieldMatrix();
        $shipIntersectsRule = new ShipsIntersectsRule($curFieldMatrix);

        return [
            'ships' => ['required', 'array'],
            'ships.*' => ['required', 'array', new ShipOutOfRange(), $shipIntersectsRule],

            'ships.*.x'           => ['integer', 'min:0', 'max:' . Game::FIELD_MAX_HORIZONTAL_LENGTH],
            'ships.*.y'           => ['integer', 'min:0', 'max:' . Game::FIELD_MAX_VERTICAL_LENGTH],
            'ships.*.id'          => ['nullable', 'integer', 'exists:game_ships,id'],
            'ships.*.length'      => ['integer', 'exists:ships,length'],
            'ships.*.orientation' => ['string', Rule::in([Ship::VERTICAL_ORIENTATION, Ship::HORIZONTAL_ORIENTATION])],
        ];
    }

    /**
     * @return PlaceShipDTO
     */
    public function validatedDTO(): DTOInterface
    {
        $validated = $this->validated();

        return new PlaceShipDTO($validated);
    }
}
