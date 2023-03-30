<?php

namespace TP\Building\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TP\Building\Domain\VO\BuildingType;
use TP\Building\Infrastructure\database\factory\BuildingFactory;
use TP\Shared\VO\Address;
use TP\Shared\VO\City;
use TP\Shared\VO\Id;
use TP\Shared\VO\Name;
use TP\Shared\VO\PostalCode;
use TP\Shared\VO\StringValue;


class Building extends Model {

    use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	protected $appends = ['nb_location', 'nb_tenant'];

    protected static function newFactory(): BuildingFactory
    {
        return BuildingFactory::new();
    }

    public function toDomain(): \TP\Building\Domain\Building
    {
        return \TP\Building\Domain\Building::create(
            new Name($this->name),
            new Address($this->address),
            new PostalCode($this->postal_code),
            new City($this->city),
            new BuildingType($this->type),
            $this->description ?
                new StringValue($this->desciption) :
                null,
            new Id($this->uuid)
        );
    }
}
