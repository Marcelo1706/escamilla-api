<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PackageRegions;
use App\Models\TourPackage;
use App\Models\PromoImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PackageController extends Controller
{
    public function allInfo()
    {
        $promos = PromoImage::all()
            ->map(fn($promo) => [
                'name' => $promo->name,
                'banner' => $promo->banner_url // Usamos el accessor
            ]);

        $packages = TourPackage::where('is_promotion', true)
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'banner' => $item->banner_url, // Usamos el accessor
                'flights' => $item->flights,
                'hotels' => $item->hotels,
                'meals' => $item->meals,
                'transportation' => $item->transportation,
                'assistance' => $item->assistance,
                'baggage' => $item->baggage,
                'tours' => $item->tours,
            ]);

        $regions = PackageRegions::all(['id', 'name', 'banner_image'])
            ->map(fn($region) => [
                'id' => $region->id,
                'name' => $region->name,
                'banner' => $region->banner_url
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
            'flights' => $package->flights,
            'hotels' => $package->hotels,
            'meals' => $package->meals,
            'transportation' => $package->transportation,
            'assistance' => $package->assistance,
            'baggage' => $package->baggage,
            'tours' => $package->tours,
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

    public function regionPackages(Request $request)
    {
        $region = PackageRegions::findOrFail($request->id);
        $packages = $region->tourPackages()
            ->get(['id', 'name', 'price', 'banner_image'])
            ->map(fn($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'banner' => $item->banner_url, // Usamos el accessor
            ]);

        return response()->json([
            'region' => [
                'id' => $region->id,
                'name' => $region->name,
                'banner' => $region->banner_url
            ],
            'packages' => $packages
        ]);
    }

    public function getRegions()
    {
        $regions = PackageRegions::all(['id', 'name', 'banner_image'])
            ->map(fn($region) => [
                'id' => $region->id,
                'name' => $region->name,
                'banner' => $region->banner_url
            ]);

        return response()->json($regions);
    }
}