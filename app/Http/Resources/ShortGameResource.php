<?php

namespace App\Http\Resources;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Game $resource
 */
class ShortGameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        /** @var User $user */
        $user = $request->user();

        $meReady = $user->id === $resource->creator_id ? $resource->creator_ready : $resource->invited_ready;

        return [
            'id'        => $resource->id,
            'status'    => $resource->status->code,
            'invite'    => $resource->invited->code,
            'myTurn'    => $user->id === $resource->player_turn_id,
            'meReady'   => $meReady,
        ];
    }
}
