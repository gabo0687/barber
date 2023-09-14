<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
public $uses = array('User');
public $components = array('Encrypt');

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
public function home(){

}

public function account(){
	
}

function login(){

	$this->layout = 'ajax';
	$this->autoRender = false;
		$user = $_POST['loginNumber'];
		$pass = $_POST['loginPass'];
		$pass = $this->Encrypt->encrypt($pass);
		$register = $this->User->find('first', array('conditions' => array('User.phone' => $user,'User.password' => $pass,'User.type' => 3,'User.status' => 1)));		
		if(isset($register['User']['id'])){
			@session_start();
			$_SESSION['User'] = $register;
			echo 1;
		}else{
			echo 0;
		}

}


function logout(){
	$this->autoRender = false;
	$this->Session->destroy();
	$this->redirect(array('action' => '../'));
}

function signup(){
	$this->layout = 'ajax';
	$this->autoRender =false;
	if ($this->request->is('post')) {
		//Initialize
		$nombreUsuario = $_POST['signupName'];
		$celular = $_POST['signupPhone'];
		$genero = $_POST['signupGender'];
		//$userEmail = $_POST['signupEmail'];
		$userContrasena = $_POST['signupPassword1'];
		//Save Product
		$this->User->create();
		$data['User']['name'] = $nombreUsuario;
		$data['User']['phone'] = $celular;
		$data['User']['gender'] = $genero;
		//$data['User']['email'] = trim($userEmail);
		$data['User']['type'] = 3;
		$data['User']['status'] = 1;
		$data['User']['creation_date'] = date('Y-m-d H:i:s');
		if($userContrasena != ''){
			$pass = $this->Encrypt->encrypt($userContrasena);
			$data['User']['password'] = $pass;
		}
		
		if($this->User->save($data)){
			
				$this->redirect(array('action' => '../'));
			}else{
				$this->redirect(array('action' => '../error'));
			}
			
		}
		
	}

	public function getPhone(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$storedPhone = $this->User->find('first',array('conditions'=>array('User.phone'=>$_POST['phone'],'User.status'=>1)));
    	if(empty($storedPhone)){
			echo 0;
		} else {
			echo 1;
		}
	}

}
