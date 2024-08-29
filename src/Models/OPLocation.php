<?php

namespace Mindgoner\LaravelOrlenPaczka\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPLocation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orlen_paczka_locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'DestinationCode',
        'StreetName',
        'City',
        'District',
        'Longitude',
        'Latitude',
        'Province',
        'CashOnDelivery',
        'OpeningHours',
        'Location',
        'PSD',
        'Available',
        'Obszar',
        'Mikrorejon',
        'Skrotnrpok',
        'Sortownia',
        'Presort',
        'PointType',
        'Czas',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'CashOnDelivery' => 'boolean',
        'Available' => 'boolean', // Konwersja T/N na boolean
    ];
}
