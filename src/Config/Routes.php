<?php

$routes->group('mt_crud', ['namespace' => 'Matleyx\CI4P\Controllers'], function ($routes)
{
	$routes->get('/', 'Mt_crud::index');
	$routes->add('crudgen', 'Mt_crud::crudgen');

});

$routes->group('mt_test', ['namespace' => 'Matleyx\CI4P\Controllers'], function ($routes)
{
	$routes->get('/', 'Mt_test::index');

});