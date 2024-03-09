<?php

namespace App\Http\Requests\Tracks;

use App\Enums\AutoloadTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class LikeUnlikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return HttpResponseException
     *
     */
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        $errors = $validator->errors();

        $response = response()->json([
            'error' => implode(' ', $errors->all()),
        ], 400);

        throw new HttpResponseException($response);
    }

//    /**
//     * Prepare the data for validation.
//     *
//     * @return void
//     */
//    protected function prepareForValidation(): void
//    {
//
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'track_id' => ['required', 'integer', 'exists:App\Models\Track,id']
        ];
    }
}
