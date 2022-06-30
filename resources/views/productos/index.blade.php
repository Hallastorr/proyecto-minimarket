@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Mensaje que aparecerá cuando se cree o edite un producto --}}
        @if (Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Boton para agregar nuevo producto --}}
        <a href="{{ url('productos/create') }}" class="btn btn-primary">Ingresar nuevo producto</a>
        <br>
        <br>
        {{-- Tabla del contenido de productos --}}
        <table class="table table-light align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- foreach para llenar la tabla con los productos existentes --}}
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->Nombre }}</td>
                        <td>{{ $producto->Categoría }}</td>
                        <td>{{ $producto->Stock }}</td>
                        <td>{{ $producto->Precio }}</td>
                        <td>
                            {{-- Busca la imagen en el storage para mostrarla--}}
                            <img class="img-thumbnail" src="{{ asset('storage') . '/' . $producto->Imagen }}"
                                width="100">
                        </td>
                        <td>
                            {{-- Editar producto --}}
                            <a href="{{ url('/productos/' . $producto->id . '/edit') }}"
                                class="btn btn-success">Editar</a>
                            |
                            {{-- Eliminar producto --}}
                            <form action="{{ url('/productos/' . $producto->id) }}" method="POST" class="d-inline">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input type="submit" value="Borrar" class="btn btn-danger"
                                    onclick="return confirm('¿Estas seguro que quieres borrar el producto?')">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Crea los botones de paginación --}}
        {{ $productos->links() }}
    </div>
@endsection
