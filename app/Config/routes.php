<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' =>  'home'));
	Router::connect('/loginUser', array('controller' => 'pages', 'action' => 'loginUser'));
	Router::connect('/logout', array('controller' => 'pages', 'action' =>  'logout'));
	Router::connect('/account', array('controller' => 'pages', 'action' =>  'account'));
	Router::connect('/services', array('controller' => 'pages', 'action' =>  'services'));
	Router::connect('/add_service', array('controller' => 'pages', 'action' =>  'add_service'));
	Router::connect('/load_service', array('controller' => 'pages', 'action' =>  'load_service'));
	Router::connect('/edit_service', array('controller' => 'pages', 'action' =>  'edit_service'));
	Router::connect('/saveUser', array('controller' => 'pages', 'action' => 'saveUser'));
	Router::connect('/load_reservations', array('controller' => 'pages', 'action' => 'load_reservations'));
	Router::connect('/save_notification', array('controller' => 'pages', 'action' => 'save_notification'));
	Router::connect('/save_reservation', array('controller' => 'pages', 'action' => 'save_reservation'));
	Router::connect('/calendario', array('controller' => 'pages', 'action' => 'calendar'));
	Router::connect('/home', array('controller' => 'pages', 'action' =>  'home'));
	Router::connect('/save_reservation_calendar', array('controller' => 'pages', 'action' => 'save_reservation_calendar'));
	Router::connect('/load_appointment', array('controller' => 'pages', 'action' => 'load_appointment'));
	Router::connect('/cancel_appointment', array('controller' => 'pages', 'action' => 'cancel_appointment'));
	Router::connect('/confirm_appointment', array('controller' => 'pages', 'action' => 'confirm_appointment'));
	Router::connect('/reservation_events', array('controller' => 'pages', 'action' => 'reservation_events'));
	Router::connect('/events', array('controller' => 'pages', 'action' => 'events'));
	Router::connect('/filter_barber', array('controller' => 'pages', 'action' => 'filter_barber'));
	
	
	Router::connect('/customers', array('controller' => 'pages', 'action' =>  'customers'));
	Router::connect('/add_customer', array('controller' => 'pages', 'action' =>  'add_customer'));
	Router::connect('/load_customer', array('controller' => 'pages', 'action' =>  'load_customer'));
	Router::connect('/edit_customer', array('controller' => 'pages', 'action' =>  'edit_customer'));
	Router::connect('/search_customer', array('controller' => 'pages', 'action' =>  'search_customer'));
	Router::connect('/update_customer', array('controller' => 'pages', 'action' =>  'update_customer'));
	Router::connect('/getPhoneEdit', array('controller' => 'pages', 'action' =>  'getPhoneEdit'));

	
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
