@csrf
@if (isset($package) && $package->id)
    @method('PUT')
@endif
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Nombre del Paquete*
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="name" name="name" type="text" value="{{ old('name', $package->name ?? '') }}" required>
        @error('name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
            Precio*
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="price" name="price" type="number" step="0.01" min="0"
            value="{{ old('price', $package->price ?? '') }}" required>
        @error('price')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="region_id">
        Región*
    </label>
    <select
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="region_id" name="region_id" required>
        <option value="">Seleccione una región</option>
        @foreach ($regions as $region)
            <option value="{{ $region->id }}"
                {{ (old('region_id', $package->region_id ?? '') == $region->id) ? 'selected' : '' }}>
                {{ $region->name }}
            </option>
        @endforeach
    </select>
    @error('region_id')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
        Descripción*
    </label>
    <textarea class="form-control" name="description" id="description" required>{{ old('description', $package->description ?? '') }}</textarea>
    @error('description')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">
        Imagen Banner*
    </label>
    @if (isset($package) && $package->banner_image)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $package->banner_image) }}" alt="Banner actual"
                class="h-32 object-cover rounded">
        </div>
    @endif
    <input type="file" name="banner_image" id="banner_image" class="hidden" accept="image/*">
    <div id="banner-dropzone"
        class="dropzone border-2 border-dashed rounded p-4 text-center cursor-pointer hover:bg-gray-50">
        <p class="text-gray-600">Arrastra la imagen del banner aquí o haz clic para seleccionar</p>
        <p class="text-sm text-gray-500 mt-1">Tamaño recomendado: 1200x600px</p>
    </div>
    @error('banner_image')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">
        Galería de Imágenes
    </label>
    <input type="file" name="gallery_images[]" id="gallery_images" class="hidden" accept="image/*" multiple>
    <div id="gallery-dropzone"
        class="dropzone border-2 border-dashed rounded p-4 text-center cursor-pointer hover:bg-gray-50">
        <p class="text-gray-600">Arrastra las imágenes de la galería aquí o haz clic para seleccionar</p>
        <p class="text-sm text-gray-500 mt-1">Máximo 10 imágenes</p>
    </div>
    <div id="gallery-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-2">
        @if (isset($package) && $package->galleryImages->count() > 0)
            @foreach ($package->galleryImages as $image)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-32 object-cover rounded">
                    <button type="button"
                        class="absolute top-0 right-0 bg-red-500 text-white p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                        onclick="removeGalleryImage(this, {{ $image->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach
        @endif
    </div>
    @error('gallery_images')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('gallery_images.*')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="is_promotion" value="0">
        <input type="checkbox" name="is_promotion" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('is_promotion', $package->is_promotion ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Es promoción?</span>
    </label>
    @error('is_promotion')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="flights" value="0">
        <input type="checkbox" name="flights" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('flights', $package->flights ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye vuelos?</span>
    </label>
    @error('flights')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="hotels" value="0">
        <input type="checkbox" name="hotels" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('hotels', $package->hotels ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye hoteles?</span>
    </label>
    @error('hotels')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="meals" value="0">
        <input type="checkbox" name="meals" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('meals', $package->meals ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye Alimentación?</span>
    </label>
    @error('meals')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="transportation" value="0">
        <input type="checkbox" name="transportation" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('transportation', $package->transportation ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye Transporte?</span>
    </label>
    @error('transportation')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="assistance" value="0">
        <input type="checkbox" name="assistance" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('assistance', $package->assistance ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye Asistencia?</span>
    </label>
    @error('assistance')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="baggage" value="0">
        <input type="checkbox" name="baggage" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('baggage', $package->baggage ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye Equipaje?</span>
    </label>
    @error('baggage')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="hidden" name="tours" value="0">
        <input type="checkbox" name="tours" value="1" class="form-checkbox h-5 w-5 text-blue-600"
            {{ old('tours', $package->tours ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">¿Incluye Tours?</span>
    </label>
    @error('tours')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>

@vite(['resources/js/form.js'])
