<?php

namespace Module\Infrastructure\Building\Console\Commands;

use Illuminate\Console\Command;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Company\Models\Company;

class FillCompanyUuidBuildings extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'building:fill_company_uuid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts company_uuid into buildings table related to corresponding company';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nbBuildingsUpdated = 0;
        $buildings = Building::whereNull('company_uuid')->get();
        foreach ($buildings as $building) {
            $company = Company::whereId($building->company_id)
                ->whereNotNull('uuid')
                ->first();
            if ($company) {
                $building->company_uuid = $company->uuid;
                $building->save();
                $nbBuildingsUpdated += 1;
            }
        }

        if ($nbBuildingsUpdated > 0) {
            $this->info($nbBuildingsUpdated . ' company_uuid inséré(s) avec succès dans la table buildings.');
        } else {
            $this->info('Aucun enregistrement à mettre à jour dans la table buildings.');
        }
    }
}