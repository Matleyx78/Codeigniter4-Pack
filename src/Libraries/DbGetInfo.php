<?php
// php spark make:crud --table 'cmms_activity' --namespace 'Matleyx\CI4CMMS'
namespace Matleyx\CI4P\Libraries;

use Config\Database;

trait DbGetInfo
    {
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
    protected function getIndex($db_in_use, $table, $std_fields)
        {
        $db = Database::connect($db_in_use);
        if ($db->tableExists($table))
            {
            $index_found = o_t_a($db->getIndexData($table));
            var_dump($index_found);
            if ($index_found)
                {
                foreach ($index_found as $if)
                    {
                    $std_fields[$if['fields'][0]]['index'] = $if;
                    $result[]                              = $if;
                    }
                $data['result']     = $result;
                $data['std_fields'] = $std_fields;
                return $data;
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
    protected function getForeignkey($db_in_use, $table, $std_fields)
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
                    $std_fields[$fk['column_name'][0]]['foreign_key'] = $fk;
                    $result[$fk['column_name'][0]]                    = array(
                        'tab_name'            => $table,
                        'column_name'         => $fk['column_name'][0],
                        'foreign_table_name'  => $fk['foreign_table_name'],
                        'foreign_column_name' => $fk['foreign_column_name'],
                        'fk_last'             => substr($fk['foreign_table_name'], -3),
                    );
                    }
                $data['result']     = $result;
                $data['std_fields'] = $std_fields;
                return $data;
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
    protected function getPrimaryKey($db_in_use, $table)
        {
        $fields = $this->getFields($db_in_use, $table);
        if ($fields == false)
            {
            return false;
            }
        foreach ($fields as $field)
            {
            if ($field->primary_key)
                {
                return $field->name;
                }
            }
        }
    protected function stdFields($fields)
        {
        $std_fields = array();
        foreach ($fields as $key => $field)
            {

            $new_row = array(
                'name'        => 'xxx' . $key,
                'type_sql'    => 'varchar',
                'max_lenght'  => 250,
                'nullable'    => 1,
                'default'     => null,
                'primary_key' => 0,
            );
            if (isset($field->name))
                {
                $new_row['name'] = $field->name;
                }
            if (isset($field->type))
                {
                $new_row['type_sql'] = $field->type;
                }
            $type_html = $this->getTypeInput($field->type);
            if ($type_html != '')
                {
                $new_row['type_html'] = $type_html;
                }
            if (isset($field->max_length))
                {
                $new_row['max_lenght'] = $field->max_length;
                }
            if (isset($field->nullable))
                {
                $new_row['nullable'] = $field->nullable;
                }
            if (isset($field->default))
                {
                $new_row['default'] = $field->default;
                }
            if (isset($field->primary_key))
                {
                $new_row['primary_key'] = $field->primary_key;
                }

            $std_fields[$new_row['name']] = $new_row;
            }
        return $std_fields;
        }
    protected function getTypeInput($type_sql)
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
    }