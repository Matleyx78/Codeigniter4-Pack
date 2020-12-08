<?php

$routes->group('auth', ['namespace' => 'IonAuth\Controllers'], function ($routes) {
    $routes->add('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    $routes->add('forgot_password', 'Auth::forgot_password');
    $routes->get('/', 'Auth::index');
    $routes->add('create_user', 'Auth::create_user');
    $routes->add('edit_user/(:num)', 'Auth::edit_user/$1');
    $routes->add('create_group', 'Auth::create_group');
    // $routes->get('activate/(:num)', 'Auth::activate/$1');
    // $routes->get('activate/(:num)/(:hash)', 'Auth::activate/$1/$2');
    // $routes->add('deactivate/(:num)', 'Auth::deactivate/$1');
    // $routes->get('reset_password/(:hash)', 'Auth::reset_password/$1');
    // $routes->post('reset_password/(:hash)', 'Auth::reset_password/$1');
    // ...
});
//CI4-admin by bvrignaud

$routes->group('admin', ['namespace' => 'Admin\Controllers'], function ($routes) {
    $routes->get('/', 'Home::index');

    $routes->group('users', ['namespace' => 'Admin\Controllers'], function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->add('create', 'Users::createUser');
        $routes->add('edit/(:num)', 'Users::edit/$1');
        $routes->add('activate/(:num)', 'Users::activate/$1');
        $routes->add('deactivate/(:num)', 'Users::deactivate/$1');
        $routes->add('edit_group/(:num)', 'Users::editGroup/$1');
        $routes->add('create_group', 'Users::createGroup');
    });

    $routes->group('informations', ['namespace' => 'Admin\Controllers'], function ($routes) {
        $routes->get('/', 'Informations::index');
        $routes->get('displayPhpInfo', 'Informations::displayPhpInfo');
        $routes->add('exportDatabase', 'Informations::exportDatabase');
        $routes->post('sendEmailForTest', 'Informations::sendEmailForTest');
    });
});
