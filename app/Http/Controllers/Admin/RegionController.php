<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackageRegions;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = PackageRegions::all();
        return view('admin.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.regions.create', ['region' => new PackageRegions()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateRegion($request);

            // Guardar banner
            $bannerPath = $request->file('banner_image')->store('packages/banners', 'public');
            $validated['banner_image'] = $bannerPath;

            // Crear región
            PackageRegions::create($validated);

            return redirect()->route('admin.regions.index')
                ->with('success', 'Región creada exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = PackageRegions::findOrFail($id);
        return view('admin.regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = PackageRegions::findOrFail($id);
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $region = PackageRegions::findOrFail($id);
        
        try {
            $validated = $this->validateRegion($request, true);

            // Actualizar banner si se proporciona uno nuevo
            if ($request->hasFile('banner_image')) {
                // Eliminar banner anterior
                if ($region->banner_image) {
                    \Storage::disk('public')->delete($region->banner_image);
                }
                
                $bannerPath = $request->file('banner_image')->store('packages/banners', 'public');
                $validated['banner_image'] = $bannerPath;
            }

            // Actualizar región
            $region->update($validated);

            return redirect()->route('admin.regions.index')
                ->with('success', 'Región actualizada exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = PackageRegions::findOrFail($id);
        $region->delete();

        return redirect()->route('admin.regions.index')->with('success', 'Región eliminada con éxito.');
    }

    private function validateRegion(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($isUpdate) {
            $rules['banner_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $request->validate($rules);
    }
}
