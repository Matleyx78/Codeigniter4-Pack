<?php 
namespace Matleyx\CI4P\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;
use Matleyx\CI4P\Libraries\Generate;

class CreateCrud extends BaseCommand
{
    use Generate;
    protected $group       = 'Generators';
    protected $name        = 'make:crud';
    protected $description = 'Generate CRUD based on model, (External Library)';
    protected $data        = [];


    public function run(array $params)
    {
        helper('inflector');
        $table          = array_shift($params);
        $controllerName = array_shift($params);
        $modelName      = array_shift($params);
        $namespace      = array_shift($params);
        $routegroup     = array_shift($params);
        $single_rec     = array_shift($params);

        if (empty($table))
        {
            $table      = CLI::prompt('Enter Table name');
        }
        if ($table == 'users' || $table == 'tbl_users' || $table == 'admins')
        {
           CLI::write('Cannot generate crud for '. CLI::color( $table , 'yellow') .' Table because it might interfere with your login Crud.', "red");
          exit;
        }
        $controllerName = pascalize($table) .'Controller';
        $modelName      = pascalize($table) .'Model';
        $namespace      = "App";
        var_dump($modelName);
        if ($fields_db =  $this->getFields($table)){
            if (empty($routegroup)) {
                $routegroup = CLI::prompt('Which Route group do you want to Use for the routes?', ['editor','admin'], 'min_length[3]'); 
            }
            $this->data = [
                'table'             => $table,
                'table_lc'             => strtolower(pascalize($table)),
                'primaryKey'        => $this->getPrimaryKey($fields_db),
                'namespace'         => $namespace,
                'nameEntity'        => ucfirst($table),
                'singularTable'     => singular($table),
                'nameModel'         => ucfirst($modelName),
                'nameController'    => ucfirst($controllerName),
                'routegroup'        => $routegroup,
                'allowedFields'     => $this->getDatesFromFields($fields_db)['allowedFields'],
                'fieldsGet'         => $this->getDatesFromFields($fields_db)['fieldsGet'],
                'fieldsData'        => $this->getDatesFromFields($fields_db)['fieldsData'],
                'fieldsVal'         => $this->getDatesFromFields($fields_db)['fieldsVal'],
                'fieldsTh'          => $this->getDatesFromFields($fields_db)['fieldsTh'],
                'fieldsTd'          => $this->getDatesFromFields($fields_db)['fieldsTd'],
                'inputForm'         => $this->getDatesFromFields($fields_db)['inputForm'],
                'editForm'          => $this->getDatesFromFields($fields_db)['editForm'],
                'valueInput'        => $this->getDatesFromFields($fields_db)['valueInput'],
            ];

            $this->createFileCrud($this->data);
            CLI::write("Controller Generated successfully!", "cyan");
            CLI::write("Model Generated successfully!", "cyan");
            CLI::write("Views Generated successfully!", "cyan");
            CLI::write("Crud Generated successfully!", "blue");

        }else{
            CLI::write("$table Table no found", "red");
        }
    }
}