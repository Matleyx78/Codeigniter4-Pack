<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Table detail
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        
                        <?php echo form_open('mt_crud/test'); ?>
    
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="cname" class="control-label">Name Controller</label>
                            <div class="form-group">
                                    <?php //echo form_error('cname'); ?>
                                    <input type="text" name="cname" value="" class="form-control" id="cname" />
                                    <input type="hidden" name="tname" value="<?php echo $tname; ?>" class="form-control" id="tname" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="rname" class="control-label">Name record</label>
                            <div class="form-group">
                                    <?php //echo form_error('anar_peso_teo'); ?>
                                    <input type="text" name="rname" value="" class="form-control" id="rname" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="softd" class="control-label">Use soft deleted</label>
                            <div class="form-group">
                                    <?php //echo form_error('anar_riservato'); ?>
                                <select name="softd" class="form-control">
                                    <option value="1" selected="selected" class="form-control" id="softd">Yes</option>
                                    <option value="0" class="form-control" id="softd">No</option>
                                            
                                </select>
                            </div>    
                        </div>    
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="times" class="control-label">Use timestamp</label>
                            <div class="form-group">
                                    <?php //echo form_error('anar_riservato'); ?>
                                <select name="times" class="form-control">
                                    <option value="1" selected="selected" class="form-control" id="times">Yes</option>
                                    <option value="0" class="form-control" id="times">No</option>
                                            
                                </select>
                            </div>    
                        </div>                         
                    </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Salva
                            </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>