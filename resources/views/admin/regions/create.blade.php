@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Crear Nueva Región</h1>

        <div class="bg-white shadow-md rounded p-6">
            <form action="{{ route('admin.regions.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.regions._form')
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar Región
                    </button>
                    <a href="{{ route('admin.regions.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">
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
