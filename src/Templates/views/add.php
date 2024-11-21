@= $this->extend('layouts/main') !php
@= $this->section('content') !php
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Aggiungi record
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="text-danger">
							@php if (!empty($errors)): !php
							@php foreach ($errors as $field => $error) : !php
							<div class="text-danger"> @= $error; !php </div>
							@php endforeach; !php
							@php endif; !php
						</div>
						@php echo form_open('{! table !}/save');!php
						<!-- <form role="form" action="@= site_url('/{! table !}/save') !php" method="post"> -->
						{! inputForm !}
						<div class="form-group">
							<button type="submit" class="btn btn-success">
								<i class="fa fa-check"></i> Salva
							</button>
						</div>
						@php echo form_close();!php
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@= $this->endSection() !php