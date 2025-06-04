<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- Tarjeta: Administrar regiones --}}
                        <a href="{{ route('admin.regions.index') }}" class="block bg-green-100 hover:bg-green-200 transition p-6 rounded-xl shadow-md text-center">
                            <div class="text-green-600 text-4xl mb-4">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800 mb-2">
                                Administrar regiones
                            </div>
                            <p class="text-sm text-gray-700">
                                Configurar las regiones que agruparán paquetes. Aparecen en el sitio web como <strong>"Paquetes en el mundo"</strong>.
                            </p>
                        </a>

                        {{-- Tarjeta: Administrar paquetes --}}
                        <a href="{{ route('admin.packages.index') }}" class="block bg-blue-100 hover:bg-blue-200 transition p-6 rounded-xl shadow-md text-center">
                            <div class="text-blue-600 text-4xl mb-4">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800 mb-2">
                                Administrar paquetes
                            </div>
                            <p class="text-sm text-gray-700">
                                Cada uno de los paquetes promocionales que aparecerán en el sitio.
                            </p>
                        </a>

                        {{-- Tarjeta: Banners de promoción --}}
                        <a href="{{ route('admin.promos.index') }}" class="block bg-yellow-100 hover:bg-yellow-200 transition p-6 rounded-xl shadow-md text-center">
                            <div class="text-yellow-600 text-4xl mb-4">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="text-lg font-semibold text-gray-800 mb-2">
                                Banners de promoción
                            </div>
                            <p class="text-sm text-gray-700">
                                Imágenes que aparecen en la parte superior de la página, justo abajo del buscador.
                            </p>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
