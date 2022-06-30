{{-- Muestra los errores al llenar el formulario --}}
@if (count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Muestra el titulo de la página acorde al método --}}
<h2>{{ $modo }} Producto</h2>

{{-- Contenido del formulario --}}
<div class="form-group">
    <label for="Nombre">Nombre</label>
    <input class="form-control" type="text" name="Nombre" id="Nombre"
        value="{{ isset($producto->Nombre) ? $producto->Nombre:old('Nombre') }}">
</div>

<div class="form-group">
    <label for="Categoría">Categoría</label>
    <input class="form-control" type="text" name="Categoría" id="Categoría"
        value="{{ isset($producto->Categoría) ? $producto->Categoría : old('Categoría') }}">
</div>

<div class="form-group">
    <label for="Stock">Stock</label>
    <input type="number" class="form-control" name="Stock" id="Stock"
        value="{{ isset($producto->Stock) ? $producto->Stock : old('Stock') }}">
</div>

<div class="form-group">
    <label for="Precio">Precio</label>
    <input type="text" class="form-control" name="Precio" id="Precio"
        value="{{ isset($producto->Precio) ? $producto->Precio : old('Precio') }}">
</div>

<div class="form-group">
    <label for="Imagen">Imagen: </label>
    @if (isset($producto->Imagen))
        <img src="{{ asset('storage') . '/' . $producto->Imagen }}" class="img-thumbnail" width="100">
    @endif
    <input type="file" name="Imagen" class="form-control" id="Imagen" value="">
</div>
<br>
<input type="submit" class="btn btn-success" value="{{ $modo }} producto">
<a href="{{ url('productos') }}" class="btn btn-primary">Volver a la lista de productos</a>
