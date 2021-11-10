<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Balloon Republic:'); ?>
		<?php echo $title_for_layout; ?>
	</title>

	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Paulo Biscocho">
	<meta property="og:title" content="Balloon Republic Event & Party Needs">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo $this->base;?>/">
	<meta property="og:site_name" content="Balloon Republic">
	<meta property="og:description" content="Balloon Republic Event & Party Needs">
	<meta property="og:image" content="<?php echo $this->base;?>/img/logo.png">
	
	<link href="<?php echo $this->base;?>/img/logo2.png" type="image/x-icon" rel="icon">
	<link href="<?php echo $this->base;?>/img/logo2.png" type="image/x-icon" rel="shortcut icon">
	
	<?php
		//echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap'); //Bootstrap Core CSS
		echo $this->Html->css('balloonrep'); //Custom CSS
		echo $this->Html->css('template\font-awesome-4.4.0\css\font-awesome'); //Custom Fonts
		echo $this->Html->css('plugins/summernote');
	?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
</head>
<body>
    <div ng-app="App" id="wrap">
        <div id="ContentForLayoutContainer" class="container">
			<?php echo $content_for_layout; ?>
        </div>
    </div>
	<?php
		echo $this->Html->script(array('jquery')); 
		echo $this->Html->script(array('bootstrap.min')); //Bootstrap Core JavaScript
		echo $this->Html->script('constant');
		//echo $this->Html->script(array('template/angular'));
		echo $this->Html->script(array('template/angularjs1.4'));
		echo $this->Html->script(array('template/angular-sanitize'));
		echo $this->Html->script(array('angularUtils/directives/dirPagination'));
		echo $this->Html->script(array('angularUtils/directives/ui-bootstrap-tpls-0.14.3.min'));
		echo $this->Html->script('plugins/summernote');
	?>
	<script type="text/javascript">(function(){window.App = angular.module('App',['angularUtils.directives.dirPagination','ngSanitize'])})();</script>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$("#flashMessage").click(function(){
				$("#flashMessage").html('').hide(400);
			});
			setTimeout(function(){
				$("#flashMessage").html('').hide(400);
			}, 4000);

		});
	</script>
	
	<?php  echo $scripts_for_layout; ?>
</body>
</html>