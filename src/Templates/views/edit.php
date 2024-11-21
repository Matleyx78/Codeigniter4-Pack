@= $this->extend('layouts/main') !php
@= $this->section('content') !php
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Modifica record
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">

						@php echo form_open(base_url('{! table !}/update')); !php
						<input type="hidden" name="{! primaryKey !}" value="@= $value['{! primaryKey !}'] !php">
						{! editForm !}
						<div class="form-group">
							<button type="submit" class="btn btn-success">
								<i class="fa fa-check"></i> Salva
							</button>
						</div>

						@php echo form_close(); !php
						<!-- <div class="col-md-12 d-flex justify-content-between align-items-center">
			                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
			                    <button type="submit" id="submit" class="btn btn-primary btn-sm">Save</button>
			                </div> -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@= $this->endSection() !php