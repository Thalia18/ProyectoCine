<?php

namespace App\Http\Controllers;

use App\pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeliculasController extends Controller
{

    public function list()
    {
        return json_encode(pelicula::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'claid' => 'numeric|min:1|max:999999999',
            'nombre' => 'required|min:1|max:50',
            'fechadelanzamiento' => 'date',
            'duracion' => 'numeric|min:1|max:2147483647',
            'sinopsis' => 'required',
            'trailer' => 'url',
            'portada' => 'url',
        ]);

        $pelicula = pelicula::create($request->all());
        return json_encode($pelicula);
    }


    public function peliculaId($id)
    {
        return json_encode(pelicula::findOrFail($id));
    }


    public function put(Request $request, $id)
    {
        $request->validate([
            'claid' => 'numeric|min:1|max:999999999',
            'nombre' => 'required|min:1|max:50',
            'fechadelanzamiento' => 'date',
            'duracion' => 'numeric|min:1|max:2147483647',
            'sinopsis' => 'required',
            'trailer' => 'url',
            'portada' => 'url',
        ]);
        $pelicula = pelicula::findOrFail($id);
        $pelicula->claid = $request->get('claid');
        $pelicula->nombre = $request->get('nombre');
        $pelicula->fechadelanzamiento = $request->get('fechadelanzamiento');
        $pelicula->duracion = $request->get('duracion');
        $pelicula->sinopsis = $request->get('sinopsis');
        $pelicula->trailer = $request->get('trailer');
        $pelicula->portada = $request->get('portada');

        $pelicula->save();

        return $pelicula;
    }

    public function remove($id)
    {
        pelicula::findOrFail($id)->delete();
        return http_response_code(200);
    }
    public function getListIni()
    {
        $count = DB::table('peliculas')->paginate(3);

        $info = ["count" => $count->total(), "pages" => $count->lastPage(), "next" => $count->nextPageUrl(), "prev" => $count->previousPageUrl()];
        $results = $count->items();
        $paginador = ["info" => $info, "results" => $results];

        return json_encode($paginador);
    }
}
