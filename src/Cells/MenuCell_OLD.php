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
             
    function buildMenuSimple()
        {
            $htmlmenu = "";
                    
            $htmlmenu .= $this->mStart();
            $htmlmenu .= $this->mLoginLogout();
            $htmlmenu .= $this->partAdmin();
            $htmlmenu .= "                                      </ul><ul class=\"nav navbar-nav navbar-right\">";
            //$htmlmenu .= $this->partFree();
            $htmlmenu .= $this->partAmmi();
            $htmlmenu .= $this->partCommer();
            $htmlmenu .= $this->partProd();
            $htmlmenu .= $this->partIso();
            $htmlmenu .= $this->partUti();
            $htmlmenu .= $this->partOffi();

            $htmlmenu .= $this->partInv();             
            //$htmlmenu .= $this->partAllLogged();
            $htmlmenu .= $this->mStop();
            
            return $htmlmenu;
        }
        function mStart()
        {
                        $start = "
                        <ul class=\"list-unstyled components mb-5\">
";
                        
            return $start;            
        }    
        function mStop()
        {
                        $start = "
                        </ul>
";
                        
            return $start;            
        }    

    function mLoginLogout()
        {
            if (auth()->loggedIn()) {
                        $log = "
                    <li>".anchor('logout', ' Logout','><span class="glyphicon glyphicon-log-out"></span')."</li>
";
}else {
                        $log = "
                    <li>".anchor('login', ' Login','><span class="glyphicon glyphicon-log-in"></span')."</li>
";
}
                        
            return $log;            
        }

    function part2()
        {
            $part2 ="";
            if($this->ci->ion_auth->logged_in())
                {
$part2 = "                          <p class=\"navbar-text\">".$this->ci->session->first_name." </p>
                                <li>".anchor('auth/logout', ' Logout','><span class="glyphicon glyphicon-log-out"></span')."</li>
";
                }else
                    {
$part2 = "                          <li>".anchor('auth/login', ' Login','><span class="glyphicon glyphicon-log-out"></span')."</li>
";                    
                    };        
                        
            return $part2;            
        }

    function partAdmin()
        {
            $part3 ="";
            if($this->ci->ion_auth->is_admin())
                {
$part3 = "                          <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Admin <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('auth/index', 'Utenti')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('toexcel/listino_excel', 'ListinoExcel')."</li>
                                    <li>".anchor('prezzisconti/provalistino', 'Listino2')."</li>
                                    <li>".anchor('report/calendario', 'Stampa Calendario')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('crud', 'Crud Generator')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li class=\"dropdown-submenu\">
                                        <a tabindex=\"0\">Archivi</a>
                                        <ul class=\"dropdown-menu\">
                                            <li>".anchor('dipendelenco/dipendenti', 'Elenco Dipendenti')."</li>
                                            <li>".anchor('report/timbrature', 'Timbrature')."</li>
                                            <li>".anchor('reparti/index', 'Elenco Reparti')."</li>
                                            <li>".anchor('maccTipo/index', 'Tipi Macchinette')."</li>
                                            <li>".anchor('off_ces_num/index', 'Elenco Ceste')."</li>
                                            <li>".anchor('prova/index', 'date')."</li>
                                            <li>".anchor('reportlistini/provamulti', 'Multicolonnapdf')."</li>
                                            <li>".anchor('statistiche/index2', 'StatPietro')."</li>
                                        </ul>
                                    </li>
                                    <li class=\"dropdown-submenu\">
                                        <a tabindex=\"0\">AdHoc</a>
                                        <ul class=\"dropdown-menu\">
                                            <li>".anchor('adhoc_clienti/pl_ah_cli', 'Clienti')."</li>
                                            <li>".anchor('adhoc_bolle/adhoc_righebolle', 'Bolle')."</li>
                                            <li>".anchor('adhoc_colori/adhoc_colori', 'Colori')."</li>
                                            <li>".anchor('adhoc_agenti/pl_ah_agenti', 'Agenti')."</li>
                                            <li>".anchor('adhoc_sv002/adhoc_righesconti', 'Sv002')."</li>
                                            <li>".anchor('adhoc_n0050/adhoc_righelist', 'N0050')."</li>
                                            <li>".anchor('adhoc_zii_comm/adhoc_righezii', 'Zii Comm')."</li>
                                            <li>".anchor('adhoc_fatt/controlla', 'Controllo Sconti')."</li>                                                
                                            <li>".anchor('adhoc_remote/test1', 'Controllo Test1')."</li>
                                        </ul></li>
                                    <li class=\"dropdown-submenu\">
                                        <a tabindex=\"0\">Connessione</a>
                                        <ul class=\"dropdown-menu\">
                                            <li>".anchor('connessione/index', 'Connessione')."</li>
                                        </ul>
                                    </li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('csv', 'Importa Csv')."</li>
                                    <li>".anchor('arch_comm/recupera_clc', 'Recupera CLC')."</li>
                                    <li>".anchor('adhoc_remote/sottoscortabarre', 'Barre Sottoscorta')."</li>
                                    <li>".anchor('shell/leggicartella', 'ProvaUpload')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('kyocera', 'Fotocopiatrice')."</li>
                                    </li>
                                </ul>
                            </li>
                            
";
                }        
                        
            return $part3;            
        }

    function partFree()
        {
            $part4 ="";
$part4 = "                          
    <li class=\"dropdown\">
                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">FreeMenu1 <span class=\"caret\"></span></a>
                    <ul class=\"dropdown-menu\">
                        <li>".anchor('example_guest', 'Example Guest')."</li>                              
                    </ul>
                </li>
";
        
                        
            return $part4;            
        }

    function partAmmi()
        {
            $part5 ="";
            if($this->ci->ion_auth->in_group(3))
                {
$part5 = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Ammi <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('clientiadhoc', 'Clienti')."</li>
                                    <li>".anchor('ord_ap_ah/righe_ord_ap_ah', 'OrdAperti')."</li>
                                    <li>".anchor('report_verticale/index', 'Stampe Verticale')."</li>
                                    <li>".anchor('impianti/verticale', 'Consumi Verticale')."</li>
                                    <li>".anchor('maccMovimenti/index', 'Richieste Macchinette')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('distinte/index_giornata', 'Distinte')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('officina/controllopronto', 'Controllo del pronto')."</li>
                                        <li>".anchor('officina/ricba_oiba', 'Controllo OIBA')."</li>
                                        <li>".anchor('officina/ricba_rmba', 'Controllo RMBA')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $part5;            
        }

    function partCommer()
        {
            $partCom ="";
            if($this->ci->ion_auth->in_group(4))
                {
$partCom = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Commer <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('agenti', 'Agenti')."</li>
                                    <li>".anchor('eventi', 'Eventi')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('rep_acc/index', 'Stampa Listini Anna')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('programmazione/index_verticale', 'Programma Verticale')."</li>
                                    <li>".anchor('programmazione/index_verticale_barb', 'Programma Barberino')."</li>
                                    <li>".anchor('programmazione/index_orizzontale', 'Programma Orizzontale')."</li>
                                    <li>".anchor('reportprog/verticale_calendario_storico', 'Storico Verticale')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $partCom;            
        }        
        
    function partProd()
        {
            $part5 ="";
            if($this->ci->ion_auth->in_group(5))
                {
$part5 = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Prod <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('programmazione/index', 'Commesse')."</li>
                                    <li>".anchor('programmazione/index_raggruppamenti', 'Raggruppamenti Commesse')."</li>
                                    <li>".anchor('programmazione/index_giorniore', 'Ore al giorno')."</li>
                                    <li>".anchor('adhoc_colori/adhoc_colori', 'Colori')."</li>
                                    <li>".anchor('cli_interface/rec_aluaro', 'Recupera Aluaro')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('off_imb_pez/statimb', 'Imballo')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('dipendenti/index', 'Elenco Dipendenti')."</li>
                                    <li>".anchor('dipendenti/assenze', 'Assenze')."</li>
                                    <li>".anchor('dipendenti/posizionamenti', 'Posizionamenti')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('report/reportprodgen', 'Report Generale')."</li>
                                    <li>".anchor('report_ceste/index', 'Report Ceste')."</li>
                                    <li>".anchor('report_sublimazione/index', 'Report Sublimazione')."</li>
                                    <li>".anchor('report_verticale/index', 'Report Verticale')."</li>
                                    <li>".anchor('stat_tempi_evas/index_graf', 'Evasioni')."</li>
                                    <li>".anchor('produzione/cerca_commessa', 'Storia Commessa')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('produzione/produzioni_index', 'Prova1')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $part5;            
        }

    function partOffi()
        {
            $part5 ="";
            if($this->ci->ion_auth->in_group(6))
                {
$part5 = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Offi <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('officina', 'Sublimazione')."</li>
                                    <li>".anchor('off_sub_cot/sub_cot_index', 'Cottura')."</li>
                                    <li>".anchor('off_ces_rag/index_ceste_costr', 'Ceste')."</li>
                                    <li>".anchor('off_ces_rag/index_ceste_crom', 'Cromatazione')."</li>
                                    <li>".anchor('off_ver_agg/index', 'Verticale')."</li>
                                    <li>".anchor('maccMatricole/index', 'Elenco Macchinette')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('officina/cataloghi', 'Cataloghi')."</li>
                                    <li>".anchor('officina/ubicazioni', 'Ubicazioni')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $part5;            
        }

    function partInv()
        {
            $part5 ="";
            if($this->ci->ion_auth->in_group(6))
            //if($this->ci->ion_auth->is_admin())
                {
$part5 = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Inventario <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('inventario_gen/art_tutti', 'Articoli tutti')."</li>
                                    <li>".anchor('inventario_gen/polveri', 'Polveri')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('inventario_ilav/pl_inv_ilav', 'Materiale gia in lavorazione')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('inventario_cont/pl_inv_cont', 'Materiale contato')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('inventario_ret/art_tutti', 'Visualizza rettifiche')."</li>

                                </ul>
                            </li>
";
                }        
                        
            return $part5;            
        }
        
    function partIso()
        {
            $partIso ="";
            if($this->ci->ion_auth->in_group(7))
                {
$partIso = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">ISO <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('nc_registrazioni/registrazioni_nc', 'Elenco NC')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('reportprog/verticale_calendario_storico', 'Storico Verticale')."</li>
                                    <li>".anchor('toexcel/cotturasub', 'Excel cotture sub')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('cairoevents/pl_ca_even', 'Eventi Azienda')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $partIso;            
        }

    function partUti()
        {
            $partUti ="";
            if($this->ci->ion_auth->in_group(8))
                {
$partUti = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Util <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('vascometro/calcola', 'Vascometro')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('reportlistini/N0050', 'Listino')."</li>
                                    <li>".anchor('utility/allum', 'Alluminio')."</li>
                                    <li>".anchor('statistiche', 'Statistiche')."</li>
                                    <li>".anchor('statistiche/parametri', 'Statistiche Parametriche')."</li>
                                    <li>".anchor('adhoc_statp/venditestat', 'Statistiche Pietro')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('adhoc_clienti/mail_clienti_da_stat_pietro', 'Email clienti ultimi 365 gg')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('automezzi/index', 'Automezzi')."</li>
                                    <li>".anchor('tachi_record/auti_giorno', 'Tachi Autista-Giorno')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('slick160/index', 'Test160')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $partUti;            
        }
        
    function partAllLogged()
        {
            $part6 ="";
            if($this->ci->ion_auth->logged_in())
                {
$part6 = "              <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">All logged <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('example_logged', 'Example logged')."</li>
                                    <li role=\"separator\" class=\"divider\"></li>
                                    <li>".anchor('example_logged', 'Example logged')."</li>
                                </ul>
                            </li>
";
                }        
                        
            return $part6;            
        }

    function partFinal()
        {
            $part7 ="";
$part7 = "                                    </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
";
        
                        
            return $part7;            
        }

}