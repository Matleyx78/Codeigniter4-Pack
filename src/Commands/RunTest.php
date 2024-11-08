<?php
namespace Matleyx\CI4P\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;
use Matleyx\CI4P\Libraries\DbGetInfo;
use Matleyx\CI4P\Libraries\CrudConstruct;

class RunTest extends BaseCommand
    {

    //  php spark make:crud --table 'NAMETABLE' --namespace 'NAMESPACE'
    use DbGetInfo;
    use CrudConstruct;
    protected $group = 'Demo';
    protected $name = 'Run:Test';
    protected $description = 'Displays basic application information.';
    protected $all_conf;
    protected $data = [];


    public function run(array $params)
        {
        helper('inflector');
        $string_db  = $this->getDatabases();
        $db_in_use  = CLI::prompt('Which Database do you want to Use?', [ $string_db ], 'min_length[3]');
        $all_tables = $this->getTables($db_in_use);
        if ($all_tables == false)
            {
            CLI::write("Database Connection error", "red");
            exit;
            }
        $table = CLI::prompt('Enter Table name');
        if ($table == 'users' || $table == 'tbl_users' || $table == 'admins')
            {
            CLI::write('Cannot generate crud for ' . CLI::color($table, 'yellow') . ' Table because it might interfere with your login Crud.', "red");
            exit;
            }
        else
            {
            if (!in_array($table, $all_tables))
                {
                CLI::write('Table ' . CLI::color($table, 'yellow') . 'does not exist in Database ' . CLI::color($db_in_use, 'yellow'), "red");
                exit;
                }
            }
        // $table          = 'DIE_MANAGEMENT';
        // $db_in_use      = 'p25';
        // $table_as_it = 'dipend_elenco';
        // $db_in_use   = 'jarvis';
        $table_as_it = $table;
        $table_lc    = strtolower($table_as_it);

        $singular_table = $table_lc;
        $namespace      = CLI::prompt('Which Namespace do you want to Use?', [ 'App' ], 'min_length[3]');
        $namespace      = $this->normalizeNamespace($namespace);
        $views_path     = $this->getPathViews($table_lc, $namespace);
        $controllerName = pascalize($table_lc) . 'Controller';
        $modelName      = pascalize($table_lc) . 'Model';
        $recordName     = camelize($table_lc);
        $single_rec     = 'si_' . $recordName;
        $plural_rec     = 'pl_' . $recordName;
        $fields         = $this->getFields($db_in_use, $table_as_it);
        $std_fields     = $this->stdFields($fields);                    //standardize fields
        $primarykey     = $this->getPrimarykey($db_in_use, $table_as_it);
        $index_data     = $this->getIndex($db_in_use, $table_as_it, $std_fields);
        if (isset($index_data['std_fields']))
            {
            $std_fields = $index_data['std_fields'];
            $index_data = $index_data['result'];
            }
        $foreignkeys = $this->getForeignkey($db_in_use, $table_as_it, $std_fields);
        if (isset($foreignkeys['std_fields']))
            {
            $std_fields  = $foreignkeys['std_fields'];
            $foreignkeys = $foreignkeys['result'];
            }
        // CLI::write('Primary Key:', 'yellow');
        // var_dump($primarykey);
        // CLI::write('Fields Standardize', 'green');
        // var_dump($std_fields);
        // CLI::write('Index Data:', 'blue');
        // var_dump($index_data);
        // CLI::write('foreign Key:', 'blue');
        // var_dump($foreignkeys);
        $general_data = [
            'table'          => $table_as_it,
            'table_lc'       => $table_lc,
            'primaryKey'     => $primarykey,
            'pk_string'      => substr($primarykey, -4),
            'namespace'      => $namespace,
            'nameEntity'     => ucfirst($table_lc),
            'singularTable'  => singular($table_lc),
            'singularRecord' => $single_rec,
            'pluralRecord'   => $plural_rec,
            'nameModel'      => $modelName,
            'nameController' => $controllerName,
            'foreignkeys'    => $foreignkeys,
            'views_path'     => $views_path,
        ];
        //$path_prefix    = '../writable/crud_generator/giorno-tabella/';
        //$test = $path_prefix . $this->getPathOutput('Models', $general_data['namespace']).'nome.php';
        //CLI::write('Path Output: '.$test, 'green');
        $model_data  = $this->getDatesForModel($fields, $foreignkeys, $namespace);
        $table_data  = $this->getDatesForTable($fields);
        $forms_data  = $this->getDatesForForms($fields, $foreignkeys);
        $fiel_data   = $this->getDatesForFields($fields);
        $routes_data = $this->getDatesForRoutes($general_data);
        $this->data  = array_merge($general_data, $model_data, $table_data, $forms_data, $fiel_data, $routes_data);
        $this->createFileCrud($this->data);






        // CLI::write('Database: ' . CLI::color($string_db, 'yellow'));
        // CLI::write('Table: ' . CLI::color($table, 'yellow'));
        // CLI::write('Namespace: ' . CLI::color($namespace, 'yellow'));
        // CLI::write('Controller Name: ' . CLI::color($controllerName, 'yellow'));
        // CLI::write('Model Name: ' . CLI::color($modelName, 'yellow'));

        // CLI::write("Controller Generated successfully!", "cyan");
        // CLI::write("Model Generated successfully!", "cyan");
        // CLI::write("Views Generated successfully!", "cyan");
        // CLI::write("Crud Generated successfully!", "blue");




        }
    }