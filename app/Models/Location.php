<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lat',
        'lng',
        'street',
        'city',
        'state',
        'zip',
        'formatted_address',
        'processed',
        'location',
        'description',
    ];

    protected $appends = [
        'location',
    ];


    protected $casts = [
        'processed' => 'bool',
    ];

    /**
     * The following code was generated for use with Filament Google Maps
     *
     * php artisan fgm:model-code Location --lat=lat --lng=lng --location=location --terse
     */

    function getLocationAttribute(): array
    {
        return [
            "lat" => (float)$this->lat,
            "lng" => (float)$this->lng,
        ];
    }

    function setLocationAttribute(?array $location): void
    {
        if (is_array($location))
        {
            $this->attributes['lat'] = $location['lat'];
            $this->attributes['lng'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'lat',
            'lng' => 'lng',
        ];
    }

    public static function getComputedLocation(): string
    {
        return 'location';
    }


}
