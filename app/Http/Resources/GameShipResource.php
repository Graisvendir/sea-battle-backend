<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Game $resource
 */
class GameShipResource extends JsonResource
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

        return [

        ];
    }
}
