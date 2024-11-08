@php

namespace {namespace}\Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->group('{table_lc}', ['namespace' => '{namespace}\Controllers'], static function ($routes) {

{! routes_coll !}

});