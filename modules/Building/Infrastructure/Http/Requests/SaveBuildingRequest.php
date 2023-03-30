<?php

namespace TP\Building\Infrastructure\Http\Requests;


use TP\Shared\Infrastructure\Request\HttpDataRequest;

class SaveBuildingRequest extends HttpDataRequest
{

    public function messages(): array
    {
        return [
            'name.required'        => "Veuillez entrer le nom",
            'address.required'     => "Veuillez entrer l'adresse",
            'city.required'        => "Veuillez entrer la ville",
            'postal_code.required' => "Veuillez entrer le code postal",
            'type.required'        => "Veuillez entrer le code postal",
        ];
    }

    public function rules(): array
    {
        return [
            'name'        => 'required',
            'address'     => 'required',
            'city'        => 'required',
            'postal_code' => 'required',
            'type'        => 'required',
        ];
    }
}
