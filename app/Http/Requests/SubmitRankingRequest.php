<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitRankingRequest extends FormRequest
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
            'rankings' => 'required|array|size:11',
            'rankings.*.player_id' => 'required|distinct|exists:players,id',
            'rankings.*.rank' => [
                'required',
                'integer',
                'distinct',
                'between:1,11',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'rankings.size' => 'You must rank exactly 11 players.',
            'rankings.*.rank.distinct' => 'Duplicate ranks are not allowed.',
            'rankings.*.player_id.distinct' => 'Duplicate players are not allowed.',
        ];
    }

}

