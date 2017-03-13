<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	
	
	//Pages
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/about-us', array('controller' => 'pages', 'action' => 'display','about-us'));
	Router::connect('/contacts', array('controller' => 'pages', 'action' => 'display','contacts'));
	
	//Admin Dashboard
	Router::connect('/admin', array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
	
	//Products
	Router::connect('/product/:slug', array('controller' => 'products', 'action' => 'view'), array('pass' => array('slug')));//PER ITEM
	Router::connect('/product-category/:slug', array('controller' => 'products', 'action' => 'index'), array('pass' => array('slug')));//FILTER BY CATEGORY
	
	//Admin Product Images
	Router::connect('/admin/product/:slug/images', array('controller' => 'product_images', 'action' => 'index', 'admin' => true), array('pass' => array('slug')));//index
	Router::connect('/admin/product/:slug/add/photo', array('controller' => 'product_images', 'action' => 'add', 'admin' => true), array('pass' => array('slug')));//add
	//Router::connect('/admin/product/:slug/image/edit/:id', array('controller' => 'product_images', 'action' => 'edit', 'admin' => true), array('pass' => array('id')));//edit

	
	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
 
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
