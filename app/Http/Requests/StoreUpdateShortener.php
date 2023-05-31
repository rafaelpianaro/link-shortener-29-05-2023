<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreUpdateShortener extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules =  [
            'identifier' => [
                // Rule::unique('shorteners')->where(fn (Builder $query) => $query->whereNull('deleted_at'))
                // Rule::unique('shorteners')->whereNull('deleted_at')
                // 'required', Rule::unique('shorteners')->whereNull('deleted_at')
                Rule::unique('shorteners')->where(function($query){return $query->where('deleted_at','=',null);})
            ],
            'url' => [
                'required',
                'min:5',
                'max:50'
            ],
            'title' => [
                'required',
                'min:5',
                'max:50'
            ],
        ];
        // TODO
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['identifier'] = [
                Rule::unique('shorteners')->ignore($this->shortener ?? $this->identifier) 
            ];
        }

        return $rules;
    }

    public function messages()
	{
		return
			[
				'url.required' => 'Campo obrigatório.',
				'url.min' => 'Mínimo :min caracteres.',
				'url.max' => 'Mínimo :max caracteres.',
				'title.required' => 'Campo obrigatório.',
				'title.min' => 'Mínimo :min caracteres.',
				'title.max' => 'Máximo :max caracteres.',
				'identifier.required' => 'Campo obrigatório.',
				'identifier.min' => 'Mínimo :min caracteres.',
				'identifier.max' => 'Máximo :min caracteres.',
				'identifier.unique' => 'Registro já existente no banco de dados.',
			];
	}

    public function withValidator($validator)
    {
        $validator->sometimes('identifier', 'required|min:6|max:8', function ($input) {
            if(isset($input['identifier']))
				return true;
			else
				return false;
        });
    }
}
