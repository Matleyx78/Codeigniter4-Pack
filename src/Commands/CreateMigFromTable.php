<?php 
namespace Matleyx\CI4P\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;
use Matleyx\CI4P\Libraries\GenerateMigFromTable;

class CreateMigFromTable extends BaseCommand
{
    //  php spark make:migfromtable --table 'NAMETABLE' --database 'database'
    use GenerateMigFromTable;
    protected $group       = 'Generators';
    protected $name        = 'make:migfromtable';
    protected $description = 'Generate migration file from an existing database/table';
    protected $data        = [];


    public function run(array $params)
    {
        helper('inflector');
        if (    isset($params['table']) )           {   $table          =   $params['table'];   } 
        if (    isset($params['database']) )        {   $database       =   $params['database'];   } 
        CLI::write('Included files: ' . CLI::color(count(get_included_files()), 'yellow'));
        
        //var_dump($table);
        if (empty($table))
        {
            $table      = CLI::prompt('Enter Table name');
        }
        if ($table == 'users' || $table == 'tbl_users' || $table == 'admins')
        {
           CLI::write('Cannot generate crud for '. CLI::color( $table , 'yellow') .' Table because it might interfere with your login Crud.', "red");
          exit;
        }
        if (empty($database))
        {
            $database      = CLI::prompt('Enter database name');
        }
        
        if (isset($table) and isset($database))
            {
                $res = $this->getTableData($table, $database);
                CLI::write("$table Table ok", "blue");
                foreach ($res as $k) {
                    echo $k->name.'-'.$k->type.PHP_EOL;
                }
        }else{
            CLI::write("$table Table no found", "red");
        }
    }
}