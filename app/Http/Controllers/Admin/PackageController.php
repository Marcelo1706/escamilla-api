<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\PackageRegions;
use App\Models\PackageGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = TourPackage::all();
        $regions = PackageRegions::all();
        return view('admin.packages.index', compact('packages', 'regions'));
    }

    public function create()
    {
        $regions = PackageRegions::all();
        return view('admin.packages.create', ['package' => new TourPackage(), 'regions' => $regions]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validatePackage($request);

            // Guardar banner
            $bannerPath = $request->file('banner_image')->store('packages/banners', 'public');
            $validated['banner_image'] = $bannerPath;

            // Crear paquete
            $package = TourPackage::create($validated);

            // Guardar imágenes de galería
            $this->storeGalleryImages($request, $package);

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paquete creado exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    public function show(TourPackage $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(TourPackage $package)
    {
        $regions = PackageRegions::all();
        return view('admin.packages.edit', compact('package', 'regions'));
    }

    public function update(Request $request, TourPackage $package)
    {
        try {
            $validated = $this->validatePackage($request, true);

            // Actualizar banner si se proporciona uno nuevo
            if ($request->hasFile('banner_image')) {
                // Eliminar banner anterior
                Storage::disk('public')->delete($package->banner_image);
                
                $bannerPath = $request->file('banner_image')->store('packages/banners', 'public');
                $validated['banner_image'] = $bannerPath;
            }

            // Actualizar paquete
            $package->update($validated);

            // Agregar nuevas imágenes de galería
            $this->storeGalleryImages($request, $package);

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paquete actualizado exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    public function destroy(TourPackage $package)
    {
        // Eliminar banner
        Storage::disk('public')->delete($package->banner_image);
        
        // Eliminar imágenes de galería
        foreach ($package->galleryImages as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        // Eliminar paquete
        $package->delete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete eliminado exitosamente');
    }

    public function destroyGalleryImage(PackageGallery $galleryImage)
    {
        Storage::disk('public')->delete($galleryImage->image_path);
        $galleryImage->delete();
        return response()->json(['success' => true]);
    }

    private function validatePackage(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'gallery_images.*' => 'image',
            'region_id' => 'required|exists:package_regions,id',
            'is_promotion' => 'required|boolean',
            'flights' => 'required|boolean',
            'hotels' => 'required|boolean',
            'meals' => 'required|boolean',
            'transportation' => 'required|boolean',
            'assistance' => 'required|boolean',
            'baggage' => 'required|boolean',
            'tours' => 'required|boolean',
        ];

        if (!$isUpdate) {
            $rules['banner_image'] = 'required|image';
        } else {
            $rules['banner_image'] = 'nullable|image';
        }

        return $request->validate($rules);
    }

    private function storeGalleryImages(Request $request, TourPackage $package)
    {
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryPath = $image->store('packages/gallery', 'public');
                $package->galleryImages()->create(['image_path' => $galleryPath]);
            }
        }
    }
}