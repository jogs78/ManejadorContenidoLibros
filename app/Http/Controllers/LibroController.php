<?php

namespace App\Http\Controllers;

use App\libros;
use App\versiones;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validarDatos = $request->validate([
            'nombreL' => 'required',
            'descripcionL' => 'required',
            'autorL' => 'required',
            'categoriaL' => 'required',
            'fpubliL' => 'required',
        ]);

        $nuevoLibro = new libros;
        $nuevoLibro->nombre = $request->input('nombreL');
        $nuevoLibro->descripcion = $request->input('descripcionL');
        $nuevoLibro->autor = $request->input('autorL');
        $nuevoLibro->idcategoria = $request->input('categoriaL');
        $nuevoLibro->actualizado = $request->input('fpubliL');
        $nuevoLibro->version = 1.0;
        $nuevoLibro->save();
        
        $versionN = new versiones();
        $versionN->idlibro = $nuevoLibro->id;
        $versionN->version = $nuevoLibro->version;
        $versionN->nombre = $nuevoLibro->nombre;
        $versionN->descripcion = $nuevoLibro->descripcion;
        $versionN->save();

        return back()->with('mensajeExitoLibro', 'Bien hecho, se ha registrado tu libro para ser sometido a votación!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\libros  $libros
     * @return \Illuminate\Http\Response
     */
    public function show(libros $libros)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\libros  $libros
     * @return \Illuminate\Http\Response
     */
    public function edit(libros $libros)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\libros  $libros
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->has("siOno")){
            $libro = libros::where('id',$request->idLibroAceptar)->first();  
            if($request->siOno == true){
                $libro->aceptado = true;
                $libro->save();
                return back()->with('mensajeExitoLibro', 'Se ha aceptado la publicación');
            }else{
                $libro->aceptado = false;
                $libro->save();
                return back()->with('mensajeExitoLibro', 'No se ha aceptado la publicación');
            }
        }else{
            $libro = libros::where('id',$request->idLibro)->first();

            $versionActual=$libro->version;
            $versionActual++;

            $libro->nombre = $request->nombreL;
            $libro->descripcion = $request->descripcionL;
            $libro->version = $versionActual;
            $libro->save();

            

            $versionN = new versiones();
            $versionN->idlibro = $libro->id;
            $versionN->version = $versionActual;
            $versionN->nombre = $request->nombreL;
            $versionN->descripcion = $request->descripcionL;
            $versionN->save();
        }
        
        return back()->with('mensajeExitoLibro', 'Cambio realizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\libros  $libros
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $libro = libros::find($id);
        $libro->delete();
        return back()->with('mensajeExitoLibro', 'Se ha eliminado el libro correctamente');
    }
}
