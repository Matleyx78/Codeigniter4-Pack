<?php
// php spark make:crud --table 'cmms_activity' --namespace 'Matleyx\CI4CMMS'
namespace Matleyx\CI4P\Libraries;

use Config\Autoload;
use Config\Services;

trait CrudConstruct
    {
    //  PATH
    protected function normalizePath($path)
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

        foreach ($segments as $segment)
            {
            if ($segment != '.')
                {
                $test = array_pop($parts);

                if (is_null($test))
                    {
                    $parts[] = $segment;
                    }
                else if ($segment == '..')
                    {
                    if ($test == '..')
                        {
                        $parts[] = $test;
                        }

                    if ($test == '..' || $test == '')
                        {
                        $parts[] = $segment;
                        }
                    }
                else
                    {
                    $parts[] = $test;
                    $parts[] = $segment;
                    }
                }
            }

        return implode('/', $parts);
        }
    protected function normalizeNamespace($namespace)
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

        foreach ($segments as $segment)
            {
            if ($segment != '.')
                {
                $test = array_pop($parts);

                if (is_null($test))
                    {
                    $parts[] = $segment;
                    }
                else if ($segment == '..')
                    {
                    if ($test == '..')
                        {
                        $parts[] = $test;
                        }

                    if ($test == '..' || $test == '')
                        {
                        $parts[] = $segment;
                        }
                    }
                else
                    {
                    $parts[] = $test;
                    $parts[] = $segment;
                    }
                }
            }

        return implode('\\', $parts);
        }
    protected function getPathOutput($folder = '', $namespace = 'App')
        {
        //Get namespace location form  PSR4 paths.
        $config   = new Autoload();
        $location = $namespace;

        $path = rtrim($location, '/') . "/" . $folder;

        return rtrim($this->normalizePath($path), '/ ') . '/';
        }
    protected function getPathOutput_OLD($folder = '', $namespace = 'App')
        {
        // Get namespace location form  PSR4 paths.
        $config   = new Autoload();
        $location = $config->psr4[$namespace];

        $path = rtrim($location, '/') . "/" . $folder;

        return rtrim($this->normalizePath($path), '/ ') . '/';
        }
    protected function getPathViews($name_table = '', $namespace = 'App')
        {
        if ($namespace == 'App')
            {
            $namespace     = "App";
            $address_views = $name_table;
            }
        else
            {
            $address_views = $namespace . "\Views\\" . $name_table;
            }
        return $address_views;
        }
    //  FILES
    protected function copyFile($path, $contents = null)
        {
        helper('filesystem');

        $folder = $this->getDirOfFile($path);
        if (!is_dir($folder))
            {
            $this->createDirectory($folder);
            }

        if (!write_file($path, $contents))
            {
            throw new \RuntimeException('Unable to create file');
            }
        }
    public function createDirectory($path, $perms = 0755)
        {
        if (is_dir($path))
            {
            return $this;
            }

        if (!mkdir($path, $perms, true))
            {
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
        $pathViewadd    = $path_prefix . $this->getPathOutput('Views', $data['namespace']) . $data['table'] . '/addxx.php';
        $pathViewedit   = $path_prefix . $this->getPathOutput('Views', $data['namespace']) . $data['table'] . '/edit.php';
        $pathViewindex  = $path_prefix . $this->getPathOutput('Views', $data['namespace']) . $data['table'] . '/index.php';
        $pathRoute      = $path_prefix . $this->getPathOutput('Config', $data['namespace']) . $data['table'] . '_Routes.php';

        $this->copyFile($pathModel, $this->render('Model', $data));
        $this->copyFile($pathController, $this->render('Controller', $data));
        $this->copyFile($pathViewadd, $this->render('views/add', $data));
        $this->copyFile($pathViewedit, $this->render('views/edit', $data));
        $this->copyFile($pathViewindex, $this->render('views/index', $data));
        $this->copyFile($pathRoute, $this->render('Routes', $data));

        //$this->createRoute($data);
        }
    public function render($template_name, $data = [])
        {
        if (empty($this->parser))
            {
            $path         = realpath(__DIR__ . '/../Templates/') . '/';
            $this->parser = Services::parser($path);
            }

        if (is_null($this->parser))
            {
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
    //  HTML OUTPUT    
    protected function getDatesForModel($fields, $foreignkeys, $namespace = 'App')
        {
        if ($foreignkeys !== false)
            {
            foreach ($foreignkeys as $fk)
                {
                $modeluse[]       = 'use ' . $namespace . '\Models\\' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modelprotected[] = "\t" . 'protected $' . $fk['foreign_table_name'] . ';';
                $modelconstruct[] = "\t\t" . '$this->' . $fk['foreign_table_name'] . ' = new ' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modeldatajoin[]  = "\t\t" . '$data[\'' . $fk['foreign_table_name'] . '\'] = $this->' . $fk['foreign_table_name'] . '->findAll();';
                }
            $model_rows_join = '';
            foreach ($foreignkeys as $fk)
                {
                $model_rows_join .= "\t\t" . '$this->join(\'' . $fk['foreign_table_name'] . '\', \'' . $fk['foreign_table_name'] . '.' . $fk['foreign_column_name'][0] . ' = ' . $fk['tab_name'] . '.' . $fk['column_name'][0] . '\');' . "\n";
                }
            $modeljoin = "\t" . 'public function j_findAll(){' . "\n";
            $modeljoin .= "\t\t" . '$this->select(\'*\');' . "\n";
            $modeljoin .= $model_rows_join;
            $modeljoin .= "\t\t" . 'return $this->findAll();' . "\n";
            $modeljoin .= "\t" . '}' . "\n";
            $modeljoin .= "\t\n";
            $modeljoin .= "\t" . 'public function j_find($id){' . "\n";
            $modeljoin .= "\t\t" . '$this->select(\'*\');' . "\n";
            $modeljoin .= $model_rows_join;
            $modeljoin .= "\t\t" . 'return $this->find($id);' . "\n";
            $modeljoin .= "\t" . '}' . "\n";
            $modeljoin .= "\t\n";

            }
        else
            {
            $modeluse[]       = '';
            $modelprotected[] = '';
            $modelconstruct[] = '';
            $modeldatajoin[]  = '';
            $modeljoin        = '';
            }
        foreach ($fields as $field)
            {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false))
                {
                $allowedFields[] = "\t\t\t" . "'" . $field->name . "'";
                }
            }
        if (!isset($allowedFields))
            {
            $allowedFields[] = '';
            }

        echo "Inizio\n";
        var_dump($fields);
        echo "Fine\n";
        $option_box = "\t" . 'public function getForOptionBox(){' . "\n";
        $option_box .= "\t\t" . '$this->select(\'Field1,Field2\');' . "\n";
        $option_box .= "\t\t" . '$this->orderBy(\'Field2\');' . "\n";
        $option_box .= "\t\t" . '$all_for_opt_box_ini = $this->findAll();' . "\n";
        $option_box .= "\t\t" . 'foreach ($all_for_opt_box_ini as $in)' . "\n";
        $option_box .= "\t\t\t" . '{' . "\n";
        $option_box .= "\t\t\t" . '$all_for_opt_box_fin[$in[\'Field1\']] = $in[\'Field2\'];' . "\n";
        $option_box .= "\t\t\t" . '}' . "\n";
        $option_box .= "\t\t" . 'return $all_for_opt_box_fin;' . "\n";
        $option_box .= "\t" . '}' . "\n";
        return array(
            'allowedfields'  => join("\n", $allowedFields),
            'modeluse'       => join("\n", $modeluse),
            'modelprotected' => join("\n", $modelprotected),
            'modelconstruct' => join("\n", $modelconstruct),
            'modeldatajoin'  => join("\n", $modeldatajoin),
            'modeljoin'      => $modeljoin,
            'optionBox'      => $option_box,
            );
        }
    protected function getDatesForTable($fields)
        {
        foreach ($fields as $field)
            {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false))
                {
                if (!$field->primary_key && $field->name !== 'password')
                    {
                    $fields_th[] = "\t\t\t\t\t\t<th>" . ucwords(str_replace('_', ' ', ($field->name))) . "</th>";
                    $fields_td[] = "\t\t\t\t\t\t\t\t" . '<td><?php echo $row[\'' . $field->name . '\']; ?></td>';
                    }
                }
            }

        return array(
            'fieldsTh' => join("\n", $fields_th),
            'fieldsTd' => join("\n", $fields_td),
            );
        }
    protected function getDatesForForms($fields, $foreignikeys)
        {
        foreach ($fields as $field)
            {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false))
                {

                if (!empty($foreignikeys) and array_key_exists($field->name, $foreignikeys))
                    {
                    //var_dump($foreignikeys[$field->name]);
                    $inputForm[] =
                        "\t\t\t\t\t\t\t" . '<div class="row clearfix">
                                <div class="col-md-6"> <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
                                    <div class="form-group">
                                        <select name="' . $field->name . '" class="form-control">
                                            <?php foreach($' . $foreignikeys[$field->name]['foreign_table_name'] . ' as $' . $foreignikeys[$field->name]['fk_last'] . '): ?>
                                                <option value="<?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'][0] . '\']; ?>" class="form-control" id="' . $field->name . '"><?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'][0] . '\']; ?></option>
                                            <?php endforeach;?>
                                        </select>	
                                    </div>
                                </div>    						    
			                </div>';
                    $editForm[]  =
                        "\t\t\t\t\t\t\t" . '<div class="row clearfix">
                                <div class="col-md-6"> <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
                                    <div class="form-group">
                                        <select name="' . $field->name . '" class="form-control">
                                            <?php foreach($' . $foreignikeys[$field->name]['foreign_table_name'] . ' as $' . $foreignikeys[$field->name]['fk_last'] . '): ?>
                                                <option value="<?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'][0] . '\']; ?>" <?php if ($value[\'' . $field->name . '\'] == $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'][0] . '\']) echo "selected=\"selected\"";?> class="form-control" id="' . $field->name . '"><?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'][0] . '\']; ?></option>
                                            <?php endforeach;?>
                                        </select>					
                                    </div>
                                </div>
                            </div>';
                    }
                elseif ($this->getTypeInput($field->type) != 'textarea')
                    {
                    $inputForm[] =
                        "\t\t\t\t\t\t\t" . '<div class="row clearfix">
                                <div class="col-md-6"> <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
									<div class="form-group">
                                        <input type="' . $this->getTypeInput($field->type) . '" name="' . $field->name . '" class="form-control" id="' . $field->name . '" placeholder="' . ucwords(str_replace('_', ' ', ($field->name))) . '">
                                    </div>    
                                </div>
                            </div>';
                    $editForm[]  =
                        "\t\t\t\t\t\t\t" . '<div class="row clearfix">
                                <div class="col-md-6"> <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
                                    <div class="form-group">
                                        <input type="' . $this->getTypeInput($field->type) . '" name="' . $field->name . '" class="form-control" id="' . $field->name . '" value="<?php echo $value[\'' . $field->name . '\']; ?>">
                                    </div>    
                                </div>
                            </div>';
                    }
                else
                    {
                    $inputForm[] =
                        "\t\t\t\t\t\t\t" . '<div class="col-md-12"> <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
							    <textarea name="' . $field->name . '" class="form-control" id="' . $field->name . '" placeholder="' . ucwords(str_replace('_', ' ', ($field->name))) . '"></textarea>
			                </div>';
                    $editForm[]  =
                        "\t\t\t\t\t\t\t" . '<div class="col-md-12">
							    <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
							    <textarea name="' . $field->name . '" class="form-control" id="' . $field->name . '"><?php echo $value[\'' . $field->name . '\']; ?></textarea>
			                </div>';
                    }
                }
            }

        return array(
            'inputForm' => join("\n", $inputForm),
            'editForm'  => join("\n", $editForm),
        );
        }
    protected function getDatesForFields($fields)
        {
        foreach ($fields as $field)
            {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false))
                {
                $fields_get[]  = "\t\t\t$" . $field->name . ' = $this->request->getPost(\'' . $field->name . '\');';
                $fields_data[] = "\t\t\t'" . $field->name . '\' => $' . $field->name . '';
                $fields_val[]  = "\t'" . $field->name . '\'=>\'required\'';
                $valueInput[]  = '$(\'[name="' . $field->name . '"]\').val((data.' . $field->name . '));';
                }
            }

        return array(
            'fieldsGet'  => join("\n", $fields_get),
            'fieldsData' => join(",\n", $fields_data),
            'fieldsVal'  => join(",\n", $fields_val),
            'valueInput' => join("\n", $valueInput),
        );
        }
    protected function getDatesForRoutes($general_data)
        {
        $route_d[] = "\t\t\t$" . 'routes->get(\'' . $general_data['table_lc'] . '\',\'' . $general_data['nameController'] . '::index\');';
        $route_d[] = "\t\t\t$" . 'routes->get(\'' . $general_data['table_lc'] . '/add\',\'' . $general_data['nameController'] . '::add\');';
        $route_d[] = "\t\t\t$" . 'routes->post(\'' . $general_data['table_lc'] . '/save\',\'' . $general_data['nameController'] . '::save\');';
        $route_d[] = "\t\t\t$" . 'routes->get(\'' . $general_data['table_lc'] . '/edit/(:any)\',\'' . $general_data['nameController'] . '::edit/$1\');';
        $route_d[] = "\t\t\t$" . 'routes->post(\'' . $general_data['table_lc'] . '/update\',\'' . $general_data['nameController'] . '::update\');';
        $route_d[] = "\t\t\t$" . 'routes->get(\'' . $general_data['table_lc'] . '/delete/(:any)\',\'' . $general_data['nameController'] . '::delete/$1\');';

        return array(
            'routes_coll' => join("\n", $route_d),
        );
        }
    public function XX_createRoute($data)
        {
        $routeFile         = APPPATH . 'Config/Routes.php';
        $routeFileContents = file_get_contents($routeFile);
        //$routeFileItemHook = '$routes->group('. '\''.$data['routegroup']. '\'' . ', [\'filter\' => \'auth\'], function($routes){';
        $routeFileItemHook = '$routes->get(\'/\', \'Home::index\')';

        $data_to_write = "\t//" . humanize($data['table']) . " Routes\n\t";
        $data_to_write .= '$routes->get(\'' . $data['table'] . '\',\'' . $data['nameController'] . '::index\');' . "\n\t";
        $data_to_write .= '$routes->get(\'' . $data['table'] . '/add\',\'' . $data['nameController'] . '::add\');' . "\n\t";
        $data_to_write .= '$routes->post(\'' . $data['table'] . '/save\',\'' . $data['nameController'] . '::save\');' . "\n\t";
        $data_to_write .= '$routes->get(\'' . $data['table'] . '/edit/(:any)\',\'' . $data['nameController'] . '::edit/$1\');' . "\n\t";
        $data_to_write .= '$routes->post(\'' . $data['table'] . '/update\',\'' . $data['nameController'] . '::update\');' . "\n\t";
        $data_to_write .= '$routes->get(\'' . $data['table'] . '/delete/(:any)\',\'' . $data['nameController'] . '::delete/$1\');';

        //var_dump($data_to_write);
        if (!strpos($routeFileContents, $data_to_write))
            {
            $newContents = str_replace($routeFileItemHook, $routeFileItemHook . ';' . PHP_EOL . $data_to_write, $routeFileContents);
            //var_dump($data_to_write);
            file_put_contents($routeFile, $newContents);
            }
        }

    }