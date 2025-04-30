@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detalles del Paquete: {{ $package->name }}</h1>
        <div>
            <a href="{{ route('admin.packages.edit', $package) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                Editar
            </a>
            <a href="{{ route('admin.packages.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded p-6">
        <div class="mb-6">
            <img src="{{ asset('storage/' . $package->banner_image) }}" alt="Banner" class="w-full h-64 object-cover rounded">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-xl font-semibold mb-2">Información Básica</h2>
                <p><span class="font-bold">Nombre:</span> {{ $package->name }}</p>
                <p><span class="font-bold">Precio:</span> ${{ number_format($package->price, 2) }}</p>
                <p><span class="font-bold">Promoción:</span> {{ $package->is_promotion ? 'Sí' : 'No' }}</p>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold mb-2">Descripción</h2>
                <div class="prose max-w-none">
                    {!! $package->description !!}
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-4">Galería de Imágenes</h2>
            @if($package->galleryImages->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($package->galleryImages as $image)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="w-full h-48 object-cover rounded">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No hay imágenes en la galería.</p>
            @endif
        </div>
    </div>
</div>
@endsection