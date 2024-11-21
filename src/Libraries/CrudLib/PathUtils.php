<?php
// php spark make:crud --table 'cmms_activity' --namespace 'Matleyx\CI4CMMS'
namespace Matleyx\CI4P\Libraries\CrudLib;

use Config\Autoload;

trait PathUtils
{
    //  PATH
    protected function normalizedPath($path)
    {
        // Array to build a new path from the good parts
        $parts = [];

        // Replace backslashes with forward slashes
        $path = str_replace('\\', '/', $path);

        // Combine multiple slashes into a single slash
        $path = preg_replace('/\/+/', '/', $path);

        // Collect path segments
        $segments = explode('/', $path);

        // Initialize testing variable
        $test = '';

        foreach ($segments as $segment) {
            if ($segment != '.') {
                $test = array_pop($parts);

                if (is_null($test)) {
                    $parts[] = $segment;
                } else if ($segment == '..') {
                    if ($test == '..') {
                        $parts[] = $test;
                    }

                    if ($test == '..' || $test == '') {
                        $parts[] = $segment;
                    }
                } else {
                    $parts[] = $test;
                    $parts[] = $segment;
                }
            }
        }

        return implode('/', $parts);
    }
    protected function normalizedNamespace($namespace)
    {
        // Array to build a new path from the good parts
        $parts = [];
        // Combine multiple slashes into a single slash
        $namespace = preg_replace('/\/+/', '/', $namespace);
        // Replace backslashes with forward slashes
        $namespace = str_replace('/', '\\', $namespace);



        // Collect path segments
        $segments = explode('\\', $namespace);

        // Initialize testing variable
        $test = '';

        foreach ($segments as $segment) {
            if ($segment != '.') {
                $test = array_pop($parts);

                if (is_null($test)) {
                    $parts[] = $segment;
                } else if ($segment == '..') {
                    if ($test == '..') {
                        $parts[] = $test;
                    }

                    if ($test == '..' || $test == '') {
                        $parts[] = $segment;
                    }
                } else {
                    $parts[] = $test;
                    $parts[] = $segment;
                }
            }
        }

        return implode('\\', $parts);
    }
    protected function getPathBaseController($namespace)
    {
        if ($namespace == 'App') {
            $pathBaseC = 'CodeIgniter';
        } else {
            $pathBaseC = 'App\Controllers';
        }
        return $pathBaseC;
    }
    protected function getPathOutput($folder = '', $namespace = 'App')
    {
        //Get namespace location form  PSR4 paths.
        $config   = new Autoload();
        $location = $namespace;

        $path = rtrim($location, '/') . "/" . $folder;

        return rtrim($this->normalizedPath($path), '/ ') . '/';
    }
    protected function getPathViews($name_table = '', $namespace = 'App')
    {
        if ($namespace == 'App') {
            $namespace     = "App";
            $address_views = $name_table;
        } else {
            $address_views = $namespace . "\Views\\" . $name_table;
        }
        return $address_views;
    }
}
