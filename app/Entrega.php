<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
	protected $primaryKey = 'id_pedido';
    protected $fillable = [
        'id_pedido', 'user_id'
    ];
}
