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
        if (    isset($params['table']) )           {   $table          =   $params['table'];   } 
        if (    isset($params['controllerName']) )  {   $controllerName =   $params['controllerName'];   } 
        if (    isset($params['modelName']) )       {   $modelName      =   $params['modelName'];   } 
        if (    isset($params['namespace']) )       {   $namespace      =   $params['namespace'];   } 
        if (    isset($params['routegroup']) )      {   $routegroup     =   $params['routegroup'];   } 
        if (    isset($params['single_rec']) )      {   $single_rec     =   $params['single_rec'];   } 
        CLI::write('Included files: ' . CLI::color(count(get_included_files()), 'yellow'));
        
        var_dump($table);
        if (empty($table))
        {
            $table      = CLI::prompt('Enter Table name');
        }
        if ($table == 'users' || $table == 'tbl_users' || $table == 'admins')
        {
           CLI::write('Cannot generate crud for '. CLI::color( $table , 'yellow') .' Table because it might interfere with your login Crud.', "red");
          exit;
        }
        if (empty($namespace))
        {
            $namespace      = "App";
        }
        $controllerName = pascalize($table) .'Controller';
        $modelName      = pascalize($table) .'Model';

        $foreignkeys = $this->getForeignkey($table);
        if (empty($foreignkeys)){$foreignkeys = false;}
        
        if ($fields_db =  $this->getFields($table)){
            if (empty($routegroup)) {
                $routegroup = CLI::prompt('Which Route group do you want to Use for the routes?', ['editor','admin'], 'min_length[3]'); 
            }
            $this->data = [
                'table'             => $table,
                'table_lc'          => strtolower($controllerName),
                'primaryKey'        => $this->getPrimaryKey($fields_db),
                'pk_string'         => substr($this->getPrimaryKey($fields_db), -4),
                'namespace'         => $namespace,
                'nameEntity'        => ucfirst($table),
                'singularTable'     => singular($table),
                'nameModel'         => ucfirst($modelName),
                'nameController'    => ucfirst($controllerName),
                'routegroup'        => $routegroup,
                'foreignkeys'       => $foreignkeys,
                'allowedFields'     => $this->getDatesFromFields($fields_db, $foreignkeys)['allowedFields'],
                'fieldsGet'         => $this->getDatesFromFields($fields_db, $foreignkeys)['fieldsGet'],
                'fieldsData'        => $this->getDatesFromFields($fields_db, $foreignkeys)['fieldsData'],
                'fieldsVal'         => $this->getDatesFromFields($fields_db, $foreignkeys)['fieldsVal'],
                'fieldsTh'          => $this->getDatesFromFields($fields_db, $foreignkeys)['fieldsTh'],
                'fieldsTd'          => $this->getDatesFromFields($fields_db, $foreignkeys)['fieldsTd'],
                'inputForm'         => $this->getDatesFromFields($fields_db, $foreignkeys)['inputForm'],
                'editForm'          => $this->getDatesFromFields($fields_db, $foreignkeys)['editForm'],
                'valueInput'        => $this->getDatesFromFields($fields_db, $foreignkeys)['valueInput'],
                'modeluse'          => $this->getDatesFromFields($fields_db, $foreignkeys)['modeluse'],
                'modelprotected'    => $this->getDatesFromFields($fields_db, $foreignkeys)['modelprotected'],
                'modelconstruct'    => $this->getDatesFromFields($fields_db, $foreignkeys)['modelconstruct'],
                'modeldatajoin'     => $this->getDatesFromFields($fields_db, $foreignkeys)['modeldatajoin'],
                'modeljoin'         => $this->getDatesFromFields($fields_db, $foreignkeys)['modeljoin'],
            ];
            //var_dump($foreignkeys);
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