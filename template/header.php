<!DOCTYPE html>
<html lang="de">
	<head>
		<base href="<?php echo $data['request']->getUri()->getBasePath(); ?>/" target="_self">

		<title><?php echo htmlentities(isset($pageTitle) ? $pageTitle . ' - Brony Radio Germany Meetup' : 'Brony Radio Germany Meetup'); ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="img/favicon.ico" type="image/x-icon" />

		<link href="css/materialize.min.css" rel="stylesheet">
		<link href="css/color.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
	</head>

	<body class="grey darken-4">

	<?php include_once(__DIR__ . '/navbar.php'); ?>

	<div class="parallax-container">
		<div class="parallax hide-on-small-only">
			<img src="img/header.png" alt="Brony Radio Germany - Where Bronies Come Together">
		</div>

		<div class="parallax hide-on-med-and-up">
			<img src="img/header-mobile.png" alt="Brony Radio Germany - Where Bronies Come Together">
		</div>
	</div>
