<?php

namespace Module\Infrastructure\Building\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Module\Domain\Amortization\BuildingAmortization;
use Module\Infrastructure\Amortization\Models\Amortization;
use Module\Infrastructure\Building\database\factory\BuildingFactory;
use Module\Infrastructure\Company\Models\Company;
use Module\Infrastructure\Location\Models\Location;
use Module\Shared\VO\Address;
use Module\Shared\VO\City;
use Module\Shared\VO\Id;
use Module\Shared\VO\Name;
use Module\Shared\VO\PostalCode;


class Building extends Model {

    use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	protected $appends = ['nb_location', 'nb_tenant'];

	public function company(): BelongsTo
    {
		return $this->belongsTo(Company::class, 'company_uuid', 'uuid');
	}

	public function locations(): HasMany
    {
		return $this->hasMany(Location::class, 'building_uuid', 'uuid');
	}

	public function receipts(): HasMany
    {
	    return $this->hasMany(Receipt::class);
    }

    public function charges(): HasMany
    {
	    return $this->hasMany(Charge::class);
    }

    public function amortizations(): HasMany
    {
        return $this->hasMany(Amortization::class, 'building_uuid', 'uuid');
    }

    public function getNbLocationAttribute(): int
    {
        return $this->locations()->count();
    }

    public function getNbTenantAttribute(): int
    {
        $iNumber = 0;
        $locations    =   $this->locations()->get();
        foreach ($locations as $location) {
            $iNumber    += $location->tenant()->count();
        }
        return $iNumber;
    }

    public function getOnlyBuildingHasProduceMoney(string $start_date, string $end_date, int $company_id): \Illuminate\Support\Collection
    {
        $buildings  =   $this::where(['company_id' => $company_id])->get();
        $arrValidBuildings = [];
        if (!$buildings->isEmpty()) {
            foreach ($buildings as $building) {
                $hasReceipts    =   $this->checkIfBuildingHasReceipt($building->id, $start_date, $end_date);
                if ($hasReceipts) {
                    $arrValidBuildings[] = $building->id;
                    continue;
                }

                $hasCharges     =   $this->checkIfBuildingHasCharge($building->id, $start_date, $end_date);
                if ($hasCharges) {
                    $arrValidBuildings[] = $building->id;
                    continue;
                }

                $hasRents       =   $this->checkIfBuildingHasRent($building->id, $start_date, $end_date);
                if ($hasRents) {
                    $arrValidBuildings[] = $building->id;
                }
            }
        }
        return $this::whereIn('id', $arrValidBuildings)->get();
    }

    /**
     * @param string $start_date
     * @param string $end_date
     * @param int $company_id
     * @return array
     */
    public function getBuildingIdsForAccounting(string $start_date, string $end_date, int $company_id): array
    {
        $buildings  = $this->getOnlyBuildingHasProduceMoney( $start_date,  $end_date,  $company_id);
        $arrBuildingKeys = array_map(static function ($building) {
            return $building['id'];
        }, $buildings->toArray());

        $activeBuildings    =   $this::where(['company_id' => $company_id, 'is_active' => true])->get();
        foreach ($activeBuildings as $building) {
            if (!in_array($building->id, $arrBuildingKeys)) {
                $arrBuildingKeys[] = $building->id;
            }
        }
        return $arrBuildingKeys;
    }

    /**
     * @param int $building_id
     * @param string $start_date
     * @param string $end_date
     * @return bool
     */
    private function checkIfBuildingHasReceipt(int $building_id, string $start_date, string $end_date): bool
    {
        $receipts   =   Receipt::where(['building_id' => $building_id])
            ->whereHas('payment_intervals', function ($query) use ($start_date, $end_date) {
                return $query->whereDate('payment_date', '<=', $end_date)
                    ->whereDate('payment_date', '>=', $start_date);
            })->get();

        if ($receipts->isEmpty()) {
            return false;
        }
        return true;
    }

    /**
     * @param int $building_id
     * @param string $start_date
     * @param string $end_date
     * @return bool
     */
    private function checkIfBuildingHasCharge(int $building_id, string $start_date, string $end_date): bool
    {
        $charges   =   Charge::where(['building_id' => $building_id])
            ->whereHas('payment_intervals', function ($query) use ($start_date, $end_date) {
                return $query->whereDate('payment_date', '<=', $end_date)
                    ->whereDate('payment_date', '>=', $start_date);
            })->get();
        if ($charges->isEmpty()) {
            return false;
        }
        return true;
    }

    /**
     * @param int $building_id
     * @param string $start_date
     * @param string $end_date
     * @return bool
     */
    private function checkIfBuildingHasRent(int $building_id, string $start_date, string $end_date): bool
    {
        $rents      =   Rent::whereHas('payment_intervals', function ($query) use ($start_date, $end_date) {
            return $query->whereDate('payment_date', '<=', $end_date)
                ->whereDate('payment_date', '>=', $start_date);
        })
            ->whereHas('tenant.location.building', function ($query) use ($building_id) {
                return $query->where(['id' => $building_id]);
            })
            ->get();

        if ($rents->isEmpty()) {
            return false;
        }
        return true;
    }

    protected static function newFactory(): BuildingFactory
    {
        return BuildingFactory::new();
    }

    public function toAmortizationDomain(): BuildingAmortization
    {
        return BuildingAmortization::create(
            new Id($this->uuid)
        );
    }

    public function toDomain(): \Module\Domain\Building\Building
    {
        return \Module\Domain\Building\Building::create(
            new Name($this->name),
            new Address($this->address_line1),
            new PostalCode($this->postal_code),
            new City($this->city),
            new Id($this->company_uuid),
            new Id($this->uuid)
        );
    }
}
