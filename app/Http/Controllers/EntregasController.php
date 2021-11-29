<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BaseData;
use App\Entrega;
use Auth;
use Illuminate\Support\Arr;
class EntregasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseDate;

    function __construct(BaseData $baseData)
    {
        $this->baseData = $baseData;
    }

    public function index()
    {
        $ordenes = Entrega::where('user_id', Auth::user()->id)->get('id_pedido');
        $ordenes1 = array();
        foreach ($ordenes as $key) {
             array_push($ordenes1, $key->id_pedido);
        }
        $woocommerce= $this->baseData->Conexion();
        $orders1 = $woocommerce->get('orders', $parameters= ['status' => 'processing,completed', 'per_page' => 99]);

        if(Auth::user()->privilegio == 'Administrador')
        {
            $orders = collect($orders1);
        }else if (Auth::user()->privilegio == 'Usuario'){
            $orders = collect($orders1)->whereIn('id', $ordenes1)->all();
        }

        return $orders;
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
         $woocommerce= $this->baseData->Conexion();
         $data = [
            'status' => 'completed'
        ];
         if($woocommerce->put('orders/'.$id, $data)){
            return true;
         }else
         {
            return false;
         }

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
