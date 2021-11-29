<?php
namespace App\Repositories;
use Automattic\WooCommerce\Client;
/**
 *
 */
class BaseData
{
	public function Conexion()
	{
		//Conexion con Wordpress
		$woocommerce = new Client(
		env('API_WOOCOMMERCE_URL'),
        env('API_WOOCOMMERCE_CLIENT'),
        env('API_WOOCOMMERCE_PASSWORD'),
        [
       		'wp_api' => true,
        	'version' => 'wc/v3',
        ]
        );

        return $woocommerce;
	}
}