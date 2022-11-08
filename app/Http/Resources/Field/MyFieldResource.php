<?php

namespace App\Http\Resources\Field;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Game $resource
 */
class MyFieldResource extends JsonResource
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
