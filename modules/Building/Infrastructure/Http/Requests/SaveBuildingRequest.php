<?php

namespace TP\Building\Infrastructure\Http\Requests;


use TP\Shared\Infrastructure\Request\HttpDataRequest;

class SaveBuildingRequest extends HttpDataRequest
{

    public function messages(): array
    {
        return [
            'name.required'        => "Veuillez entrer le nom de l'immeuble",
            'name.max'             => "Veuillez entrer un libellé avec moins de 255 caractères",
            'address.required'     => "Veuillez entrer l'adresse de l'immeuble",
            'city.required'        => "Veuillez entrer la ville",
            'postal_code.required' => "Veuillez entrer le code postal",
        ];
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'address'     => 'required',
            'city'        => 'required',
            'postal_code' => 'required'
        ];
    }
}
