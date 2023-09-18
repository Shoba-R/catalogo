@extends('layouts.plantilla')
@section('contenido')

    <h1 class="mb-4">Baja de una Categoria</h1>

    <div class="alert shadow text-danger col-6 mx-auto p-4">


        Se eliminará la Categoria:
        <span class="lead">
                {{ $categoria->catNombre }}
            </span>
        <form action="/categoria/destroy" method="post">
        @method('delete')
        @csrf
            <input type="hidden" name="catNombre"
                   value="{{ $categoria->catNombre }}">
            <input type="hidden" name="idCategoria"
                   value="{{ $categoria->idCategoria }}">
            <button class="btn btn-danger btn-block my-3">
                Confirmar baja
            </button>
            <a href="/categorias" class="btn btn-light btn-block">
                volver a panel
            </a>
        </form>
    </div>
    <script>
        Swal.fire(
            '¡Advertencia!',
            'Si pulsa el botón "Confirmar baja", se eliminará la categoria seleccionada',
            'warning'
        );
    </script>

@endsection
