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

    public $uses = array('Service','Duration','User');

    function beforeFilter() {
     
            @session_start();
            //$user = $this->Session->read('User');
            
            
            //if (($this->Session->check('User')) && (is_array($this->Session->read('User')))) {
            if( !empty($_SESSION['User']) ){
                $user = $_SESSION['User'];	
                //$userSession = $this->Session->read('User');
                $userSession = $_SESSION['User'];
                $this->set('userSessionFront',$userSession);
                $services = $this->Service->find('all');
                $this->set('services',$services);
                $users = $this->User->find('all',array('conditions'=>array(
                                            'OR'=> array(
                                                        array('User.type'=>1),
                                                        array('User.type'=>2)
                                                        )
                                                    )
                                                )
                                            );
                $this->set('users',$users);
                $clients = array();
                $clients = $this->User->find('all',array('conditions'=>array('User.type'=>3)));
                $this->set('clients',$clients);
            }
            
        }
    }

