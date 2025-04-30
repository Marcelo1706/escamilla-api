@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Editar Paquete Turístico</h1>

        <div class="bg-white shadow-md rounded p-6">
            <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.packages._form')

                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar Paquete
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
            // Inicializar el editor con el contenido existente
            const description = document.getElementById('description').value;
            if (window.HugeEditor) {
                window.editorInstance = new window.HugeEditor({
                    selector: '#editor',
                    toolbar: ['bold', 'italic', 'underline', 'strike', 'link', 'image', 'list'],
                    height: 300
                });
                window.editorInstance.setHTML(description);
            }

            // Asegurarse de que el editor esté inicializado antes de enviar el formulario
            document.querySelector('form').addEventListener('submit', function() {
                if (window.editorInstance) {
                    document.getElementById('description').value = window.editorInstance.getHTML();
                }
            });
        });
    </script>
@endpush
