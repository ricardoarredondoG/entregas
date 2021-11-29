<?php

namespace App\Http\Controllers;

use App\Mail\PedidoCompletado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
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
        if($nombreFoto = $request->file('foto'))
        {
            $nombreFoto = $request->file('foto')->store('public');
        }else
        {
            $nombreFoto ="public/imagenGenerica.jpg";
        }

        $request->request->add(['foto1' => $nombreFoto]);
        setlocale(LC_ALL, 'es_CL.UTF-8');
        $fecha = strftime("%d de %B, %Y");
        $request->request->add(['fecha' => $fecha]);

        Mail::to($request->email)->send(new PedidoCompletado($request));
        Mail::to('ventas@desayunosyregalosvalparaiso.com')->send(new PedidoCompletado($request));

        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
