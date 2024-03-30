<!doctype html>
<html lang="it">
  <head>
  <title>Matleyx Ci4</title>
    <meta charset="utf-8">
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="sb1/css/style.css">
		<link rel="stylesheet" href="sb1/css/personal.css">
  </head>
  <body>
  <div class="wrapper d-flex align-items-stretch">
  <?= view_cell('Matleyx\CI4P\Cells\MenuCell::menu_laterale', ['param1' => 'value1',]) ?>

        <!-- Page Content  -->
      <div id="content" class="p-4 pt-md-0 pl-md-5 pr-md-5 pb-md-5">

      <?= view_cell('Matleyx\CI4P\Cells\MenuCell::menu_alto', ['param1' => 'value1',]) ?>

      <?php $this->renderSection('content'); ?>

<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>

    <div class="copyrights">

        <p>&copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
            open source licence.</p>

    </div>

</footer>

<script src="sb1/js/jquery.min.js"></script>
    <script src="sb1/js/popper.js"></script>
    <script src="sb1/js/bootstrap.min.js"></script>
    <script src="sb1/js/main.js"></script>
  </body>
</html>
