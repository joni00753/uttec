<?php

namespace App\Http\Controllers;

use App\Models\BcCondominios;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CondominiosController extends Controller
{
    public function index(){
        return view('pages.tables');
    }

    public function getCondiminios(){
        $codominios = BcCondominios::all();

        return $codominios;
    }

    public function store(Request $request){

        $rules = [
            'id_cliente' => 'required',
            'nombre' => 'required|max:255',
            'm2' => 'required|numeric',
            'costo_m2' => 'required|numeric',
            'calle' => 'required|min:5',
            'numero' => 'required|min:1',
        ];

        $messages = [
            'id_cliente.required' => 'Es necesario que seleccione un Cliente',
            'm2.required' => 'Es necesario que indique la cantidad de Metros cuadrados',
        ];

        $this->validate($request, $rules, $messages);

        $condominio = null;

        try {
            $condominio = BcCondominios::findOrFail($request->id);
        } catch (ModelNotFoundException $ex) {
            $condominio = new BcCondominios();
        }

        $condominio->id_cliente = $request->id_cliente;
        $condominio->nombre = $request->nombre;
        $condominio->m2 = $request->m2;
        $condominio->costo_m2 = $request->costo_m2;
        $condominio->calle = $request->calle;
        $condominio->numero = $request->numero;

        $condominio->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BcCondominios  $condominio
     * @return \Illuminate\Http\Response
     */
    public function destroy(BcCondominios $condominio)
    {
        $condominio->delete();
    }
}
