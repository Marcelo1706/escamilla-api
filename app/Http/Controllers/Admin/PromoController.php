<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoImage;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = PromoImage::all();
        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promos.create', ['promo' => new PromoImage()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validatePromo($request);

            // Guardar banner
            $bannerPath = $request->file('banner_image')->store('packages/banners', 'public');
            $validated['banner_image'] = $bannerPath;

            // Crear promoción
            PromoImage::create($validated);

            return redirect()->route('admin.promos.index')
                ->with('success', 'Promoción creada exitosamente');
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
        $promo = PromoImage::findOrFail($id);
        return view('admin.promos.show', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promo = PromoImage::findOrFail($id);
        return view('admin.promos.edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $promo = PromoImage::findOrFail($id);

        try {
            $validated = $this->validatePromo($request, true);

            // Actualizar banner si se proporciona uno nuevo
            if ($request->hasFile('banner_image')) {
                // Eliminar banner anterior
                if ($promo->banner_image) {
                    \Storage::disk('public')->delete($promo->banner_image);
                }
                
                $bannerPath = $request->file('banner_image')->store('packages/banners', 'public');
                $validated['banner_image'] = $bannerPath;
            }

            // Actualizar promoción
            $promo->update($validated);

            return redirect()->route('admin.promos.index')
                ->with('success', 'Promoción actualizada exitosamente');
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
        $promo = PromoImage::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promoción eliminada con éxito.');
    }

    private function validatePromo(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ];

        if ($isUpdate) {
            $rules['banner_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096';
        }

        return $request->validate($rules);
    }
}
