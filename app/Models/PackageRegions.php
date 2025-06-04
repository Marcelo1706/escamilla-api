<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PackageRegions extends Model
{
    protected $fillable = [
        'name',
        'banner_image',
    ];

    // Accessor para la URL completa del banner
    protected function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->banner_image ? asset("storage/{$this->banner_image}") : null,
        );
    }

    // Relación con los paquetes turísticos
    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class, 'region_id');
    }
}
