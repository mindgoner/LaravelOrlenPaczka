<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mindgoner\LaravelOrlenPaczka\Models\OPLocation;

use Mindgoner\LaravelOrlenPaczka\Requests\GiveMeAllLocationWithAllData;

class OPUpdateLocationsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'op:update-locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update locations list from OrlenPaczka API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Getting updated locations list from OrlenPaczka API...');

        $startTime = microtime(true);
        $GiveMeAllLocationWithAllData = new GiveMeAllLocationWithAllData();
        $Locations = $GiveMeAllLocationWithAllData->get();
        $endTime = microtime(true);
        $this->info('Locations list updated in ' . round($endTime - $startTime, 2) . 's');

        $this->info('Updating locations list in database...');
        $startTime = microtime(true);
        foreach ($Locations as $location) {
            // Zamiana na tablicę dla ułatwienia masowego przypisania
            $locationData = [
                'DestinationCode' => (string) $location->DestinationCode,
                'StreetName' => (string) $location->StreetName,
                'City' => (string) $location->City,
                'District' => (string) $location->District,
                'Longitude' => (string) $location->Longitude,
                'Latitude' => (string) $location->Latitude,
                'Province' => (string) $location->Province,
                'CashOnDelivery' => filter_var((string) $location->CashOnDelivery, FILTER_VALIDATE_BOOLEAN),
                'OpeningHours' => (string) $location->OpeningHours,
                'Location' => (string) $location->Location,
                'PSD' => (string) $location->PSD,
                'Available' => (string) $location->Available === 'T', // Konwersja T/N na boolean
                'Obszar' => (string) $location->Obszar,
                'Mikrorejon' => (string) $location->Mikrorejon,
                'Skrotnrpok' => (string) $location->Skrotnrpok,
                'Sortownia' => (string) $location->Sortownia,
                'Presort' => (string) $location->Presort,
                'Czas' => (string) $location->Czas,
            ];
        
            // Aktualizacja lub utworzenie wpisu na podstawie DestinationCode
            OPLocation::updateOrCreate(
                ['DestinationCode' => $locationData['DestinationCode']], // Warunek znajdowania istniejącego wpisu
                $locationData // Dane do aktualizacji lub utworzenia
            );
        }
        $endTime = microtime(true);
        $this->info('Locations list updated in database in ' . round($endTime - $startTime, 2) . 's');

        return 0;
    }
}
