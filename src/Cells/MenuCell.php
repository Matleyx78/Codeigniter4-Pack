<?php
namespace Matleyx\CI4P\Cells;

use Matleyx\CI4P\Models\MenuItemsModel;

class MenuCell
{
    public $string = '';
    public function __construct($stringa = '')
    {
        //inizializzare della variabile $name
        $this->string = $stringa;
    }
    public function ret_menu($incoming =[])
    {        
        $meit_model = new MenuItemsModel;
        $menu = $meit_model->where('meit_id_megr',$incoming['group'])->findAll();
        foreach ($menu as $mn)
        {
            $menu2[$mn['id_meit']] = $mn;
        }

        $menu = $this->prepareMenu($menu2);
        $this->buildMenu($menu);
        return $this->string;
    }
    function prepareMenu($array)
    {
        $return = array();
        krsort($array);
        foreach ($array as $k => &$item)
        {
            if (is_numeric($item['meit_id_parent']))
            {
                $parent = $item['meit_id_parent'];
                if (empty($array[$parent]['Childs']))
                {
                    $array[$parent]['Childs'] = array();
                }
                //2
                array_unshift($array[$parent]['Childs'], $item);
                unset($array[$k]);
            }
        }
        ksort($array);
        return $array;
    }

    function buildMenu($array, $bip = '')
    {
        if ($bip == '')
        {
            $this->string = '';
        }
        $this->string .= '<ul>';
        foreach ($array as $item)
        {
            $this->string .= '<li>';
            $this->string .= $item['meit_text'];
            if (!empty($item['Childs']))
            {
                $this->buildMenu($item['Childs'], $this->string);
            }
            $this->string .= '</li>';
        }
        $this->string .= '</ul>';
    }


}