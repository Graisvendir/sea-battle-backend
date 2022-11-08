<?php

namespace App\Http\Resources;

use App\Models\DTO\FieldDTO;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @property Game $resource
 */
class GameResource extends ShortGameResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $resource = $this->resource;
        /** @var User $user */
        $user = $request->user();

        $enemyUser = $user->id === $resource->creator_id ? $resource->invited : $resource->creator;

        $myFieldDto = FieldDTO::make(
            $resource->getShipsByUserId($user->id),
            $resource->getShotsByUserId($user->id)
        );
        $enemyFieldDto = FieldDTO::make(
            $resource->getShipsByUserId($enemyUser->id),
            $resource->getShotsByUserId($enemyUser->id)
        );

        return array_merge(
            $data,
            [
                'fieldMy'    => FieldResource::make($myFieldDto),
                'fieldEnemy' => FieldResource::make($enemyFieldDto),
            ]
        );
    }
}
