<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\File;

use Illuminate\Support\Facades\Storage;



class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



          /*recupera todos los registros de la table files, pero hacer la consulta segun el tipo de usuario*/
          $files = File::where('user_id',auth()->user()->id)->paginate(30);


        /*Recupera la vista que se encuetra dentro de admin*/
        return view('admin.files.index',compact('files'));

      


      

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('admin.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validación a nivel backend para que no suban imagenes mayores a los 2MB.
          /*$request->validate([
            'file'=>'required|image|max:2048'
        ]);
        */


       
        
        
        //return $request->all(); cambio para poder rescatar la imagen

         /*Recuerda crear nuevamente un link storange, cuando quieras subir el proyecto a un servidor real.*/

         //file es el nombre del input


       // return $request->file('file')->store('public/imagenes');
            
      $imagenes = $request->file('file')->store('public/imagenes');
        
       $url = Storage::url($imagenes);

       File::create([

           'user_id' => auth()->user()->id,
           'url' => $url
       ]);


      


      

      
    
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($file)
    {
        return view('admin.files.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($file)
    {
        return view('admin.files.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FILE $file)
    {
        

         $url = str_replace('storage', 'public', $file->url);
         Storage::delete($url);


         $file->delete();

         return redirect()->route('admin.files.index')->with('eliminar', 'ok');
    }
}
