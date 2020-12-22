<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<h1>
    Cruds
</h1>
<div class="row">
    <div class="col-md-6">
        <?php echo form_open('mt_crud/crudgen', array("class" => "form-horizontal")); ?>

        <div class="row">
            <div class="form-group">
                <label for="tipo" class="col-md-2 control-label">
                    Tabella
                </label>
                <div class="col-md-4">
                    <select id="table_name" name="tname" class="form-control">
                        <?php
                        foreach ($result as $key => $value)
                            {
                            ?>
                            <option value="<?php echo $value; ?>">
                                <?php echo $value; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="download" class="btn btn-success">
                        Download
                    </button>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>

    </div>
</div>
<?php $this->endSection(); ?>