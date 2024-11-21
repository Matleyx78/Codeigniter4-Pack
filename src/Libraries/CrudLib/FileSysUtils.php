<?php

namespace Matleyx\CI4P\Libraries\CrudLib;

use Matleyx\CI4P\Libraries\CrudLib\PathUtils;

use Config\Services;
use Config\Autoload;

trait FileSysUtils
{
    use PathUtils;
    //  FILES
    protected function copyFile($path, $contents = null)
    {
        helper('filesystem');

        $folder = $this->getDirOfFile($path);
        if (!is_dir($folder)) {
            $this->createDirectory($folder);
        }

        if (!write_file($path, $contents)) {
            throw new \RuntimeException('Unable to create file');
        }
    }
    public function createDirectory($path, $perms = 0755)
    {
        if (is_dir($path)) {
            return $this;
        }

        if (!mkdir($path, $perms, true)) {
            throw new \RuntimeException(sprintf('Error creating directory', $path));
        }
        return $this;
    }
    public function getDirOfFile($file)
    {
        $segments = explode('/', $file);
        array_pop($segments);
        return $folder = implode('/', $segments);
    }
    protected function createFileCrud($data)
    {
        $date           = date('Y_m_d_H_i_s');
        $path_prefix    = '../writable/crud_generator/' . $date . '-' . $data['table'] . '/';
        $pathModel      = $path_prefix . $this->getPathOutput('Models', $data['namespace']) . $data['nameModel'] . '.php';
        $pathController = $path_prefix . $this->getPathOutput('Controllers', $data['namespace']) . $data['nameController'] . '.php';
        $pathViewadd    = $path_prefix . $this->getPathOutput('Views', $data['namespace']) . $data['table'] . '/add.php';
        $pathViewedit   = $path_prefix . $this->getPathOutput('Views', $data['namespace']) . $data['table'] . '/edit.php';
        $pathViewindex  = $path_prefix . $this->getPathOutput('Views', $data['namespace']) . $data['table'] . '/index.php';
        $pathRoute      = $path_prefix . $this->getPathOutput('Config', $data['namespace']) . $data['table'] . '_Routes.php';

        $this->copyFile($pathModel, $this->render('Model', $data));
        $this->copyFile($pathController, $this->render('Controller', $data));
        $this->copyFile($pathViewadd, $this->render('views/add', $data));
        $this->copyFile($pathViewedit, $this->render('views/edit', $data));
        $this->copyFile($pathViewindex, $this->render('views/index', $data));
        $this->copyFile($pathRoute, $this->render('Routes', $data));
    }
    public function render($template_name, $data = [])
    {
        if (empty($this->parser)) {
            $path         = realpath(__DIR__ . '/../../Templates') . '/';
            $this->parser = Services::parser($path);
        }
        if (is_null($this->parser)) {
            throw new \RuntimeException('Unable to create Parser instance.');
        }
        $output = $this->parser
            ->setData($data)
            ->render($template_name);

        $output = str_replace('@php', '<?php', $output);
        $output = str_replace('!php', '?>', $output);
        $output = str_replace('@=', '<?=', $output);
        return $output;
    }
}
