<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'banner_image',
        'region_id',
    ];

    public function galleryImages()
    {
        return $this->hasMany(PackageGallery::class);
    }

    // Accessor para la URL completa del banner
    protected function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->banner_image ? asset('storage/' . $this->banner_image) : null,
        );
    }

    // Relación con la región del paquete
    public function region()
    {
        return $this->belongsTo(PackageRegions::class, 'region_id');
    }
}