<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageGallery extends Model
{
    use HasFactory;

    protected $fillable = ['tour_package_id', 'image_path'];

    // Accessor para la URL completa de la imagen
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('storage/' . $this->image_path),
        );
    }
}