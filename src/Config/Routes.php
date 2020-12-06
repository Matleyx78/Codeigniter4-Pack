<?php

$routes->group('mt_crud', ['namespace' => 'Matleyx\CI4P\Controllers'], function ($routes)
{
	$routes->get('/', 'Mt_crud::index');
	$routes->get('crudgen', 'Mt_crud::crudgen');

});
