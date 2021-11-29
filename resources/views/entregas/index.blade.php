@extends('layouts.app')
@section('content')

<entregas-component></entregas-component>
	{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Administrar Entregas</div>
                <div class="card-body">
                    <table class="table table-responsive">
					  <thead>
					    <tr>
					      <th scope="col">N° Pedido</th>
					      <th scope="col">Envia</th>
					      <th scope="col">Telefono</th>
					      <th scope="col">Fecha Entrega</th>
					      <th scope="col">Recibe</th>
					      <th scope="col">Direccion</th>
					      <th scope="col">Entregado</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@forelse($orders as $ordersItem)
					    <tr class="{{$ordersItem->status == 'completed' ? 'table-success':''}}">
					      <th scope="row">
					      	{{$ordersItem->id}}
					      </th>
                			<td>
                				{{$ordersItem->billing->first_name}} {{$ordersItem->billing->last_name}}
                			</td>
					      <td>
					      	<a href="tel:{{$ordersItem->billing->phone}}">{{$ordersItem->billing->phone}}</a>
					      </td>
					      <td>
					      	@foreach($ordersItem->meta_data as $meta_data)
					      		@if($meta_data->key == 'fecha-de-entrega')
					      			{{$meta_data->value}}
                				@endif
                			@endforeach
					      </td>
					      <td>
					      	{{$ordersItem->shipping->first_name}} {{$ordersItem->shipping->last_name}}
					      </td>
					      <td>
					      	{{$ordersItem->shipping->address_1}}, {{$ordersItem->shipping->state}}
					      </td>
					      <td>
					      	<button class="btn btn-primary" {{$ordersItem->status == 'completed' ? 'disabled':''}}> Entregado</button>
					      </td>
					    </tr>
					    @empty
					    	<tr>

					    			<li>No hay Ordenes para mostrar</li>
					    		</td>
					    	</tr>

		                @endforelse
					  </tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection