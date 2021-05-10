<?php

namespace App\Http\Controllers;

use App\Models\admClientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = admClientes::whereIN('CTIPOCLIENTE',[1,2])
                                ->where('CESTATUS','=',1)->get();

        return $clientes;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admClientes  $admClientes
     * @return \Illuminate\Http\Response
     */
    public function show(admClientes $admClientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admClientes  $admClientes
     * @return \Illuminate\Http\Response
     */
    public function edit(admClientes $admClientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admClientes  $admClientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admClientes $admClientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admClientes  $admClientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(admClientes $admClientes)
    {
        //
    }
}
