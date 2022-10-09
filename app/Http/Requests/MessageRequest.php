<?php

namespace App\Http\Requests;

use App\Models\DTO\MessageDTO;

class MessageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        return [
            'message' => substr($this->message, 0, 250)
        ];
    }

    public function validatedObject(): MessageDTO
    {
        $validated = $this->validated();

        $messageDto = new MessageDTO();
        $messageDto->setId($validated['id'])
            ->setMessage($validated['message']);

        return $messageDto;
    }
}
