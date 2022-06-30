<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['productos']=Producto::paginate(2);
        return view('productos.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $campos=[
            'Nombre'=>'required|string|max:100',
            'Categoría'=>'required|string|max:100',
            'Stock'=>'required|integer',
            'Precio'=>'required|string|max:100',
            'Imagen'=>'required|max:10000|mimes:jpeg,jpg,png',
        ];

        $mensaje=[
            'required'=>'Debe ingresar un :attribute',
            'Imagen.required'=>'Debe ingresar una Imagen'
        ];

        $this->validate($request, $campos, $mensaje);

        //Se guarda la informacion en una variable omitiendo el dato "_token"
        $infoProducto = request()->except('_token');

        //Preguntamos si tiene imagen, si es así, guarda la imagen en "uploads"
        if($request->hasFile('Imagen')){
            $infoProducto['Imagen'] = $request->file('Imagen')->store('uploads', 'public');
        }

        //Se ingresa el producto en la base de datos
        Producto::insert($infoProducto);
        //Envia al usuario a la página de productos con un mensaje
        return redirect('productos')->with('mensaje', 'Producto agregado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto=Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos=[
            'Nombre'=>'required|string|max:100',
            'Categoría'=>'required|string|max:100',
            'Stock'=>'required|integer',
            'Precio'=>'required|string|max:100'
        ];

        $mensaje=[
            'required'=>'Debe ingresar un :attribute'
        ];

        // Revisa si existe un cambio en la imagen para enviar los mensajes correspondientes
        if($request->hasFile('Imagen')){
            $campos=['Imagen'=>'required|max:10000|mimes:jpeg,jpg,png'];
            $mensaje=['Imagen.required'=>'Debe ingresar una Imagen'];
        }

        // Valida los campos antes mencionados
        $this->validate($request, $campos, $mensaje);

        $infoProducto = request()->except('_token', '_method');

        if($request->hasFile('Imagen')){
            $producto=Producto::findOrFail($id);
            Storage::delete('public/'.$producto->Imagen);
            $infoProducto['Imagen'] = $request->file('Imagen')->store('uploads', 'public');
        }

        Producto::where('id','=',$id)->update($infoProducto);

        $producto=Producto::findOrFail($id);
        // return view('productos.edit', compact('producto'));
        return redirect('productos')->with('mensaje', 'Producto actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto=Producto::findOrFail($id);
        if(Storage::delete('public/'.$producto->Imagen)){

            Producto::destroy($id);
        }

        return redirect('productos')->with('mensaje', 'Producto eliminado');
    }
}
