<?php

$routes->group('mt_crud', ['namespace' => 'Matleyx\CI4P\Controllers'], function ($routes)
{
	$routes->get('/', 'Mt_crud::index');
	$routes->add('crudgen', 'Mt_crud::crudgen');

});

$routes->group('mt_test', ['namespace' => 'Matleyx\CI4P\Controllers'], function ($routes)
{
	$routes->get('/', 'Mt_test::index');
	$routes->get('mt_exc', 'Mt_test::mt_exc');
	$routes->get('mt_pdf', 'Mt_test::mt_pdf');

});

$routes->group('cligeneral', ['namespace' => 'Matleyx\CI4P\Controllers'], function($routes)
{
	$routes->cli('test_mail', 'CliGeneral::test_mail');
});
