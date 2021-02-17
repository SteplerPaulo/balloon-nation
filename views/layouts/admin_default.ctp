<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Balloon Republic - Admin:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<link href="<?php echo $this->base;?>/img/logo2.png" type="image/x-icon" rel="icon">
	<link href="<?php echo $this->base;?>/img/logo2.png" type="image/x-icon" rel="shortcut icon">
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Paulo Biscocho">
	<meta http-Equiv="Cache-Control" Content="no-cache" />
    <meta http-Equiv="Pragma" Content="no-cache" />
    <meta http-Equiv="Expires" Content="0" />
	<meta property="og:title" content="Balloon Republic Event & Party Needs">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo $this->base;?>/">
	<meta property="og:site_name" content="Balloon Republic">
	<meta property="og:description" content="Balloon Republic Event & Party Needs">
	<meta property="og:image" content="<?php echo $this->base;?>/img/logo.png">


	<?php
		//echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap'); //Bootstrap Core CSS
		echo $this->Html->css('balloonrep-admin'); //Custom CSS
		echo $this->Html->css('template\font-awesome-4.4.0\css\font-awesome'); //Custom Fonts
		//echo $this->Html->css('plugins\morris'); //Custom Fonts
		//echo $this->Html->css('plugins/summernote');
	?>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper" ng-app="App">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Balloon Republic - Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
				<li>
					<?php  echo $this->Html->
									link($this->Html->tag('i', '', array('class' => 'fa fa-home')),
									array('admin' => false,'controller'=>'pages','action'=>'/'),
									array('escape' => false,'class'=>'navbar-brand company-name')
									);  ?>
				</li>
				<li>
					<?php  echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-truck')).' '.
						$this->Html->tag('span', 'Fast Delivery'),
						array('admin' => true,'controller'=>'deliveries','action'=>'create'),
						array('escape' => false));						
					?>
				</li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ucfirst($access->getmy('username'))?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
						 <li >
							<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-user fa-fw')).' '.
										$this->Html->tag('span', 'Profile'),
										array('admin' => true,'controller'=>'users','action'=>'view'),
										array('escape' => false)
										);  ?>
						</li>
						<li>
							<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-gear fa-fw')).' '.
										$this->Html->tag('span', 'Settings'),
										array('admin' => false,'controller'=>'users','action'=>'account_setting'),
										array('escape' => false)
										);  ?>
						</li>
						<li>
							<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-power-off fa-fw')).' '.
									$this->Html->tag('span', 'Logout'),
									array('admin' => false,'controller'=>'users','action'=>'logout'),
									array('escape' => false)
									);  ?>
						</li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav box-shadow">
                    <li class="">
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-dashboard')).' '.
												$this->Html->tag('span', 'Dashboard'),
												array('admin' => true,'controller'=>'users','action'=>'dashboard'),
												array('escape' => false)
												);  ?>
                    </li>
					<li class="">
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-file-zip-o')).' '.
												$this->Html->tag('span', 'Sales Report'),
												array('admin' => true,'controller'=>'sales','action'=>'customer'),
												array('escape' => false)
												);  ?>
                    </li>
					<li class="">
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-file-excel-o')).' '.
												$this->Html->tag('span', 'S. Journal Entry'),
												array('admin' => true,'controller'=>'sales','action'=>'journal_entry'),
												array('escape' => false)
												);  ?>
                    </li>
					<li class="">
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-truck')).' '.
												$this->Html->tag('span', 'Deliveries'),
												array('admin' => true,'controller'=>'deliveries','action'=>'/'),
												array('escape' => false)
												);  ?>
                    </li>
					
					 <li>		
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-cubes')).' '.
												$this->Html->tag('span', 'Products'),
												array('admin' => true,'controller'=>'products','action'=>'/'),
												array('escape' => false)
												);  ?>
					</li>
					<li>		
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-tags')).' '.
												$this->Html->tag('span', 'Categories'),
												array('admin' => true,'controller'=>'categories','action'=>'/'),
												array('escape' => false)
												);  ?>
					</li>
					<li>		
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-user-plus')).' '.
												$this->Html->tag('span', 'Customers'),
												array('admin' => true,'controller'=>'customers','action'=>'/'),
												array('escape' => false)
												);  ?>
					</li>
					<li>		
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-newspaper-o')).' '.
												$this->Html->tag('span', 'Banners'),
												array('admin' => true,'controller'=>'banners','action'=>'/'),
												array('escape' => false)
												);  ?>
					</li>
					<li>
						<?php  echo $this->Html->link($this->Html->tag('i', '', array('class' =>'fa fa-question-circle')).'  &nbsp;'.
												$this->Html->tag('span', 'Inquiries'),
												array('admin' => true,'controller'=>'inquiries','action'=>'/'),
												array('escape' => false));						
						?>
					</li>
					<li>		
						<?php echo $this->Html->link( 	$this->Html->tag('i', '', array('class' => 'fa fa-fw fa-users')).' '.
												$this->Html->tag('span', 'Users'),
												array('admin' => true,'controller'=>'users','action'=>'/'),
												array('escape' => false)
												);  ?>
					</li>		
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <div id="page-wrapper" style="min-height: 620px;">
            <div class="container-fluid">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->Session->flash('email'); ?>
				<div class="breadcrumb"><?php echo $this->Html->getCrumbs(' <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> ','Home Page'); ?></div>
				<?php echo $content_for_layout; ?>
            </div>
        </div>
    </div>


	<?php
		echo $this->Html->script(array('jquery')); 
		echo $this->Html->script(array('bootstrap.min')); //Bootstrap Core JavaScript
		echo $this->Html->script('constant');
		echo $this->Html->script(array('template/angular.min'));// Angular v1.5.9 (Dependencies for bootstrap modal)
		echo $this->Html->script(array('template/angular-sanitize'));
		echo $this->Html->script(array('angularUtils/directives/dirPagination'));
		echo $this->Html->script(array('angularUtils/directives/ui-bootstrap-tpls-2.3.0.min'));
		echo $this->Html->script(array('bower_components/x2js/xml2json'));
		echo $this->Html->script(array('bower_components/angular-x2js/src/x2js'));
		//echo $this->Html->script('plugins/summernote');
	?>
	<script type="text/javascript">(function(){window.App = angular.module('App',['cb.x2js','angularUtils.directives.dirPagination','ngSanitize','ui.bootstrap'])})();</script>
	<script>
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<?php  echo $scripts_for_layout; ?>


</body>

</html>
