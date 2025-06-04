<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PackageRegions;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PackageController extends Controller
{
    public function allInfo()
    {
        $promos = TourPackage::where('is_promotion', true)
            ->get(['id', 'name', 'banner_image'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->banner_url // Usamos el accessor
                ];
            });

        $packages = TourPackage::where('is_promotion', false)
            ->get(['id', 'name', 'price', 'banner_image'])
            ->map(fn($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'banner' => $item->banner_url // Usamos el accessor
            ]);

        $regions = PackageRegions::all(['id', 'name', 'banner_image'])
            ->map(fn($region) => [
                'id' => $region->id,
                'name' => $region->name,
                'banner' => $region->bannerUrl
            ]);

        return response()->json([
            'promos' => $promos,
            'packages' => $packages,
            'regions' => $regions
        ]);
    }

    public function packageDetail(Request $request)
    {
        $package = TourPackage::with(['galleryImages' => function($query) {
            $query->select(['id', 'tour_package_id', 'image_path']);
        }])->findOrFail($request->id);

        return response()->json([
            'id' => $package->id,
            'name' => $package->name,
            'price' => $package->price,
            'description' => $package->description,
            'banner' => $package->banner_url, // Usamos el accessor
            'images' => $package->galleryImages->map(function($image) {
                return $image->image_url; // Usamos el accessor del modelo PackageGallery
            })
        ]);
    }

    public function getHotelsFromAPI(Request $request)
    {
        $response = Http::get(env("API_URL")."/hotel-rating/hotels");
        return $response->json();
    }
}