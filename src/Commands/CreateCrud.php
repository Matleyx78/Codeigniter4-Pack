<?php

namespace Matleyx\CI4P\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;
use Matleyx\CI4P\Libraries\CrudLib\PathUtils;
use Matleyx\CI4P\Libraries\CrudLib\CrudConstruct;
use Matleyx\CI4P\Libraries\CrudLib\DbGetInfo;
use Matleyx\CI4P\Libraries\CrudLib\FileSysUtils;
use Matleyx\CI4P\Libraries\CrudLib\HtmlEditFormGenerator;
use Matleyx\CI4P\Libraries\CrudLib\HtmlInputFormGenerator;


class CreateCrud extends BaseCommand
{
    //  php spark make:crud --table 'NAMETABLE' --namespace 'NAMESPACE'
    use PathUtils;
    use CrudConstruct;
    use FileSysUtils;
    use DbGetInfo;
    use HtmlEditFormGenerator;
    use HtmlInputFormGenerator;
    protected $group = 'Generators';
    protected $name = 'make:crud';
    protected $description = 'Generate CRUD based on model, (External Library)';
    protected $data = [];


    public function run(array $params)
    {
        helper('inflector');
        $string_db  = $this->getDatabases();
        $db_in_use  = CLI::prompt('Which Database do you want to Use?', [$string_db], 'min_length[3]');
        $all_tables = $this->getTables($db_in_use);
        if ($all_tables == false) {
            CLI::write("Database Connection error", "red");
            exit;
        }
        $table = CLI::prompt('Enter Table name');
        if ($table == 'users' || $table == 'tbl_users' || $table == 'admins') {
            CLI::write('Cannot generate crud for ' . CLI::color($table, 'yellow') . ' Table because it might interfere with your login Crud.', "red");
            exit;
        } else {
            if (!in_array($table, $all_tables)) {
                CLI::write('Table ' . CLI::color($table, 'yellow') . 'does not exist in Database ' . CLI::color($db_in_use, 'yellow'), "red");
                exit;
            }
        }
        $namespace      = CLI::prompt('Which Namespace do you want to Use?', ['App'], 'min_length[3]');

        // $table          = 'leghe_colate';
        // $db_in_use      = 'default';
        // $namespace = 'Moduli/Trafilerie';
        // $pk_string = 'leco';
        // $table          = 'blog';
        // $db_in_use      = 'default';
        // $namespace = 'Moduli/Cairo';
        $table_as_it = $table;
        $table_lc    = strtolower($table_as_it);
        $singular_table = $table_lc;

        $namespace      = $this->normalizedNamespace($namespace);
        $bc_path        = $this->getPathBaseController($namespace);
        $views_path     = $this->getPathViews($table_lc, $namespace);
        $controllerName = pascalize($table_lc);
        $modelName      = pascalize($table_lc) . 'Model';
        $recordName     = camelize($table_lc);
        $single_rec     = 'si_' . $recordName;
        $plural_rec     = 'pl_' . $recordName;
        $fields         = $this->getFields($db_in_use, $table_as_it);
        $std_fields     = $this->stdFields($fields);                    //standardize fields
        $primarykey     = $this->getPrimarykey($db_in_use, $table_as_it);
        if ($pk_string == '') {
            $pk_string = substr($primarykey, -4);
        }
        $index_data     = $this->getIndex($db_in_use, $table_as_it, $std_fields);
        if (isset($index_data['std_fields'])) {
            $std_fields = $index_data['std_fields'];
            $index_data = $index_data['result'];
        }
        $foreignkeys = $this->getForeignkey($db_in_use, $table_as_it, $std_fields);
        if (isset($foreignkeys['std_fields'])) {
            $std_fields  = $foreignkeys['std_fields'];
            $foreignkeys = $foreignkeys['result'];
        }
        $general_data = [
            'table'          => $table_as_it,
            'table_lc'       => $table_lc,
            'primaryKey'     => $primarykey,
            'pk_string'      => $pk_string,
            'namespace'      => $namespace,
            'bc_path'        => $bc_path,
            'nameEntity'     => ucfirst($table_lc),
            'singularTable'  => singular($table_lc),
            'singularRecord' => $single_rec,
            'pluralRecord'   => $plural_rec,
            'nameModel'      => $modelName,
            'nameController' => $controllerName,
            'foreignkeys'    => $foreignkeys,
            'views_path'     => $views_path,
        ];
        $model_data  = $this->getDatesForModel($fields, $foreignkeys, $namespace);
        $table_data  = $this->getDatesForTable($fields);
        $form_input  = $this->getInputForm($fields, $foreignkeys);
        $form_edit  = $this->getEditForm($fields, $foreignkeys);
        $field_data  = $this->getDatesForFields($fields);
        $routes_data = $this->getDatesForRoutes($general_data);
        $migration_data = $this->getDatesForMigration($fields, $primarykey, $foreignkeys, $index_data);
        $this->data  = array_merge($general_data, $model_data, $table_data, $form_input, $form_edit, $field_data, $routes_data, $migration_data);
        $this->createFileCrud($this->data);


        CLI::write('Database: ' . CLI::color($db_in_use, 'yellow'));
        CLI::write('Table: ' . CLI::color($table, 'yellow'));
        CLI::write('Namespace: ' . CLI::color($namespace, 'yellow'));
        CLI::write('Controller Name: ' . CLI::color($controllerName, 'yellow'));
        CLI::write('Model Name: ' . CLI::color($modelName, 'yellow'));

        CLI::write("Controller Generated successfully!", "cyan");
        CLI::write("Model Generated successfully!", "cyan");
        CLI::write("Views Generated successfully!", "cyan");
        CLI::write("Crud Generated successfully!", "blue");
    }
}
