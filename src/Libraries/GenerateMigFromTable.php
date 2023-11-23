<?php
// php spark make:migfromtable --table 'cmms_activity' --namespace 'Matleyx\CI4CMMS'
namespace Matleyx\CI4P\Libraries;

use Config\Autoload;
use Config\Services;
use CodeIgniter\Model;

trait GenerateMigFromTable
{
    
    protected function getPathOutput($folder = '', $namespace = 'App')
    {
        // Get namespace location form  PSR4 paths.
        $config = new Autoload();
        $location = $config->psr4[$namespace];

        $path = rtrim($location, '/') . "/" . $folder;

        return rtrim($this->normalizePath($path), '/ ') . '/';
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

    public function render($template_name, $data = [])
    {
        if (empty($this->parser)) {
            $path         = realpath(__DIR__ . '/../Templates/') . '/';
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

    protected function getFields($table, $db)
    {
        $this->db = \Config\Database::connect($db);
        if ($this->db->tableExists($table)) {
            return  $fields = $this->db->getFieldData($table);
        } else {
            return false;
        }
    }

    protected function getForeignkey($table)
    {
        $this->db = \Config\Database::connect();
        if ($this->db->tableExists($table)) {
            $fk_found = json_decode(json_encode($this->db->getForeignKeyData($table)), true);
            if ($fk_found) {
                foreach ($fk_found as $fk) {
                    $result[$fk['column_name']] = array(
                        'tab_name' => $table,
                        'column_name' => $fk['column_name'],
                        'foreign_table_name' => $fk['foreign_table_name'],
                        'foreign_column_name' => $fk['foreign_column_name'],
                        'fk_last' => substr($fk['foreign_table_name'], -3),
                    );
                }
                return  $result;
            }
        } else {
            return false;
        }
    }
    protected function getPrimaryKey($fields)
    {
        foreach ($fields as $field) {
            if ($field->primary_key) {
                return $field->name;
            }
        }
    }

    protected function getDatesFromFields($fields, $foreignikeys)
    {
        foreach ($fields as $field) {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false)) {
                if (!$field->primary_key && $field->name !== 'password') {
                    $fields_th[]  =  "\t\t\t\t\t\t<th>" . ucwords(str_replace('_', ' ', ($field->name))) . "</th>";
                }
                if (!$field->primary_key && $field->name !== 'password') {
                    $fields_td[]  =  "\t\t\t\t\t\t\t\t" . '<td><?php echo $row[\'' . $field->name . '\']; ?></td>';
                }
                $allowedFields[]  =  "\t\t\t\t\t\t" ."'" . $field->name . "'";
                $fields_get[]  =  "\t\t\t$" . $field->name . ' = $this->request->getPost(\'' . $field->name . '\');';
                $fields_data[]  =  "\t\t\t'" . $field->name . '\' => $' . $field->name . '';
                $fields_val[]  =  "\t'" . $field->name . '\'=>\'required\'';
                $valueInput[]  =  '$(\'[name="' . $field->name . '"]\').val((data.' . $field->name . '));';

                if (!empty($foreignikeys) AND array_key_exists($field->name, $foreignikeys)) {
                    $inputForm[]  =
                        "\t\t\t\t\t\t\t" . '<div class="row clearfix">
                                <div class="col-md-6"> <label class="form-label" for="' . $field->name . '">' . ucwords(str_replace('_', ' ', ($field->name))) . '</label>
                                    <div class="form-group">
                                        <select name="' . $field->name . '" class="form-control">
                                            <?php foreach($' . $foreignikeys[$field->name]['foreign_table_name'] . ' as $' . $foreignikeys[$field->name]['fk_last'] . '): ?>
                                                <option value="<?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'] . '\']; ?>" class="form-control" id="' . $field->name . '"><?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'] . '\']; ?></option>
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
                                                <option value="<?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'] . '\']; ?>" <?php if ($value[\'' . $field->name . '\'] == $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'] . '\']) echo "selected=\"selected\"";?> class="form-control" id="' . $field->name . '"><?php echo $' . $foreignikeys[$field->name]['fk_last'] . '[\'' . $foreignikeys[$field->name]['foreign_column_name'] . '\']; ?></option>
                                            <?php endforeach;?>
                                        </select>					
                                    </div>
                                </div>
                            </div>';
                } elseif ($this->getTypeInput($field->type) != 'textarea') {
                    $inputForm[]  =
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
                } else {
                    $inputForm[]  =
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
        if ($foreignikeys !== false) {
            foreach ($foreignikeys as $fk) {
                $modeluse[] = 'use App\Models\\' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modelprotected[] = "\t" . 'protected $' . $fk['foreign_table_name'] . ';';
                $modelconstruct[] = "\t\t" . '$this->' . $fk['foreign_table_name'] . ' = new ' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modeldatajoin[] = "\t\t" . '$data[\'' . $fk['foreign_table_name'] . '\'] = $this->' . $fk['foreign_table_name'] . '->findAll();';
            }
            $model_rows_join = '';
            foreach ($foreignikeys as $fk) {        
                $model_rows_join.= "\t\t".'$this->join(\'' . $fk['foreign_table_name'] . '\', \'' . $fk['foreign_table_name'] . '.' . $fk['foreign_column_name'] . ' = ' . $fk['tab_name'] .'.'. $fk['column_name'] . '\');'."\n";
            }
            $modeljoin  = "\t".'public function j_findAll(){'."\n";
            $modeljoin .= "\t\t".'$this->select(\'*\');'."\n";
            $modeljoin .= $model_rows_join;
            $modeljoin .= "\t\t".'return $this->findAll();'."\n";
            $modeljoin .= "\t".'}'."\n";
            $modeljoin .= "\t\n";
            $modeljoin .= "\t".'public function j_find($id){'."\n";
            $modeljoin .= "\t\t".'$this->select(\'*\');'."\n";
            $modeljoin .= $model_rows_join;
            $modeljoin .= "\t\t".'return $this->find($id);'."\n";
            $modeljoin .= "\t".'}'."\n";
            $modeljoin .= "\t\n";

        } else {
            $modeluse[] = '';
            $modelprotected[] = '';
            $modelconstruct[] = '';
            $modeldatajoin[] = '';
            $modeljoin = '';
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

    protected function createFileMigration($data)
    {
        $pathMigration          = $this->getPathOutput('Migration', $data['namespace']) . $data['nameMigration'] . '.php';

        $this->copyFile($pathMigration, $this->render('Migration', $data));

        
    }

    /**
     * Convert the type field sql to type input html
     */
    public function getTypeInput($type_sql)
    {
        $type_html = "";
        switch ($type_sql) {
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

    public function string_by_type(object $field_data) : string
    {
        if ($field_data->type == ''){
            return 'Error type field';
        }
        $max_length = $field_data->max_length != '' ? $field_data->max_length : false;
        $default    = $field_data->default    != null ? $field_data->default    : false;
        $name       = $field_data->name       ;
        $nullable   = $field_data->nullable   === true ? $field_data->nullable   : false;
        $primay_key = $field_data->primay_key != 0 ? $field_data->primay_key : false;
        $type       = $field_data->type       ;
        $unsigned   = $field_data->unsigned   === true ? $field_data->unsigned   : false;
        $auto_increment = $field_data->auto_increment === true ? $field_data->auto_increment : false;

        $start = $name.' => [';

        $after = '';
        if ($default) { $after .= '\'default\' => \''. $default. '\', '; }
        if ($nullable) { $after .= '\'null\' => true, '; }
        if ($max_length) { $after .= '\'constraint\' => '. $max_length. ', '; }
            else { 
                if ($type == 'int') { $after .= '\'constraint\' => 11, '; }
                if ($type == 'varchar') { $after .= '\'constraint\' => 250, '; }
             }
        if ($unsigned) { $after .= '\'unsigned\' => true, '; }
        if ($auto_increment) { $after .= '\'autoIncrement\' => true, '; }

        $string = '';
        switch ($type) {
            case 'int':
                $string = '\'type\' => \'int\', \'constraint\' => 11, \'unsigned\' => true,';
                break;
            case 'varchar':
                $string = '\'type\' => \'varchar\', \'constraint\' => 250, \'null\' => true,';
                break;
            case 'date':
                $string = '\'type\' => \'date\', \'null\' => true,';
                break;
            case 'datetime':
                $string = '\'type\' => \'datetime\', \'null\' => true,';
                break;
            case 'timestamp':
                $string = '\'type\' => \'timestamp\', \'null\' => true,';
                break;
            case 'time':
                $string = '\'type\' => \'time\', \'null\' => true,';
                break;
            case 'text':
                $string = 'textarea';
                break;
        }
        $end = '],';
        $final = $start. ''. $string. ''. $after. ''. $end;
        return $final;
    }
}