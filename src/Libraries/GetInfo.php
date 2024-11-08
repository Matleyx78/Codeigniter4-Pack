<?php
// php spark make:crud --table 'cmms_activity' --namespace 'Matleyx\CI4CMMS'
namespace Matleyx\CI4P\Libraries;

use Config\Autoload;
use Config\Services;
use Config\Database;

trait GetInfo
    {
    protected function __construct()
        {
        helper('array');
        }
    protected function getDatabases()
        {
        $all_conf  = new Database();
        $string_db = '';
        foreach ($all_conf as $key => $value)
            {
            if ($key != 'filesPath' and $key != 'defaultGroup')
                {
                $string_db .= $key . ', ';
                }
            }
        return $string_db;
        }

    protected function getTables($db_in_use)
        {
        $all_conf = new Database();
        if (isset($all_conf->$db_in_use))
            {
            $db     = Database::connect($db_in_use);
            $tables = $db->listTables();
            return $tables;
            }
        else
            {
            //db connection  not initialized
            return false;
            }

        }
    protected function getFields($db_in_use, $table)
        {
        $db = Database::connect($db_in_use);
        if ($db->tableExists($table))
            {
            $fields = $db->getFieldData($table);
            return $fields;
            }
        else
            {
            return false;
            }
        }
    protected function getIndex($db_in_use, $table)
        {
        $db = Database::connect($db_in_use);
        if ($db->tableExists($table))
            {
            $fk_found = o_t_a($db->getIndexData($table));
            var_dump($fk_found);
            // if ($fk_found)
            //     {
            //     foreach ($fk_found as $fk)
            //         {
            //         $result[$fk['column_name'][0]] = array(
            //             'tab_name'            => $table,
            //             'column_name'         => $fk['column_name'],
            //             'foreign_table_name'  => $fk['foreign_table_name'],
            //             'foreign_column_name' => $fk['foreign_column_name'],
            //             'fk_last'             => substr($fk['foreign_table_name'], -3),
            //         );
            //         }
            //     return $result;
            //     }
            // else
            //     {
            //     return false;
            //     }
            }
        else
            {
            return false;
            }
        }
    protected function getForeignkey($db_in_use, $table)
        {
        $db = Database::connect($db_in_use);
        if ($db->tableExists($table))
            {
            $fk_found = o_t_a($db->getForeignKeyData($table));
            //var_dump($fk_found);
            if ($fk_found)
                {
                foreach ($fk_found as $fk)
                    {
                    $result[$fk['column_name'][0]] = array(
                        'tab_name'            => $table,
                        'column_name'         => $fk['column_name'],
                        'foreign_table_name'  => $fk['foreign_table_name'],
                        'foreign_column_name' => $fk['foreign_column_name'],
                        'fk_last'             => substr($fk['foreign_table_name'], -3),
                    );
                    }
                return $result;
                }
            else
                {
                return false;
                }
            }
        else
            {
            return false;
            }
        }
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
        // Get namespace location form  PSR4 paths.
        $config   = new Autoload();
        $location = $config->psr4[$namespace];

        $path = rtrim($location, '/') . "/" . $folder;

        return rtrim($this->normalizePath($path), '/ ') . '/';
        }



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




    protected function getPrimaryKey($fields)
        {
        foreach ($fields as $field)
            {
            if ($field->primary_key)
                {
                return $field->name;
                }
            }
        }

    protected function getDatesFromFields($fields, $foreignikeys)
        {
        foreach ($fields as $field)
            {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false))
                {
                if (!$field->primary_key && $field->name !== 'password')
                    {
                    $fields_th[] = "\t\t\t\t\t\t<th>" . ucwords(str_replace('_', ' ', ($field->name))) . "</th>";
                    }
                if (!$field->primary_key && $field->name !== 'password')
                    {
                    $fields_td[] = "\t\t\t\t\t\t\t\t" . '<td><?php echo $row[\'' . $field->name . '\']; ?></td>';
                    }
                $allowedFields[] = "\t\t\t\t\t\t" . "'" . $field->name . "'";
                $fields_get[]    = "\t\t\t$" . $field->name . ' = $this->request->getPost(\'' . $field->name . '\');';
                $fields_data[]   = "\t\t\t'" . $field->name . '\' => $' . $field->name . '';
                $fields_val[]    = "\t'" . $field->name . '\'=>\'required\'';
                $valueInput[]    = '$(\'[name="' . $field->name . '"]\').val((data.' . $field->name . '));';

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
        if ($foreignikeys !== false)
            {
            foreach ($foreignikeys as $fk)
                {
                $modeluse[]       = 'use App\Models\\' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modelprotected[] = "\t" . 'protected $' . $fk['foreign_table_name'] . ';';
                $modelconstruct[] = "\t\t" . '$this->' . $fk['foreign_table_name'] . ' = new ' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modeldatajoin[]  = "\t\t" . '$data[\'' . $fk['foreign_table_name'] . '\'] = $this->' . $fk['foreign_table_name'] . '->findAll();';
                }
            $model_rows_join = '';
            foreach ($foreignikeys as $fk)
                {
                var_dump($fk);
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
        return array(
            'fieldsTh'       => implode("\n", $fields_th),
            'fieldsTd'       => implode("\n", $fields_td),
            'allowedFields'  => implode(",\n", $allowedFields),
            'fieldsGet'      => implode("\n", $fields_get),
            'fieldsData'     => implode(",\n", $fields_data),
            'fieldsVal'      => implode(",\n", $fields_val),
            'inputForm'      => implode("\n", $inputForm),
            'editForm'       => implode("\n", $editForm),
            'valueInput'     => implode("\n", $valueInput),
            'modeluse'       => implode("\n", $modeluse),
            'modelprotected' => implode("\n", $modelprotected),
            'modelconstruct' => implode("\n", $modelconstruct),
            'modeldatajoin'  => implode("\n", $modeldatajoin),
            'modeljoin'      => $modeljoin,
        );
        }

    protected function createFileCrud($data)
        {
        $date           = date('Y_m_d_H_i_s');
        $path_prefix    = '../writable/crud_generator/' . $date . '-' . $data['table'] . '/';
        $pathModel      = $this->getPathOutput($path_prefix . 'Models', $data['namespace']) . $data['nameModel'] . '.php';
        $pathController = $this->getPathOutput($path_prefix . 'Controllers', $data['namespace']) . $data['nameController'] . '.php';
        $pathViewadd    = $this->getPathOutput($path_prefix . 'Views', $data['namespace']) . $data['table'] . '/addxx.php';
        $pathViewedit   = $this->getPathOutput($path_prefix . 'Views', $data['namespace']) . $data['table'] . '/edit.php';
        $pathViewindex  = $this->getPathOutput($path_prefix . 'Views', $data['namespace']) . $data['table'] . '/index.php';

        $this->copyFile($pathModel, $this->render('Model', $data));
        $this->copyFile($pathController, $this->render('Controller', $data));
        $this->copyFile($pathViewadd, $this->render('views/add', $data));
        $this->copyFile($pathViewedit, $this->render('views/edit', $data));
        $this->copyFile($pathViewindex, $this->render('views/index', $data));

        $this->createRoute($data);
        }

    /**
     * Convert the type field sql to type input html
     */
    public function getTypeInput($type_sql)
        {
        $type_html = "";
        switch ($type_sql)
            {
            case 'int':
                $type_html = 'number';
                break;
            case 'varchar':
                $type_html = 'text';
                break;
            case 'date':
                $type_html = 'date';
                break;
            case 'datetime':
                $type_html = 'datetime';
                break;
            case 'timestamp':
                $type_html = 'datetime';
                break;
            case 'time':
                $type_html = 'time';
                break;
            case 'text':
                $type_html = 'textarea';
                break;
            }
        return $type_html;
        }

    public function createRoute($data)
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

    //   public function createRoute($data)
    //   {
    //       $route_file = APPPATH.'Config/Routes.php';
    //       $string = file_get_contents($route_file);

    //       $data_to_write ="\n//". humanize($data['table']) ." Routes\n";
    //       $data_to_write.='$routes->get(\''.$data['table'].'\',\''.$data['nameController'].'::index\');'."\n";
    // $data_to_write.='$routes->get(\''.$data['table'].'/add\',\''.$data['nameController'].'::add\');'."\n"; 
    // $data_to_write.='$routes->post(\''.$data['table'].'/save\',\''.$data['nameController'].'::save\');'."\n";
    //       $data_to_write.='$routes->get(\''.$data['table'].'/edit/(:any)\',\''.$data['nameController'].'::edit/$1\');'."\n";
    //       $data_to_write.='$routes->post(\''.$data['table'].'/update\',\''.$data['nameController'].'::update\');'."\n";
    // $data_to_write.='$routes->get(\''.$data['table'].'/delete/(:any)\',\''.$data['nameController'].'::delete/$1\');';

    //           if (!strpos($string, $data_to_write)) {
    //               file_put_contents($route_file, $data_to_write, FILE_APPEND);
    //           }
    //   }

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
    }