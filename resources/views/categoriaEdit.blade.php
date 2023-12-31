@extends('layouts.plantilla')
@section('contenido')

    <h1>Modificación de una categoría</h1>

    <div class="alert bg-light p-4 col-8 mx-auto shadow">
        <form action="/categoria/update" method="post">
        @method('patch')
        @csrf
            <div class="form-group">
                <label for="catNombre">Nombre de la categoría</label>
                <input type="text" name="catNombre"
                value="{{ old('catNombre', $categoria->catNombre) }}"
                       class="form-control" id="catNombre">
            </div>

            <input type="hidden" name="idCategoria"
            value="{{ $categoria->idCategoria }}">

            <button class="btn btn-dark my-3 px-4">Modificar categoría</button>
            <a href="/categorias" class="btn btn-outline-secondary">
                Volver a panel de categorías
            </a>
        </form>
    </div>
    @if( $errors->any() )
    <div class="alert alert-danger col-8 mx-auto">
        <ul>
            @foreach( $errors->all() as $error )
                <li><i class="bi bi-info-circle"></i>
                    {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
