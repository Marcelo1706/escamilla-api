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
                    {{-- Add a card with an icon to the route admin.packages.index with the text "administrar paquetes" --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('admin.packages.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-box"></i> Administrar paquetes
                        </a>
                    </div>
                    {{-- Add a card with an icon to the route admin.regions.index with the text "administrar regiones" --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                        <a href="{{ route('admin.regions.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-globe"></i> Administrar regiones
                        </a>
                    </div>
                    {{-- Add a card with an icon to the route admin.promos.index with the text "administrar promociones" --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                        <a href="{{ route('admin.promos.index') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-tags"></i> Administrar promociones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
