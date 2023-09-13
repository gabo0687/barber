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
	public $uses = array('Service','Duration');

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
public function home(){
	session_start();
	$user = '';
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
	}
	$this->set('user',$user);
}

public function account(){
	session_start();
	$user = '';
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
	}
	$this->set('user',$user);
}
public function services(){
	session_start();
	$user = '';
	$services = $this->Service->find('all');
	$this->set('services',$services);
	$barbers = array(
		
		array('id'=>1,'nombre'=>'Berman'),
		array('id'=>2,'nombre'=>'Joss'),
		array('id'=>3,'nombre'=>'Dey')
		
	);
	
	$this->set('barbers',$barbers);
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
	}
	$this->set('user',$user);
}
public function login(){
	$this->autoRender = false;
	$this->layout = 'ajax';
	session_start();
    $_SESSION['user'] = $_POST['user'];
	$this->redirect(array('action' => '../'));
}
public function logout(){
	session_start();
	$_SESSION['user'] = '';
	$this->redirect(array('action' => '../'));
}

public function add_service(){
	$this->layout = 'ajax';
	if ($this->request->is('post')) {
		$this->Service->create();
		$data['Service']['service_name'] = $_POST['nombre'];
		$data['Service']['price'] = $_POST['precio'];
		$data['Service']['gender'] = $_POST['tiposervicio'];
		$data['Service']['date_creation'] = date('Y-m-d');
		if($this->Service->save($data)){
		$serviceId = $this->Service->getLastInsertID();
		$cantidadBarbers = $_POST['cantidadBarbers'];
		for($i=0; $i < $cantidadBarbers;$i++ ){
			$this->Duration->create();
			$data['Duration']['duration'] = $_POST['duracion'.$i];
			$data['Duration']['barber'] = $_POST['duracionId'.$i];
			$data['Duration']['service_id'] = $serviceId;
			$this->Duration->save($data);
		}
		

		$this->redirect(array('action' => '../services'));
		}
	}
}

public function load_service(){
	$this->autoRender = false;
	$this->layout = 'ajax';
	$idServicio = $_POST['idServicio'];

	$servicio = $this->Service->find('all',array(
	'fields' => array('Duration.id','Duration.duration','Duration.barber','Duration.service_id','Service.id','Service.service_name','Service.price','Service.gender'),
	'conditions'=>array('Service.id'=>$idServicio),
	'joins' =>
		array(
			array(
				'table' => 'durations',
				'alias' => 'Duration',
				'type' => 'inner',
				'foreignKey' => false,
				'conditions'=> array('Duration.service_id = Service.id')
			)          
			),
	'recursive' => 2	
	));

	echo json_encode($servicio);
}

public function edit_service(){
	$this->layout = 'ajax';
	if ($this->request->is('post')) {
		$this->Service->id = $_POST['id_edit'];
		$data['Service']['service_name'] = $_POST['nombre_edit'];
		$data['Service']['price'] = $_POST['precio_edit'];
		$data['Service']['gender'] = $_POST['tiposervicio_edit'];
		if($this->Service->save($data)){
		//$serviceId = $this->Service->getLastInsertID();
		$serviceId = $_POST['id_edit'];
		$cantidadBarbers = $_POST['cantidadBarbers'];
		$this->Duration->query('delete from durations where service_id='.$serviceId);
		$barbers = array(
		
			array('id'=>1,'nombre'=>'Berman'),
			array('id'=>2,'nombre'=>'Joss'),
			array('id'=>3,'nombre'=>'Dey')
			
		);
		foreach( $barbers as $barber ){
			$this->Duration->create();
			$data['Duration']['duration'] = $_POST['duracion_edit'.$barber['id']];
			$data['Duration']['barber'] = $_POST['duracionId_edit'.$barber['id']];
			$data['Duration']['service_id'] = $serviceId;
			$this->Duration->save($data);
		}
		

		$this->redirect(array('action' => '../services'));
		}
	}
}

}
