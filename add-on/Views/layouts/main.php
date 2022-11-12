<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?php echo site_url(); ?>img/ci-icon.png" />
	<title>
		Matleyx Ci4
	</title>

	<link rel="stylesheet" href="<?php echo site_url(); ?>mat-assets/bootstraporiginal/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>mat-assets/css-personal/bootstrap-submenu.min.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>mat-assets/css-personal/docs.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>mat-assets/css-personal/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>mat-assets/css-personal/personal.css">

	<script type="text/javascript" src="<?php echo site_url(); ?>mat-assets/jqueryoriginal/jquery.min.js">
	</script>
	<script type="text/javascript" src="<?php echo site_url(); ?>mat-assets/js-personal/moment-with-locales.min.js">
	</script>
	<script type="text/javascript" src="<?php echo site_url(); ?>mat-assets/js-personal/bootstrap-datetimepicker.js">
	</script>

</head>
<?php
//$this->ionAuth = new \IonAuth\Libraries\IonAuth();
$part1 = "
    <nav class=\"navbar navbar-default navbar-fixed-top navbar-inverse\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">
            <span class=\"sr-only\">Toggle navigation</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
          <a class=\"navbar-brand\" href=".site_url().">Matleyx CI4</a>
        </div>
        <div id=\"navbar\" class=\"navbar-collapse collapse\">


          <ul class=\"nav navbar-nav\">
";

echo $part1;
$part2 ="";
$loggedin = true;
$isadmin = true;
$nome = 'nomignolo';
if ($loggedin)
{
	$part2 = "                          <p class=\"navbar-text\">".$nome." </p>
                                <li>".anchor('auth/logout', ' Logout','><span class="glyphicon glyphicon-log-out"></span')."</li>
";
}
else
{
	$part2 = "                          <li>".anchor('auth/login', ' Login','><span class="glyphicon glyphicon-log-out"></span')."</li>
";
};

echo $part2;
$part3 ="";
if ($isadmin)
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

echo $part3;
	echo '	</ul><ul class="nav navbar-nav navbar-right">';
$part4 ="";
$part4 = "
    <li class=\"dropdown\">
                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">FreeMenu1 <span class=\"caret\"></span></a>
                    <ul class=\"dropdown-menu\">
                        <li>".anchor('example_guest', 'Example Guest')."</li>
                    </ul>
                </li>
";


echo $part4;

$part5 ="";
if ($isadmin)
{
	$part5 = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Ammi <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('clientiadhoc', 'Clienti')."</li>
                                    <li>".anchor('ord_ap_ah/righe_ord_ap_ah', 'OrdAperti')."</li>
                                    <li>".anchor('report_verticale/index', 'Stampe Verticale')."</li>
                                    <li>".anchor('impianti/verticale', 'Consumi Verticale')."</li>
                                    <li>".anchor('maccMovimenti/index', 'Richieste Macchinette')."</li>
                                    <li>".anchor('officina/controllopronto', 'Controllo del pronto')."</li>
                                        <li>".anchor('officina/ricba_oiba', 'Controllo OIBA')."</li>
                                        <li>".anchor('officina/ricba_rmba', 'Controllo RMBA')."</li>
                                </ul>
                            </li>
";
}

echo $part5;

	$part6 ="";
	if ($loggedin)
	{
		if ($loggedin)
		{
			$part6 = "                  <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Ammi <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li>".anchor('clientiadhoc', 'Clienti')."</li>
                                    <li>".anchor('ord_ap_ah/righe_ord_ap_ah', 'OrdAperti')."</li>
                                    <li>".anchor('report_verticale/index', 'Stampe Verticale')."</li>
                                    <li>".anchor('impianti/verticale', 'Consumi Verticale')."</li>
                                    <li>".anchor('maccMovimenti/index', 'Richieste Macchinette')."</li>
                                    <li>".anchor('officina/controllopronto', 'Controllo del pronto')."</li>
                                        <li>".anchor('officina/ricba_oiba', 'Controllo OIBA')."</li>
                                        <li>".anchor('officina/ricba_rmba', 'Controllo RMBA')."</li>
                                </ul>
                            </li>
";
		}
	}
	echo $part6;

$part7 ="";
$part7 = "                                    </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
";


echo $part7;







?>

<body>

<div class="container-fluid">
			<?php $this->renderSection('content'); ?>
</div>
<div id="footer" class="footblock">
	<div class="container">
		<p class="text-muted navbar-text">
			<em>
				&copy; 2018 www.chiuna.it - powered by CodeIgniter <?php echo \CodeIgniter\CodeIgniter::CI_VERSION; ?>
			</em>
		</p>
	</div>
</div>

<script src="<?php echo site_url(); ?>mat-assets/bootstraporiginal/js/bootstrap.js" defer>
</script>
<script src="<?php echo site_url(); ?>mat-assets/js-personal/bootstrap-submenu.js" defer>
</script>
<script src="<?php echo site_url(); ?>mat-assets/js-personal/docs.js" defer>
</script>

</body>
</html>

