<?php
$heading_text = _lang('heading_text','maintenance_page');
$meta_keywords = $heading_text;
$meta_desc = $heading_text;
$meta_title = $heading_text;
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="IE=edge" >
	
	<meta name="keywords" content="<?=$meta_keywords?>" />
	<meta name="description" content="<?=$meta_desc?>" />
	<title><?=$meta_title?></title>

	<!-- Jquery Data Table -->
	<link rel="stylesheet" type="text/css" href="<?=SITE_URL?>assets/css/jquery.dataTables.css">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/style.css">
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/color.css">
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/intlTelInput.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css"/>
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/custom.css">
</head>
<body class="inner">
	<section id="offline" class="d-flex align-items-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="block p-5 text-center">
						<div class="card">
							<div class="card-body">
								<h1><?=$heading_text?></h1>
								<p><?=_lang('description','maintenance_page')?></p>
								<h5>&mdash; <?=SITE_NAME?></h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>