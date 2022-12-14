<?php

namespace App\Http\Requests;

use App\Models\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    abstract public function validatedDTO(): DTOInterface;
}
