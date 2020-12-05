<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<h1>Crud</h1>
<pre>
<?php print_r($tab); ?>
<?php print_r($fields); ?>
<?php print_r($keys); ?>
<?php print_r($fork); ?>
</pre>
<?php $this->endSection(); ?>