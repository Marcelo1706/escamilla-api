@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Crear Nuevo Paquete Turístico</h1>

        <div class="bg-white shadow-md rounded p-6">
            <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.packages._form')
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar Paquete
                    </button>
                    <a href="{{ route('admin.packages.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Asegurarse de que el editor esté inicializado antes de enviar el formulario
            document.querySelector('form').addEventListener('submit', function() {
                const editor = window.editorInstance;
                if (editor) {
                    document.getElementById('description').value = editor.getHTML();
                }
            });
        });
    </script>
@endpush
