@= $this->extend('layouts/main'); !php
@= $this->section('content'); !php
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">Elenco {! nameEntity !}</a>
						<form class="navbar-form navbar-left form-inline" role="form" action="@php echo base_url('{! table !}/search_id')!php" method="post">

							<input type="text" class="form-control" name="search_id" placeholder="Search id..." id="search_id">

							<button type="submit" class="btn btn-info" name="submit">Cerca...</button>
						</form>

					</div>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="@php echo base_url('{! table !}/add') !php"><span class="glyphicon glyphicon-plus"></span> Add {! nameEntity !}</a></li>
					</ul>
				</div>
			</nav>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
					<thead>
						<tr>
							{! fieldsTh !}
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
							@php if(${! table !}): !php
							@php foreach(${! table !} as $row): !php
							<tr>
								{! fieldsTd !}
								<td>
									<a href="@php echo base_url('{! table !}/edit/'.$row['{! primaryKey !}']);!php" class="btn btn-warning btn-xs">Modifica</a>
									<a onclick="return confirm('Are you sure you want to delete this {! singularTable !}?')" href="@php echo base_url('{! table !}/delete/'.$row['{! primaryKey !}']);!php" class="btn btn-danger btn-xs">Elimina</a>
								</td>
							</tr>
							@php endforeach; !php
							@php endif; !php
						</tbody>
					</table>
					@php if (isset($pager)) : !php
					<div align="center">
						@= $pager->links() !php
					</div>
					@php endif ; !php
				</div>
			</div>
		</div>
	</div>
</div>
@= $this->endSection(); !php