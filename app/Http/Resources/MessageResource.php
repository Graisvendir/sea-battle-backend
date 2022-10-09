<?php

namespace App\Http\Resources;

use App\Models\GameMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class MessageResource extends JsonResource {

    /** @var GameMessage $resource */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape([
        'my' => "bool",
        'time' => "int",
        'message' => "string"
    ])]
    public function toArray($request) {
        return [
            'my' => $this->resource->user_id === $request->user()->id,
            'time' => $this->resource->created_at->getTimestamp(),
            'message' => $this->resource->message,
        ];
    }
}
