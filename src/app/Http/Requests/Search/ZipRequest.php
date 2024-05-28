<?php

namespace App\Http\Requests\Search;

use App\Rules\Zipcode;
use Illuminate\Foundation\Http\FormRequest;

class ZipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "zip_code" => ["required", new Zipcode],
        ];
    }
}
