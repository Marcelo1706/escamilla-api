@csrf
@if (isset($region) && $region->id)
    @method('PUT')
@endif
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Nombre de la Región*
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="name" name="name" type="text" value="{{ old('name', $region->name ?? '') }}" required>
        @error('name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">
        Imagen Banner*
    </label>
    @if (isset($region) && $region->banner_image)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $region->banner_image) }}" alt="Banner actual"
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


@vite(['resources/js/form.js'])
