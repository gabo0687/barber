<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    function beforeFilter() {
     
        if ((isset($this->params['wpanel'])) && ($this->params['wpanel'])) {
			if ($this->params['controller'] != 'Auth') {
				@session_start();
                //$user = $this->Session->read('User');
				$user = $_SESSION['User'];	
				
                //if (($this->Session->check('User')) && (is_array($this->Session->read('User')))) {
				if( !empty($_SESSION['User']) ){
                    $months = array('','enero','febrero','marzo','abril','mayo','junio','julio','agosto','setiembre','octubre','noviembre','diciembre');
                    $this->set('months',$months);

                    //$userSession = $this->Session->read('User');
					$userSession = $_SESSION['User'];
                    $this->set('userSession',$userSession);

                    $this->layout = 'wpanel';

                    if ($this->params['controller'] != 'Home') {

                        $userHasRights = false;

                        if ($userSession['User']['id'] == 1 ) {
                            $userHasRights = true;
                        }
                   
                        if(!$userHasRights){
                            $menus = $this->Session->read('menus');
                            $roles = $this->Session->read('roles');
                            $param = $this->params['controller'];
                        }
                      
                        if(!$userHasRights){
                            foreach ($menus as $menu) {
                                if($param == $menu['Menu']['controller']){
                                    foreach ($roles as $role) {
                                        if ($role['Role']['id_menu'] == $menu['Menu']['id']) {
                                            $userHasRights = true;
                                            break;
                                        }
                                    }
                                }
                                if(!$userHasRights){
                                    foreach ($menu['Submenu'] as $submenu) {
                                        if($param == $submenu['controller']){
                                            foreach ($roles as $role) {
                                                if ($role['Role']['id_menu'] == $submenu['id_menu']) {
                                                    $userHasRights = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (!$userHasRights) {
                            if (($this->params['controller'] == 'Home')||($this->params['controller'] == 'General')) {
                                $userHasRights = true;
                            } else {
                                $this->Session->setFlash('No posee acceso a esta sección, contacte al administrador del sistema');
                                $this->redirect(array('controller' => 'Home', 'action' => 'index'));
                            }
                        }

                    }
                } else {
                    $this->redirect(array('controller' => 'Auth', 'action' => 'logout'));
                }
            
            }
        }else{
            if ($this->params['controller'] != 'Auth') {
				@session_start();
                //$user = $this->Session->read('User');
				
				
                //if (($this->Session->check('User')) && (is_array($this->Session->read('User')))) {
				if( !empty($_SESSION['User']) ){
                    $user = $_SESSION['User'];	
                    //$userSession = $this->Session->read('User');
					$userSession = $_SESSION['User'];
                    $this->set('userSessionFront',$userSession);
                }
            }
        }
    }
}
