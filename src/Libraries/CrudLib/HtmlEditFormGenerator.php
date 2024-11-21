<?php

namespace Matleyx\CI4P\Libraries\CrudLib;

trait HtmlEditFormGenerator
{
    protected function getEditForm($fields, $foreignikeys)
    {
        foreach ($fields as $field) {
            if ((!$field->primary_key && !strpos($field->name, 'created_at') !== false && !strpos($field->name, 'updated_at') !== false && !strpos($field->name, 'deleted_at') !== false)) {

                $attr = '\'id=\\\'' . $field->name . '\\\' class=\\\'form-control\\\'\'';
                $standard[]    =   '<div class="row clearfix">';
                $standard[]    =   '<div class="col-md-6"> <!-- ' . $field->name . ' -->';
                $standard[]    =   '<?php echo form_label(\'' . $field->name . '\', \'' . ucwords(str_replace('_', ' ', ($field->name))) . '\');?>';
                $standard[]    =   '<div class="form-group">';
                $standard[]    =   '<?= validation_show_error(\'' . $field->name . '\') ?>';

                if (!empty($foreignikeys) and array_key_exists($field->name, $foreignikeys)) {
                    $standard[]    =   '<?php echo form_dropdown(\'' . $field->name . '\', $' . $foreignikeys[$field->name]['foreign_table_name'] . ', $value[\'' . $field->name . '\'] , ' . $attr . ');?>';
                } else {
                    $type = $this->getTypeInput($field->type);
                    switch ($type) {
                        case 'textarea':
                            $standard[]    =   '<?php echo form_textarea(\'' . $field->name . '\', $value[\'' . $field->name . '\'] , ' . $attr . ',\'' . $this->getTypeInput($field->type) . '\');?>';
                            break;
                        case 'date':
                            $standard[]   =     '<div class=\'input-group date\' id=\'datetimepicker' . $field->name . '\'>';
                            $standard[]    =   '<?php echo form_input(\'' . $field->name . '\', $value[\'' . $field->name . '\'] , ' . $attr . ',\'\');?>';
                            $standard[]   =     '<span class="input-group-addon">';
                            $standard[]   =     '<span class="glyphicon glyphicon-calendar"></span>';
                            $standard[]   =     '</span>';
                            $standard[]   =     '<script type="text/javascript">';
                            $standard[]   =     '$(function () {';
                            $standard[]   =     '$(\'#datetimepicker' . $field->name . '\').datetimepicker({';
                            $standard[]   =     'locale: \'it\',';
                            $standard[]   =     'format: \'YYYY-MM-DD\'';
                            $standard[]   =     '});';
                            $standard[]   =     '});';
                            $standard[]   =     '</script>';
                            $standard[]   =     '</div>';
                            break;
                        case 'datetime':
                            $standard[]   =     '<div class=\'input-group date\' id=\'datetimepicker' . $field->name . '\'>';
                            $standard[]    =   '<?php echo form_input(\'' . $field->name . '\', $value[\'' . $field->name . '\'] , ' . $attr . ',\'\');?>';
                            $standard[]   =     '<span class="input-group-addon">';
                            $standard[]   =     '<span class="glyphicon glyphicon-calendar"></span>';
                            $standard[]   =     '</span>';
                            $standard[]   =     '<script type="text/javascript">';
                            $standard[]   =     '$(function () {';
                            $standard[]   =     '$(\'#datetimepicker' . $field->name . '\').datetimepicker({';
                            $standard[]   =     'locale: \'it\',';
                            $standard[]   =     'format: \'YYYY-MM-DD HH:mm:ss\'';
                            $standard[]   =     '});';
                            $standard[]   =     '});';
                            $standard[]   =     '</script>';
                            $standard[]   =     '</div>';
                            break;
                        default:
                            $standard[]    =   '<?php echo form_input(\'' . $field->name . '\', $value[\'' . $field->name . '\'] , ' . $attr . ',\'' . $this->getTypeInput($field->type) . '\');?>';
                            break;
                    }
                }
                $standard[]    =   '</div>'; //formgroup
                $standard[]    =   '</div>'; //col-md
                $standard[]    =   '</div>'; //row
                $editForm[]    =   join("\n", $standard);
                unset($standard, $attr);
            }
        }
        return array(
            'editForm' => join("\n", $editForm),
        );
    }
}
