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
		echo $this->Html->css('sesephil'); //Custom CSS
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
        <!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="/balloon-nation/pages" class="navbar-brand company-name">
						<img height="50px" class="" src="<?php echo $this->base;?>/img/name.png"></img>
		
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
							<li>
								<?php  echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-cubes')).' '.
									$this->Html->tag('span', 'Products'),
									array('admin' => false,'controller'=>'products','action'=>'/'),
									array('escape' => false));						
								?>
							</li>
							<li>
								<?php  echo $this->Html->link($this->Html->tag('i', '', array('class' =>'fa fa-info-circle')).' '.
									$this->Html->tag('span', 'About Us'),
									array('admin' => false,'controller'=>'','action'=>'/about-us'),
									array('escape' => false));						
								?>
							</li>
							<li>
								<?php  echo $this->Html->link($this->Html->tag('i', '', array('class' =>'fa fa-phone-square')).' '.
									$this->Html->tag('span', 'Contacts'),
									array('admin' => false,'controller'=>'','action'=>'/contacts'),
									array('escape' => false));						
								?>
							</li>
					
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>
        <div id="ContentForLayoutContainer" class="container">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('email'); ?>
			<!--
			<div id="flashMessage" class="message">Your message has been sent to our email. Will be replying to you soon.</div>
			-->
			<div class="breadcrumb">
				<?php echo $this->Html->getCrumbs(' <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> '); ?>
			</div>
			<?php echo $content_for_layout; ?>
        </div>
    </div>
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  text-muted">&#169;	<a href="javascript:void(0)">Balloon Republic 2020.</a></div>	
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-muted text-center ">	
					Follow us on
					<a href="javascript:void(0)" title="Visit our FB Page" data-toggle="tooltip" ><i class="fa fa-facebook-official"></i></a> 
					<a href="javascript:void(0)" title="Add as on LinkedIn" data-toggle="tooltip" ><i class="fa fa-linkedin-square"></i></a> 
					<a href="javascript:void(0)" title="Subscribe our Youtube Channel" data-toggle="tooltip" ><i class="fa fa-youtube-square"></i></a>
					<a href="javascript:void(0)" title="Follow us on IG" data-toggle="tooltip" ><i class="fa fa-instagram"></i></a>
					<a href="javascript:void(0)" title="Twit with us on Twitter" data-toggle="tooltip" ><i class="fa fa-twitter-square"></i></a> 
				</div>	
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  text-right">
				<?php  if($this->Access->isLoggedIn()):?>
						<?php	echo $this->Html->link(
								$this->Html->tag('span', 'Logout'),
								array('admin' => false,'controller'=>'users','action'=>'logout'),
								array('escape' => false));					
						?> | 
						<?php	echo $this->Html->link(
								$this->Html->tag('span', 'Dashboard'),
								array('admin' => false,'controller'=>'admin','action'=>'/'),
								array('escape' => false));	
						?>
				<?php else:?>
					<?php  echo $this->Html->link(
								$this->Html->tag('span', 'Register'),
								array('admin' => false,'controller'=>'users','action'=>'register'),
								array('escape' => false));
					?>
					|
					<?php echo $this->Html->link(
								$this->Html->tag('span', 'Sign In'),
								array('admin' => false,'controller'=>'users','action'=>'login'),
								array('escape' => false));
					?>
				<?php endif;?>		
			</div>
			</div>
		</div>
	</div>
	<?php
		echo $this->Html->script(array('jquery')); 
		echo $this->Html->script(array('bootstrap.min')); //Bootstrap Core JavaScript
		echo $this->Html->script('constant');
		echo $this->Html->script(array('template/angular'));
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