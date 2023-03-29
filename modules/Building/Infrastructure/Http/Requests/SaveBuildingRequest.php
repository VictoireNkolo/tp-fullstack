<?php

namespace Module\Infrastructure\Building\Http\Requests;

use Module\Shared\Infrastructure\Request\HttpDataRequest;

class SaveBuildingRequest extends HttpDataRequest
{

    public function messages(): array
    {
        return [
            'company_id.required'  => "Veuillez sélectionner la compagnie",
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
            'company_id'  => 'required',
            'name'        => 'required|string|max:255',
            'address'     => 'required',
            'city'        => 'required',
            'postal_code' => 'required'
        ];
    }
}