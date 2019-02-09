<!DOCTYPE html>
<html>
<head>
	<title>Website</title>
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap-3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap-3.4.0/css/bootstrap-theme.min.css">	
</head>

<body>
	<!-- Static navbar -->
	<?php $this->renderPartial('layout/header', ['title' => 'Project name']); ?>

	<!-- Container -->
    <div class="container">
		<?= $content; ?>
    </div> 

	<footer class="container-fluid text-center">
	  <p>Footer Text</p>
	</footer>


	<script type="text/javascript" src="../vendor/jquery-3.3.1/jquery-3.3.1-min.js"></script>
	<script type="text/javascript" src="../vendor/bootstrap-3.4.0/js/bootstrap.min.js"></script>
</body>
</html>