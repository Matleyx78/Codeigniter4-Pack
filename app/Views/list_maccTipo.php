<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('templates/header');
//$arr = get_defined_vars();
//echo '<pre>';
//print_r($_ci_vars);
//echo '</pre>';

?>
<!--
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">List maccTipo</h1>
    </div>
</div>
-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Elenco maccTipi</a>
                        <form class="navbar-form navbar-left form-inline" role="form" action="<?php echo base_url()."index.php/maccTipo/maccTipi_search_id";?>" method="post">
                            
                                <input type="text" class="form-control" name="search_id" placeholder="Search id..." id="search_id">
                            
                                <button type="submit" class="btn btn-info" name="submit">Cerca...</button>
                        </form>
                            
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?php echo site_url('maccTipo/create_MaccTipo'); ?>"><span class="glyphicon glyphicon-plus"></span> Aggiungi MaccTipo</a></li>
                    </ul>
                </div>
            </nav>

            <div class="panel-body"><p><?php echo $message;?></p>
                <div class="table-responsive">
                    <table class="table table-striped">                
                        <tr>
 
                            <th>id tipomacc</th> 
                            <th>macc codtipo</th> 
                            <th>macc descrtipo</th> 
                            <th>macc obsoletatipo</th> 
                            <th>macc tipoaltro</th>
                            <th>Actions</th>
                        </tr>
                        
                <?php foreach($maccTipi as $k){ ?>
                
                        <tr>
 
                            <td><?php echo $k['id_tipomacc']; ?></td> 
                            <td><?php echo $k['macc_codtipo']; ?></td> 
                            <td><?php echo $k['macc_descrtipo']; ?></td> 
                            <td><?php echo $k['macc_obsoletatipo']; ?></td> 
                            <td><?php echo $k['macc_tipoaltro']; ?></td>
                            <td>
                                <!--<a href="<?php echo site_url('maccTipo/create_MaccTipo'); ?>" class="btn btn-success btn-sm">Aggiungi MaccTipo</a>-->
                                <a href="<?php echo site_url('maccTipo/edit_MaccTipo/'.$k['id_tipomacc']); ?>" class="btn btn-warning btn-xs">Modifica</a>
                                <a href="<?php echo site_url('maccTipo/remove_MaccTipo/'.$k['id_tipomacc']); ?>" class="btn btn-danger btn-xs">Elimina</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                    <div align="center"><?php echo $links;?></div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('templates/footer');?>
        