<?php
// php spark make:crud --table 'cmms_activity' --namespace 'Matleyx\CI4CMMS'
namespace Matleyx\CI4P\Libraries\CrudLib;

use Config\Autoload;
use Config\Services;

trait CrudConstruct
{
    //  HTML OUTPUT    
    protected function getDatesForModel($fields, $foreignkeys, $namespace = 'App')
    {
        if ($foreignkeys !== false) {
            foreach ($foreignkeys as $fk) {
                $modeluse[]       = 'use ' . $namespace . '\Models\\' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modelprotected[] = "\t" . 'protected $model_' . $fk['foreign_table_name'] . ';';
                $modelconstruct[] = "\t\t" . '$this->model_' . $fk['foreign_table_name'] . ' = new ' . pascalize($fk['foreign_table_name']) . 'Model;';
                $modeldatajoin[]  = "\t\t" . '$data[\'' . $fk['foreign_table_name'] . '\'] = $this->model_' . $fk['foreign_table_name'] . '->getForOptionBox();';
            }
            $model_rows_join = '';
            foreach ($foreignkeys as $fk) {
                $model_rows_join .= "\t\t" . '$this->join(\'' . $fk['foreign_table_name'] . '\', \'' . $fk['foreign_table_name'] . '.' . $fk['foreign_column_name'][0] . ' = ' . $fk['tab_name'] . '.' . $fk['column_name'][0] . '\');' . "\n";
            }
            $modeljoin = "\t" . 'function j_findAll(){' . "\n";
            $modeljoin .= "\t\t" . '$this->select(\'*\');' . "\n";
            $modeljoin .= $model_rows_join;
            $modeljoin .= "\t\t" . 'return $this->findAll();' . "\n";
            $modeljoin .= "\t" . '}' . "\n";
            $modeljoin .= "\t\n";
            $modeljoin .= "\t" . 'function j_find($id){' . "\n";
            $modeljoin .= "\t\t" . '$this->select(\'*\');' . "\n";
            $modeljoin .= $model_rows_join;
            $modeljoin .= "\t\t" . 'return $this->find($id);' . "\n";
            $modeljoin .= "\t" . '}' . "\n";
            $modeljoin .= "\t\n";
        } else {
            $modeluse[]       = '';
            $modelprotected[] = '';
            $modelconstruct[] = '';
            $modeldatajoin[]  = '';
            $modeljoin        = '';
        }
        foreach ($fields as $field) {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false)) {
                $allowedFields[] = "\t\t\t" . "'" . $field->name . "',";
            }
        }
        if (!isset($allowedFields)) {
            $allowedFields[] = '';
        }

        // echo "Inizio\n";
        // var_dump($allowedFields);
        // echo "Fine\n";
        // $option_box = "\t" . 'function getForOptionBox(){' . "\n";
        // $option_box .= "\t\t" . '$this->select(\'Field1,Field2\');' . "\n";
        // $option_box .= "\t\t" . '$this->orderBy(\'Field2\');' . "\n";
        // $option_box .= "\t\t" . '$all_for_opt_box_ini = $this->findAll();' . "\n";
        // $option_box .= "\t\t" . 'foreach ($all_for_opt_box_ini as $in)' . "\n";
        // $option_box .= "\t\t\t" . '{' . "\n";
        // $option_box .= "\t\t\t" . '$r[\'Field1\'] = $in[\'Field1\']' . "\n";
        // $option_box .= "\t\t\t" . '$r[\'Field2\'] = $in[\'Field2\']' . "\n";
        // $option_box .= "\t\t\t" . '$all_for_opt_box_fin[] = $r;' . "\n";
        // $option_box .= "\t\t\t" . '}' . "\n";
        // $option_box .= "\t\t" . 'return $all_for_opt_box_fin;' . "\n";
        // $option_box .= "\t" . '}' . "\n";

        $option_box = "\t" . 'function getForOptionBox(){' . "\n";
        $option_box .= "\t\t" . '$this->select(\'Field1,Field2\');' . "\n";
        $option_box .= "\t\t" . '$this->orderBy(\'Field2\');' . "\n";
        $option_box .= "\t\t" . '$all_for_opt_box_ini = $this->findAll();' . "\n";
        $option_box .= "\t\t" . '$all_for_opt_box_fin = [];' . "\n";
        $option_box .= "\t\t" . 'foreach ($all_for_opt_box_ini as $in)' . "\n";
        $option_box .= "\t\t\t" . '{' . "\n";
        $option_box .= "\t\t\t" . '$all_for_opt_box_fin[$in[\'Field1\']] = $in[\'Field2\'];' . "\n";
        $option_box .= "\t\t\t" . '}' . "\n";
        $option_box .= "\t\t" . 'return $all_for_opt_box_fin;' . "\n";
        $option_box .= "\t" . '}' . "\n";

        return array(
            'allowedFields'  => join("\n", $allowedFields),
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
        foreach ($fields as $field) {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false)) {
                if (!$field->primary_key && $field->name !== 'password') {
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
    protected function getDatesForFields($fields)
    {
        foreach ($fields as $field) {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false)) {
                $fields_get[]  = "\t\t\t$" . $field->name . ' = $this->request->getPost(\'' . $field->name . '\');';
                $fields_data[] = "\t\t\t" . '$insert_data->' . $field->name . ' = $' . $field->name . ';';
                $fields_val[]  = "\t'" . $field->name . '\'=>\'required\'';
                $valueInput[]  = '$(\'[name="' . $field->name . '"]\').val((data.' . $field->name . '));';
                $fields_data_class[] = "\t\t\t" . '$insert_data->' . $field->name . ' = $this->request->getPost(\'' . $field->name . '\');';
            }
        }

        return array(
            'fieldsGet'  => join("\n", $fields_get),
            'fieldsData' => join("\n", $fields_data),
            'fieldsDataC' => join("\n", $fields_data_class),
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
}
