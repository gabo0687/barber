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
class PagesController extends AppController
{

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array('Service', 'Duration', 'User', 'Reservation', 'Notification', 'Customer', 'Remove', 'Activereservation', 'Workhour', 'Product', 'Sale', 'Saleproduct', 'Expense', 'Role', 'Sendpassword');
	public $components = array('Encrypt');
	/**
	 * Displays a view
	 *
	 * @return CakeResponse|null
	 * @throws ForbiddenException When a directory traversal attempt.
	 * @throws NotFoundException When the view file could not be found
	 *   or MissingViewException in debug mode.
	 */

	function beforeFilter()
	{
		parent::beforeFilter();
	}

	
	

	public function home(){


		if ($this->request->is('post')) {
			
			$reservaId = $_POST['idReservation'];
			$dataBill = array();
			$this->Reservation->id = $reservaId;
			if ( $_FILES['comprobante'.$reservaId]['name'] != "" ){
				$pathImage = WWW_ROOT . 'bills' . DIRECTORY_SEPARATOR ;
				$imageName = $reservaId.'_'.$_FILES['comprobante'.$reservaId]['name'];
				if (move_uploaded_file($_FILES['comprobante'.$reservaId]['tmp_name'], $pathImage . $imageName)) {
					$dataBill['Reservation']['reservation_bill'] = $_FILES['comprobante'.$reservaId]['name'];
				}
			}
			
			
			$dataBill['Reservation']['payment_type'] = $_POST['tipoPago'.$reservaId];
			$this->Reservation->save($dataBill);
		}
	
		$user = array();
		$reservations = array();
		$reservationResponse=array();
		if(isset($_SESSION['User'])){
			$conditions = array();
			$user = $_SESSION['User'];
			if( $user['User']['type'] == 3 ){
				$conditions['Reservation.reservation_user'] = $user['User']['id'];
				$conditions['Reservation.reservation_status <>'] = 2;
			}else{
				if( $user['User']['type'] == 2 ){
					$conditions['Reservation.reservation_barber'] = $user['User']['id'];
				}		
			}
			$conditions['Reservation.reservation_date >='] = date('Y-m-d');
			
			$reservations = $this->Reservation->find('all',array('fields'=>
																		array('Reservation.id','Reservation.reservation_bill','Reservation.reservation_service','Reservation.reservation_price','Reservation.payment_type','Reservation.reservation_status','Reservation.reservation_date','Reservation.reservation_time',
																			  'Barber.id','Barber.name','Barber.color',
																			  'User.id','User.name','User.phone',
																			  ),
																 'conditions'=>
																		array($conditions),
																 'joins' =>
																 array(
																	 array(
																		'table' => 'users',
																		'alias' => 'Barber',
																		'type' => 'inner',
																		'foreignKey' => false,
																		'conditions'=> array('Barber.id = Reservation.reservation_barber')
																	),
																	array(
																	   'table' => 'users',
																	   'alias' => 'User',
																	   'type' => 'inner',
																	   'foreignKey' => false,
																	   'conditions'=> array('User.id = Reservation.reservation_user')
																   )          
																	),
																 'order'=>array('Reservation.reservation_date'=>'ASC','Reservation.reservation_time'=>'ASC')
																));
		foreach( $reservations as $reservation ){
			$servicesIds = explode(',',$reservation['Reservation']['reservation_service']);
			$timeDurations = $this->Duration->find('all',array('fields'=>array('Duration.duration'),'conditions'=>array('Duration.barber'=>$reservation['Barber']['id'],'Duration.service_id'=>$servicesIds)));
			$duration = 0;
			foreach( $timeDurations as $timeDuration ){
				$duration = $duration + $timeDuration['Duration']['duration'];
			}
			array_push($reservation,$duration);
			$serviceNames = $this->Service->find('all',array('fields'=>array('Service.service_name'),'conditions'=>array('Service.id'=>$servicesIds)));
			$nameService = '';
			foreach( $serviceNames as $serviceName ){
				$nameService .= $serviceName['Service']['service_name'].'/';
			}

			array_push($reservation, $nameService);

			array_push($reservationResponse,$reservation);
		}
	
		}
		
		
		$this->set('reservations',$reservationResponse);
		//$this->set('user',$user);
		
	
	}

	public function account()
	{

		$this->checksession(1);
		if ($this->request->is('post')) {

			$blockDate = $_POST['date_block'];
			if ($_POST['date_block'] == '') {
				$blockDate = date('Y-m-d');
			}
			$this->Block->create();
			$data['Block']['barber_id'] = $_POST['barber_block'];
			$data['Block']['block_date'] = $blockDate;
			$data['Block']['block_schedule'] = $_POST['schedule_block'];
			$data['Block']['creation_date'] = date('Y-m-d');
			$this->Block->save($data);
		}

		$barbers = $this->User->find(
			'all',
			array(
				'conditions' => array(
					'OR' => array(
						array('User.type' => 1),
						array('User.type' => 2)
					)
				)
			)
		);
		$this->set('barbers', $barbers);



		$user = $_SESSION['User'];
		
		$currentUser = $this->User->find('first',array('conditions'=>array('User.id'=>$user['User']['id'])));

		$this->set('currentUser', $currentUser);
		$this->set('type', $user['User']['type']);
		
		$current_date = date('Y-m-d');
		$blockReservations = $this->Block->find('all', array('conditions' => array('Block.block_date >= ' => $current_date)));
		$blockResult = array();
		$blocks = array();

		foreach ($blockReservations as $blockReservation) {

			foreach ($barbers as $barber) {

				$date = $blockReservation['Block']['block_date'];
				$day  = date('w', strtotime($date));
				$days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
				$year = date('Y', strtotime($date));
				$month = date('m', strtotime($date));
				$months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
				$currentDay = date('d', strtotime($date));
				$dayOfTheWeek = $days[$day];
				$dayFormat = $dayOfTheWeek . ' ' . $currentDay . ' de ' . $months[(int)$month - 1] . ' del ' . $year;
				$schedules = ['Todo el día', 'Mañana', 'Tarde', 'Noche'];
				$schedule = $schedules[$blockReservation['Block']['block_schedule']];
				if ($blockReservation['Block']['barber_id'] == $barber['User']['id']) {
					$blocks = array('id' => $blockReservation['Block']['id'], 'BarberoId' => $barber["User"]["id"], 'Barbero' => $barber["User"]["name"], 'schedule' => $schedule, 'blockDate' => $dayFormat);
					break;
				} else {
					if ($blockReservation['Block']['barber_id'] == 0) {
						$blocks = array('id' => $blockReservation['Block']['id'], 'BarberoId' => 0, 'Barbero' => 'Barberia', 'schedule' => $schedule, 'blockDate' => $dayFormat);
						break;
					}
				}
			}

			array_push($blockResult, $blocks);
		}

		$this->set('blockReservations', $blockResult);
	}
	public function services()
	{
		$this->checksession(3);
		$user = '';
		$services = $this->Service->find('all');
		$this->set('services', $services);
		$barbers = $this->User->find(
			'all',
			array(
				'conditions' => array(
					'OR' => array(
						array('User.type' => 1),
						array('User.type' => 2)
					)
				)
			)
		);

		$this->set('barbers', $barbers);
	}
	public function loginUser()
	{

		$this->layout = 'ajax';
		$this->autoRender = false;
		$user = $_POST['loginNumber'];
		$pass = $_POST['loginPass'];
		$pass = $this->Encrypt->encrypt($pass);

		

		$register = $this->User->find('first', array('conditions' => array('User.phone' => $user, 'User.password' => $pass, 'User.status' => 1)));
		
		if (isset($register['User']['id'])) {
			$roles = $this->Role->find('all',array('conditions'=>array('Role.id_user'=>$register['User']['id'])));
			$_SESSION['User'] = $register;
			$_SESSION['Role'] = $roles;
			echo 1;
		} else {
			echo 0;
		}
			
	}


	public function logout()
	{
		$this->autoRender = false;
		$this->Session->destroy();
		$this->redirect(array('action' => '../'));
	}

	public function add_service()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Service->create();
			$data['Service']['service_name'] = $_POST['nombre'];
			$data['Service']['price'] = $_POST['precio'];
			$data['Service']['gender'] = $_POST['tiposervicio'];
			$data['Service']['date_creation'] = date('Y-m-d');
			if ($this->Service->save($data)) {
				$serviceId = $this->Service->getLastInsertID();
				$cantidadBarbers = $_POST['cantidadBarbers'];
				for ($i = 0; $i < $cantidadBarbers; $i++) {
					$this->Duration->create();
					$data['Duration']['duration'] = $_POST['duracion' . $i];
					$data['Duration']['barber'] = $_POST['duracionId' . $i];
					$data['Duration']['service_id'] = $serviceId;
					$this->Duration->save($data);
				}


				$this->redirect(array('action' => '../services'));
			}
		}
	}

	public function load_service()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$idServicio = $_POST['idServicio'];

		$servicio = $this->Service->find('all', array(
			'fields' => array('Duration.id', 'Duration.duration', 'Duration.barber', 'Duration.service_id', 'Service.id', 'Service.service_name', 'Service.price', 'Service.gender'),
			'conditions' => array('Service.id' => $idServicio),
			'joins' =>
			array(
				array(
					'table' => 'durations',
					'alias' => 'Duration',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Duration.service_id = Service.id')
				)
			),
			'recursive' => 2
		));
		$servicio = mb_convert_encoding($servicio, 'UTF-8', 'UTF-8');
		echo json_encode($servicio);
	}

	public function edit_service()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {

			$this->Service->id = $_POST['id_edit'];
			$data['Service']['service_name'] = $_POST['nombre_edit'];
			$data['Service']['price'] = $_POST['precio_edit'];
			$data['Service']['gender'] = $_POST['tiposervicio_edit'];
			if ($this->Service->save($data)) {
				//$serviceId = $this->Service->getLastInsertID();
				$serviceId = $_POST['id_edit'];
				$cantidadBarbers = $_POST['cantidadBarbers'];
				$this->Duration->query('delete from durations where service_id=' . $serviceId);
				$barbers = $this->User->find(
					'all',
					array(
						'fields' => array('User.id'),
						'conditions' => array(
							'OR' => array(
								array('User.type' => 1),
								array('User.type' => 2)
							)
						)
					)
				);
				foreach ($barbers as $barber) {

					$this->Duration->create();
					$data['Duration']['duration'] = $_POST['duracion_edit' . $barber['User']['id']];
					$data['Duration']['barber'] = $_POST['duracionId_edit' . $barber['User']['id']];
					$data['Duration']['service_id'] = $serviceId;
					$this->Duration->save($data);
				}


				$this->redirect(array('action' => '../services'));
			}
		}
	}

	function saveUser()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		if ($this->request->is('post')) {
			//Initialize
			$nombreUsuario = $_POST['signupName'];
			$celular = $_POST['signupPhone'];
			//$userEmail = $_POST['signupEmail'];
			$userContrasena = $_POST['signupPassword1'];
			//Save user
			$this->User->create();
			$data['User']['name'] = $nombreUsuario;
			$data['User']['phone'] = $celular;
			//$data['User']['email'] = trim($userEmail);
			$data['User']['type'] = 3;
			$data['User']['status'] = 1;
			$data['User']['creation_date'] = date('Y-m-d H:i:s');
			if ($userContrasena != '') {
				$pass = $this->Encrypt->encrypt($userContrasena);
				$data['User']['password'] = $pass;
			}

			if ($this->User->save($data)) {
				sleep(10);
				$this->redirect(array('action' => '../'));
			} else {
				$this->redirect(array('action' => '../error'));
			}
		}
	}

	public function getPhone()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$storedPhone = $this->User->find('first', array('conditions' => array('User.phone' => $_POST['phone'], 'User.status' => 1)));
		if (empty($storedPhone)) {
			echo 0;
		} else {
			echo 1;
		}
	}

	public function getPhoneEdit()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$storedPhone = $this->User->find('first', array('conditions' => array('User.phone' => $_POST['phone'], 'User.id !=' => $_POST['user_id'])));
		if (empty($storedPhone)) {
			echo 0;
		} else {
			echo 1;
		}
	}

	public function getColorEdit()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$storedCol = $this->User->find('first', array('conditions' => array('User.color' => $_POST['color'], 'User.id !=' => $_POST['user_id'])));
		if (empty($storedCol)) {
			echo 0;
		} else {
			echo 1;
		}
	}

	public function getColor()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$storedColor = $this->User->find('first', array('conditions' => array('User.color' => $_POST['color'])));
		if (empty($storedColor)) {
			echo 0;
		} else {
			echo 1;
		}
	}


	public function load_reservations()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if ($_POST['reservationDate'] == '') {
			$reservationDate = date('Y-m-d');
		} else {
			$reservationDate = $_POST['reservationDate'];
		}
		$reservationServices = $_POST['reservationServices'];
		$reservationBarber	 = $_POST['reservationBarber'];


		$reservationTime 	 = $_POST['reservationTime'];



		$reservations = $this->Reservation->find('all', array(
			'conditions' => array(
				'Reservation.reservation_date' => $reservationDate,
				'Reservation.reservation_status <>' => 2
			),
			'order' => array('Reservation.reservation_time' => 'ASC')
		));

		$reservationsAvailable = $this->load_reservation_available($reservations, $reservationServices, $reservationBarber, $reservationTime, $reservationDate);
		$reservationsAvailable = mb_convert_encoding($reservationsAvailable, 'UTF-8', 'UTF-8');
		echo json_encode($reservationsAvailable);
	}

	public function checkBlockBarber($reservationDate, $timeList, $barberResponse)
	{

		$blocks = $this->Block->find('all', array('conditions' => array('Block.block_date' => $reservationDate, 'Block.barber_id' => $barberResponse['User']['id'], 'Block.barber_id <>' => 0)));
		$blockReservations = '';
		$hour = explode(':', $timeList);
		if ($hour[0] < 10) {
			$timeList = '0' . $timeList;
		}
		$current_time = $timeList;

		foreach ($blocks as $block) {
			switch ($block['Block']['block_schedule']) {
				case 0:
					/**
					 * Block Barber Shop all day
					 */
					$blockReservations = 0;
					break;
				case 1:
					/**
					 * Block Barber Shop morning
					 */
					if ($current_time <= '11:59:59') {
						$blockReservations = 1;
					}
					break;
				case 2:
					/**
					 * Block Barber Shop afternoon
					 */
					if ($current_time > '11:59:59' && $current_time <= '17:59:59') {
						$blockReservations = 2;
					}
					break;
				case 3:
					/**
					 * Block Barber Shop night
					 */
					if ($current_time > '17:59:59' && $current_time <= '23:59:59') {
						$blockReservations = 3;
					}
					break;
			}
		}
		return $blockReservations;
	}

	public function checkBlockDayPass($reservationDate, $reservationTime)
	{
		$blockReservations = '';
		$current_date = date('Y-m-d');
		if ($reservationDate == $current_date) {
			$hour = explode(':', $reservationTime);
			if ($hour[0] < 10) {
				$reservationTime = '0' . $reservationTime;
			}

			$current_time = date('H:i:s');

			$blockReservations = '';

			if ($reservationTime < $current_time) {
				$blockReservations = 1;
			}
		}

		return $blockReservations;
	}

	public function checkBlockAllDay($reservationDate, $reservationTime)
	{
		$blockReservations = '';
		$hour = explode(':', $reservationTime);
		if ($hour[0] < 10) {
			$reservationTime = '0' . $reservationTime;
		}
		$current_time = $reservationTime;

		$blockReservations = '';
		$blocks = $this->Block->find('all', array('conditions' => array('Block.block_date' => $reservationDate, 'Block.barber_id' => 0)));
		foreach ($blocks as $block) {

			switch ($block['Block']['block_schedule']) {
				case 0:
					/**
					 * Block Barber Shop all day
					 */
					$blockReservations = 0;
					break;
				case 1:
					/**
					 * Block Barber Shop morning
					 */
					if ($current_time <= '11:59:59') {
						$blockReservations = 1;
					}
					break;
				case 2:
					/**
					 * Block Barber Shop afternoon
					 */
					if ($current_time > '11:59:59' && $current_time <= '17:59:59') {
						$blockReservations = 2;
					}
					break;
				case 3:
					/**
					 * Block Barber Shop night
					 */
					if ($current_time > '17:59:59' && $current_time <= '23:59:59') {
						$blockReservations = 3;
					}
					break;
			}
		}


		return $blockReservations;
	}

	public function load_reservation_available($reservations, $reservationService, $filterBarber, $reservationTime, $reservationDate)
	{

		$timeLists = $this->time_open();
		$reservationsResponse = array();

		foreach ($timeLists as $timeList) {

			$reservationAvailable = array();

			if ($reservationTime != 0) {
				if (strtotime($timeList) >= strtotime($reservationTime)) {
					$reservationAvailable = $this->reservationsFilter($timeList, $reservations, $reservationService, $filterBarber, $reservationTime, $reservationDate);
				}
			} else {
				$reservationAvailable = $this->reservationsFilter($timeList, $reservations, $reservationService, $filterBarber, $reservationTime, $reservationDate);
			}
			if (!empty($reservationAvailable)) {
				array_push($reservationsResponse, $reservationAvailable);
			}
		}
		return $reservationsResponse;
	}

	public function reservationsFilter($timeList, $reservations, $reservationService, $filterBarber, $reservationTime, $reservationDate)
	{

		$barbers = $this->load_barbers();
		$service = $this->load_service_reservation($reservationService,$filterBarber);
		$reservationAvailable = array();
		$reservationsResponse = array();
		$reservationBarbers = array();
		$timeCompare = strtotime($timeList);
		foreach ($reservations as $reservation) {
			$timeReservation = strtotime($reservation['Reservation']['reservation_time']);
			$barberReservation = $reservation['Reservation']['reservation_barber'];
			if ($timeReservation == $timeCompare) {
				foreach ($barbers as $barber) {
					if ($barberReservation == $barber['User']['id']) {
						array_push($reservationBarbers, $barber);
					}
				}
			}
		}
		$reservationBarberResponse = array();
		if (!empty($reservationBarbers)) {
			if ($filterBarber != 0) {
				foreach ($barbers as $barberResponse) {
					$barberExist = false;
					foreach ($reservationBarbers as $barberReservation) {
						if ($barberResponse['User']['id'] == $barberReservation['User']['id']) {
							$barberExist = true;
						}
					}
					if ($barberExist == false && $filterBarber == $barberResponse['User']['id']) {
						/**
						 * Validar si el babero da el servicio o no
						 */
						$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
						if ($validateBarberService) {
							$blockBarber = $this->checkBlockBarber($reservationDate, $timeList, $barberResponse);
							if ($blockBarber == '') {
								array_push($reservationBarberResponse, $barberResponse);
							}
						}
					}
				}
			} else {

				foreach ($barbers as $barberResponse) {
					$barberExist = false;
					foreach ($reservationBarbers as $barberReservation) {
						if ($barberResponse['User']['id'] == $barberReservation['User']['id']) {
							$barberExist = true;
						}
					}
					if ($barberExist == false) {
						$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
						if ($validateBarberService) {
							$blockBarber = $this->checkBlockBarber($reservationDate, $timeList, $barberResponse);
							if ($blockBarber == '') {
								array_push($reservationBarberResponse, $barberResponse);
							}
						}
					}
				}
			}
			if ($reservationDate == '') {
				$reservationDate = date('Y-m-d');
			}

			$blockAllDay = $this->checkBlockAllDay($reservationDate, $timeList);
			$checkDayPass = $this->checkBlockDayPass($reservationDate, $timeList);
			$checkTimeOpen = $this->checkOpenClose($reservationDate, $timeList);
			if ($blockAllDay == '' && $checkDayPass == '' && $checkTimeOpen == '') {
				
				$reservationAvailable = array(
					'Time' => $timeList, 'Service' => $service['ServiceName'], 'ServiceId' => $service['ServiceId'], 'Duration' => $service['Duration'], 'Price' => $service['ServicePrice'],
					'Barbers' => $reservationBarberResponse
				);
			}
		} else {
			if ($filterBarber != 0) {
				foreach ($barbers as $barberResponse) {
					if ($filterBarber == $barberResponse['User']['id']) {
						$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
						if ($validateBarberService) {
							$blockBarber = $this->checkBlockBarber($reservationDate, $timeList, $barberResponse);
							if ($blockBarber == '') {
								array_push($reservationBarberResponse, $barberResponse);
							}
						}
					}
				}
				if ($reservationDate == '') {
					$reservationDate = date('Y-m-d');
				}
				$blockAllDay = $this->checkBlockAllDay($reservationDate, $timeList);
				$checkDayPass = $this->checkBlockDayPass($reservationDate, $timeList);
				$checkTimeOpen = $this->checkOpenClose($reservationDate, $timeList);
				if ($blockAllDay == '' && $checkDayPass == '' && $checkTimeOpen == '') {
					$reservationAvailable = array(
						'Time' => $timeList, 'Service' => $service['ServiceName'], 'ServiceId' => $service['ServiceId'], 'Duration' => $service['Duration'], 'Price' => $service['ServicePrice'],
						'Barbers' => $reservationBarberResponse
					);
				}
			} else {
				foreach ($barbers as $barberResponse) {
					$validateBarberService = $this->validateBarberService($reservationService, $barberResponse['User']['id']);
					if ($validateBarberService) {
						$blockBarber = $this->checkBlockBarber($reservationDate, $timeList, $barberResponse);
						if ($blockBarber == '') {
							array_push($reservationBarberResponse, $barberResponse);
						}
					}
				}
				if ($reservationDate == '') {
					$reservationDate = date('Y-m-d');
				}
				$blockAllDay = $this->checkBlockAllDay($reservationDate, $timeList);
				$checkDayPass = $this->checkBlockDayPass($reservationDate, $timeList);
				$checkTimeOpen = $this->checkOpenClose($reservationDate, $timeList);
				if ($blockAllDay == '' && $checkDayPass == '' && $checkTimeOpen == '') {
					$reservationAvailable = array(
						'Time' => $timeList, 'Service' => $service['ServiceName'], 'ServiceId' => $service['ServiceId'], 'Duration' => $service['Duration'], 'Price' => $service['ServicePrice'],
						'Barbers' => $reservationBarberResponse
					);
				}
			}
		}
		return $reservationAvailable;
	}

	public function validateBarberService($service, $barber)
	{
		$service = explode(',',$service);
		$validateServices = $this->Duration->find('all', array('conditions' => array('Duration.service_id' => $service, 'Duration.barber' => $barber),
		'recursive' => 2));
		foreach( $validateServices as $validateService ){
			if ($validateService['Duration']['duration'] == '' || $validateService['Duration']['duration'] == '0') {
				return false;
			}
		}
		
		return true;
	}

	public function checkOpenClose($reservationDate, $timeList)
	{
		$dayofweek = date('w', strtotime($reservationDate));
		if ($dayofweek == 0) {
			$dayofweek = 7;
		}
		$work_hours = $this->Workhour->find('first', array('conditions' => array('Workhour.work_day' => $dayofweek)));
		$resultado = '';


		if (strtotime($work_hours['Workhour']['work_open']) > strtotime($timeList)) {
			$resultado = 'no';
		} else {
			if (strtotime($timeList) >= strtotime($work_hours['Workhour']['work_close'])) {
				$resultado = 'no';
			}
		}


		return $resultado;
	}

	public function time_open()
	{
		$time_return = array();
		$time_hour = 7;
		$time_minute = '00';
		for ($i = 0; $i <= 30; $i++) {
			if ($time_minute != 60) {
				array_push($time_return, $time_hour . ':' . $time_minute);
			}
			if ($time_minute == 30) {
				$time_minute = '00';
				$time_hour = $time_hour + 1;
			} else {
				if ($time_minute == 60) {
					$time_minute = '00';
					$time_hour = $time_hour + 1;
				} else {
					if ($time_minute == 00 || $time_minute == 30) {
						$time_minute = $time_minute + 30;
					}
				}
			}
		}
		return $time_return;
	}

	public function load_barbers()
	{
		$users = $this->User->find(
			'all',
			array(
				'fields' => array('User.id', 'User.name'),
				'conditions' => array(
					'OR' => array(
						array('User.type' => 1),
						array('User.type' => 2)
					)
				)
			)
		);
		return $users;
	}

	public function load_service_reservation($idServicio,$filterBarber)
	{
		$idServicio = explode(',',$idServicio);
		$services = $this->Service->find('all', array(
			'fields' => array( 'Service.id', 'Service.service_name', 'Service.price', 'Service.gender'),
			'conditions' => array('Service.id ' => $idServicio),
			'recursive' => 2
		));
		$conditions = array();
		if( $filterBarber != 0 ){
			$conditions['Duration.barber'] = $filterBarber;
		}
		
		$durations = $this->Duration->find('all',array(
							'fields'=>array('Duration.id', 'Duration.duration', 'Duration.barber', 'Duration.service_id'),
							'conditions'=>array('Duration.service_id'=>$idServicio,'Duration.duration <>'=>0,$conditions)
							));
		$durationResponse = array();
		foreach( $durations as $duration ){
			$durationArray = array(
				'Id' => $duration['Duration']['id'], 'Duration' => $duration['Duration']['duration'], 'Barber' => $duration['Duration']['barber'],
				'Service' => $duration['Duration']['service_id']
			);
			array_push($durationResponse, $durationArray);
		}
		$durationUniques = $this->unique_multidim_array($durationResponse,'Service');
		
			
		$resultServicios = array();
		$price = 0;
		$serviceName = '';
		foreach( $services as $service){
			$price = $price + $service['Service']['price'];
			$serviceName .= $service['Service']['service_name'].' / ';
		}
		$durationTime = 0;
		foreach( $durationUniques as $durationUnique ){
			$durationTime = $durationTime + $durationUnique["Duration"]; 
		}

		$arrayServiceDuration = array(
			'ServiceId'=>$idServicio,'ServiceName'=>$serviceName,'ServicePrice'=>$price,'Duration'=>$durationTime
		);
		
		return $arrayServiceDuration;
	}


	public function unique_multidim_array($array, $key) {

		$temp_array = array();
	
		$i = 0;
	
		$key_array = array();
	
		
	
		foreach($array as $val) {
	
			if (!in_array($val[$key], $key_array)) {
	
				$key_array[$i] = $val[$key];
	
				$temp_array[$i] = $val;
	
			}
	
			$i++;
	
		}
	
		return $temp_array;
	
	}
	public function save_notification()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Notification->create();
		if ($_POST['reservationDate'] == '') {
			$reservationDate = date('Y-m-d');
		} else {
			$reservationDate = $_POST['reservationDate'];
		}
		$data['Notification']['reservation_date'] = $reservationDate;
		$data['Notification']['reservation_time'] = $_POST['reservationFilterTime'];
		if( $_POST['clientCurrent'] == '' ){
			$data['Notification']['user_id'] = $_SESSION['User']['User']['id'];
		}else{
			$data['Notification']['user_id'] = $_POST['clientCurrent'];
		}
		$data['Notification']['notification_type'] = 2;
		$data['Notification']['date_creation'] = date('Y-m-d H:i:s');
		if ($this->Notification->save($data)) {
			Cache::clear();
			echo 1;
		} else {
			echo 0;
		}
	}

	public function save_reservation()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		if ($_POST['reservation_date'] == '') {
			$reservationDate = date('Y-m-d');
		} else {
			$reservationDate = $_POST['reservation_date'];
		}
		if ($_POST['client'] != 0) {
			$client = explode('-', $_POST['client']);
			$reservationUser = $client[0];
		} else {
			$reservationUser = $_SESSION['User']['User']['id'];
		}
		/**
		 * Validar no más de 2 reservaciones activas
		 */
		$validateReservation = $this->validateReservations($reservationUser);
		/**
		 * Validar si alguien más tomó la cita
		 */
		$reservationTaken = $this->reservationTaken($_POST['reservation_barber'], $_POST['reservation_time'], $reservationDate);
		if ($validateReservation && $reservationTaken) {

			$this->Reservation->create();
			$data['Reservation']['reservation_date'] = $reservationDate;
			$data['Reservation']['reservation_time'] = $_POST['reservation_time'];
			$data['Reservation']['reservation_user'] = $reservationUser;
			$data['Reservation']['reservation_service'] = $_POST['reservation_service'];
			$data['Reservation']['reservation_barber'] = $_POST['reservation_barber'];
			$data['Reservation']['reservation_price'] = $_POST['reservationPrice'];
			$data['Reservation']['creation_date'] = date('Y-m-d H:i:s');
			if ($this->Reservation->save($data)) {
				$lastReservationId = $this->Reservation->getLastInsertID();
				$this->Activereservation->create();
				$data['Activereservation']['id_reservation'] = $lastReservationId;
				$data['Activereservation']['reservation_date'] = $reservationDate;
				$data['Activereservation']['reservation_time'] = $_POST['reservation_time'];
				$data['Activereservation']['reservation_user'] = $reservationUser;
				$data['Activereservation']['reservation_service'] = $_POST['reservation_service'];
				$data['Activereservation']['reservation_barber'] = $_POST['reservation_barber'];
				$data['Activereservation']['creation_date'] = date('Y-m-d H:i:s');
				$this->Activereservation->save($data);

				$this->Customer->query('delete from customers where user_id=' . $reservationUser);
				$this->Customer->create();
				$data['Customer']['last_appointment'] = $reservationDate;
				$data['Customer']['user_id'] = $reservationUser;
				$data['Customer']['date_creation'] = date('Y-m-d H:i:s');
				$this->Customer->save($data);
				Cache::clear();
				echo 1;
			} else {
				echo 0;
			}
		} else {
			if (!$reservationTaken) {
				echo 4;
			} else {
				echo 3;
			}
		}
	}

	public function reservationTaken($reservation_barber, $reservation_time, $reservationDate)
	{
		$reservationTaken = $this->Reservation->find('first', array('conditions' => array('Reservation.reservation_barber' => $reservation_barber, 'Reservation.reservation_time' => $reservation_time, 'Reservation.reservation_date' => $reservationDate, 'Reservation.reservation_status <>' => 2)));
		if (!empty($reservationTaken)) {
			return false;
		} else {
			return true;
		}
	}

	public function save_reservation_calendar()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		if ($_POST['reservation_date'] == '') {
			$reservationDate = date('Y-m-d');
		} else {
			$reservationDate = $_POST['reservation_date'];
		}
		/**
		 * Validar si alguien más tomó la cita
		 */
		$reservationTaken = $this->reservationTaken($_POST['reservation_barber'],$_POST['reservation_time'],$reservationDate);
		if( $reservationTaken ){
		$serviceId = $_POST['reservation_service'];	
		$reservationPrice = $this->getServicePrice( $serviceId );	
		$this->Reservation->create();
		$data['Reservation']['reservation_date'] = $reservationDate;
		$data['Reservation']['reservation_time'] = $_POST['reservation_time'];
		$data['Reservation']['reservation_user'] = $_POST['reservation_client'];
		$data['Reservation']['reservation_service'] = $_POST['reservation_service'];
		$data['Reservation']['reservation_barber'] = $_POST['reservation_barber'];
		$data['Reservation']['reservation_price'] = $reservationPrice;
		$data['Reservation']['creation_date'] = date('Y-m-d H:i:s');
		if($this->Reservation->save($data)){
			$lastReservationId = $this->Reservation->getLastInsertID();
			$this->Activereservation->create();
			$data['Activereservation']['id_reservation'] = $lastReservationId;
			$data['Activereservation']['reservation_date'] = $reservationDate;
			$data['Activereservation']['reservation_time'] = $_POST['reservation_time'];
			$data['Activereservation']['reservation_user'] = $_POST['reservation_client'];
			$data['Activereservation']['reservation_service'] = $_POST['reservation_service'];
			$data['Activereservation']['reservation_barber'] = $_POST['reservation_barber'];
			$data['Activereservation']['creation_date'] = date('Y-m-d H:i:s');
			$this->Activereservation->save($data);

				$this->Customer->query('delete from customers where user_id=' . $_POST['reservation_client']);
				$this->Customer->create();
				$data['Customer']['last_appointment'] = $reservationDate;
				$data['Customer']['user_id'] = $_POST['reservation_client'];
				$data['Customer']['date_creation'] = date('Y-m-d H:i:s');
				$this->Customer->save($data);
				Cache::clear();
				echo 1;
			} else {
				echo 0;
			}
		} else {
			Cache::clear();
			echo 4;
		}
	}
    
	public function getServicePrice( $serviceId ){
		$serviceId = explode(',',$serviceId);
		$servicePrices = $this->Service->find('all',array('fields'=>array('Service.price'),'conditions'=>array('Service.id'=>$serviceId)));
		$price = 0;
		foreach( $servicePrices as $servicePrice ){
			$price = $price + $servicePrice['Service']['price'];
		}
		return $price;
	}


	public function events()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$events = array();
		$reservations = Cache::read('reservationResponse' . $_SESSION['User']['User']['id']);

		if (!$reservations) {

			$this->reservations();
			$reservations = Cache::read('reservationResponse' . $_SESSION['User']['User']['id']);
		}
		
		
		foreach ($reservations as $reservation) {
			
			$reservationId = $reservation['Reservation']['id'];
			$reservationdate = $reservation['Reservation']['reservation_date'];
			$reservationtimeStart = $reservation['Reservation']['reservation_time'];

			$time = date('H:i:s', strtotime($reservationtimeStart));
			$duration = $reservation[0];
			$duration = strval($duration);
			$sumarTime = strtotime('+' . $duration . ' minute', strtotime($time));
			$reservationtimeEnd = date('H:i:s', $sumarTime);

			$userId = $reservation['User']['id'];
			$userName = $reservation['User']['name'];
			
			$servicesIds = $reservation['Reservation']['reservation_service'];
			$serviceNames = $this->Service->find('all',array('fields'=>array('Service.service_name'),'conditions'=>array('Service.id'=>$servicesIds)));
			$service = '';
			foreach( $serviceNames as $serviceName ){
				$service .= $serviceName['Service']['service_name'].'/';
			}
			
			$barberName = $reservation['Barber']['name'];
			$barbercolor = $reservation['Barber']['color'];

			$event = array('groupId' => $reservationId, 'id' => $service, 'title' => $userName, 'start' => $reservationdate . 'T' . $reservationtimeStart, 'end' => $reservationdate . 'T' . $reservationtimeEnd, 'color' => $barbercolor);
			array_push($events, $event);
		}
		$events = mb_convert_encoding($events, 'UTF-8', 'UTF-8');
		echo json_encode($events);
		
		
	}
	
	public function calendar()
	{

		$this->layout = 'ajax';
		$events = array();
		$this->checksession(2);
		$reservations = Cache::read('reservationResponse' . $_SESSION['User']['User']['id']);
		if (!$reservations) {

			$this->reservations();
			$reservations = Cache::read('reservationResponse' . $_SESSION['User']['User']['id']);
		}
		foreach ($reservations as $reservation) {
			$reservationId = $reservation['Reservation']['id'];
			$reservationdate = $reservation['Reservation']['reservation_date'];
			$reservationtimeStart = $reservation['Reservation']['reservation_time'];

			$time = date('H:i:s', strtotime($reservationtimeStart));
			$duration = $reservation[0];
			$duration = strval($duration);
			$sumarTime = strtotime('+' . $duration . ' minute', strtotime($time));
			$reservationtimeEnd = date('H:i:s', $sumarTime);

			$userId = $reservation['User']['id'];
			$userName = $reservation['User']['name'];


			$servicesIds = $reservation['Reservation']['reservation_service'];
			$serviceNames = $this->Service->find('all',array('fields'=>array('Service.service_name'),'conditions'=>array('Service.id'=>$servicesIds)));
			$service = '';
			foreach( $serviceNames as $serviceName ){
				$service .= $serviceName['Service']['service_name'].'/';
			}
			$barberName = $reservation['Barber']['name'];
			$barbercolor = $reservation['Barber']['color'];

			$event = array('groupId' => $reservationId, 'id' => $service, 'title' => $userName, 'start' => $reservationdate . 'T' . $reservationtimeStart, 'end' => $reservationdate . 'T' . $reservationtimeEnd, 'color' => $barbercolor);
			array_push($events, $event);
		}

		$this->set('events', $events);

		$barbers = $this->User->find(
			'all',
			array(
				'conditions' => array(
					'OR' => array(
						array('User.type' => 1),
						array('User.type' => 2)
					)
				)
			)
		);
		$this->set('barbers', $barbers);
	}

	public function reservations()
	{
		$conditions['Reservation.reservation_status <>'] = 2;

		$reservations = $this->Reservation->find('all', array(
			'fields' =>
			array(
				'Reservation.id','Reservation.reservation_service', 'Reservation.reservation_status', 'Reservation.reservation_date', 'Reservation.reservation_time',
				'Service.id', 'Service.service_name', 'Service.price',
				'Barber.id', 'Barber.name', 'Barber.color',
				'User.id', 'User.name', 'User.phone',
			),
			'conditions' =>
			array($conditions),
			'joins' =>
			array(
				array(
					'table' => 'services',
					'alias' => 'Service',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Service.id = Reservation.reservation_service'),
				),
				array(
					'table' => 'users',
					'alias' => 'Barber',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Barber.id = Reservation.reservation_barber')
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = Reservation.reservation_user')
				)
			),
			'order' => array('Reservation.reservation_date' => 'ASC', 'Reservation.reservation_time' => 'ASC')
		));
		$reservationResponse = array();
		foreach ($reservations as $reservation) {
			$servicesIds = explode(',',$reservation['Reservation']['reservation_service']);
			$timeDurations = $this->Duration->find('all', array('fields' => array('Duration.duration'), 'conditions' => array('Duration.barber' => $reservation['Barber']['id'], 'Duration.service_id' => $servicesIds)));
			$duration = 0;
			foreach( $timeDurations as $timeDuration ){
				$duration = $duration + $timeDuration['Duration']['duration'];
			}
			
			array_push($reservation, $duration);
			array_push($reservationResponse, $reservation);
		}
		
		Cache::write('reservationResponse' . $_SESSION['User']['User']['id'], $reservationResponse);
	}
	public function customers()
	{
		$this->checksession(4);
	}


	public function load_customer()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$idCustomer = $_POST['idCustomer'];
		//seria bueno agregar el barbero en customers, para saber quien fue el ultimo barbero que atendio a un cliente
		$customer = $this->User->find('all', array(
			'fields' => array('Customer.user_id', 'Customer.last_appointment', 'User.user_id', 'User.name', 'User.phone', 'User.status'),
			'conditions' => array('.id' => $idCustomer),
			'joins' =>
			array(
				array(
					'table' => 'customers',
					'alias' => 'Customer',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = Customer.user_id')
				)
			),
			'recursive' => 2
		));
		$customer = mb_convert_encoding($customer, 'UTF-8', 'UTF-8');
		echo json_encode($customer);
	}

	public function search_customer()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchCustomer = $_POST['searchCustomer'];
		$customer = $this->User->find('all', array(
			'fields' => array('Customer.user_id', 'Customer.last_appointment', 'User.id', 'User.name', 'User.phone', 'User.status'),
			'conditions' => array('OR' => array(
				array('User.name LIKE' => "%$searchCustomer%"),
				array('User.phone' => $searchCustomer)
			)),
			'joins' =>
			array(
				array(
					'table' => 'customers',
					'alias' => 'Customer',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = Customer.user_id')
				)
			),
			'recursive' => 2
		));
		$customer = mb_convert_encoding($customer, 'UTF-8', 'UTF-8');
		echo json_encode($customer);
	}

	public function edit_customer()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchCustomer = $_POST['idCustomer'];
		$customer = $this->User->find('first', array(
			'fields' => array('Customer.id','Customer.user_id','Customer.date_creation', 'Customer.last_appointment', 'User.id', 'User.name', 'User.phone', 'User.status', 'User.password'),
			'conditions' => array('User.id' => $searchCustomer),
			'joins' =>
			array(
				array(
					'table' => 'customers',
					'alias' => 'Customer',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = Customer.user_id')
				)
			),
			'recursive' => 2
		));
		$customer = mb_convert_encoding($customer, 'UTF-8', 'UTF-8');
		echo json_encode($customer);
	}


	public function add_customer()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->User->create();
			$data['User']['name'] = $_POST['nameCustomer'];
			$data['User']['phone'] = $_POST['phoneCustomer'];
			$pass = $this->Encrypt->encrypt($_POST['passwordCustomer']);
			$data['User']['password'] = $pass;
			$data['User']['type'] = 3;
			$data['User']['status'] = 1;
			$data['User']['creation_date'] = date('Y-m-d H:i:s');
			if ($this->User->save($data)) {
				$userId = $this->User->getLastInsertID();
				if( isset($_POST['sendPassword']) ){
					$this->Sendpassword->create();
					$data['Sendpassword']['id_user'] = $userId;
					$data['Sendpassword']['status_password'] = 0;
					$data['Sendpassword']['creation_date'] = date('Y-m-d H:i:s');
					$this->Sendpassword->save($data);
				}
				$last_appointment = $_POST['last_appointment'];
				$this->Customer->create();
				$datac['Customer']['user_id'] = $userId;
				$datac['Customer']['last_appointment'] = $last_appointment;
				$datac['Customer']['date_creation'] = date('Y-m-d H:i:s');
				if($this->Customer->save($datac)){
					Cache::clear();
					sleep(3);
					$this->redirect(array('action' => '../customers'));
					}
				
			}
		}
	}

	public function update_customer()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->User->id = $_POST['idEditCustomer'];
			$data['User']['name'] = $_POST['nameEditCustomer'];
			$data['User']['phone'] = $_POST['phoneEditCustomer'];
			$data['User']['status'] = $_POST['statusEditCustomer'];
			if (empty($_POST['passwordEditCustomer'])) {
				$data['User']['password'] = $_POST['passwordEditEncryptCustomer'];
			} else {
				$pass = $this->Encrypt->encrypt($_POST['passwordEditCustomer']);
				$data['User']['password'] = $pass;
			}

			if ($this->User->save($data)) {

				if( isset($_POST['sendEditPassword']) ){
					$this->Sendpassword->query('delete from sendpasswords where id_user='.$_POST['idEditCustomer']);
					$this->Sendpassword->create();
					$data['Sendpassword']['id_user'] = $_POST['idEditCustomer'];
					$data['Sendpassword']['status_password'] = 0;
					$data['Sendpassword']['creation_date'] = date('Y-m-d H:i:s');
					$this->Sendpassword->save($data);
				}

				$this->Customer->user_id = $_POST['idEditCustomer'];
				$idRegister = $_POST['idEditCustomerId'];
				$this->Customer->id =$idRegister;
				$datac['Customer']['last_appointment'] = $_POST['lastAppointmentEdit'];
				$datac['Customer']['user_id'] = $_POST['idEditCustomer'];
				$datac['Customer']['date_creation'] = $_POST['EditCustomerCreationDate'];
				if ($this->Customer->save($datac)) {
					sleep(3);
					$this->redirect(array('action' => '../customers'));
				}
			}
		}
	}

	public function users()
	{
		$this->checksession(10);
	}


	/*public function load_user()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$iduser = $_POST['iduser'];
		//seria bueno agregar el barbero en customers, para saber quien fue el ultimo barbero que atendio a un cliente
		$user = $this->User->find('all', array(
			'fields' => array('Customer.user_id', 'Customer.last_appointment', 'User.user_id', 'User.name', 'User.phone', 'User.status'),
			'conditions' => array('.id' => $iduser),
			'joins' =>
			array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = Customer.user_id')
				)
			),
			'recursive' => 2
		));

		echo json_encode($user);
	}*/

	public function search_user()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchUser = $_POST['searchUser'];
		$user = $this->User->find('all', array(
			'fields' => array('User.id', 'User.name', 'User.phone', 'User.type'),
			'conditions' => array('User.type !=' => 3, 'OR' => array(
				array('User.name LIKE' => "%$searchUser%"),
				array('User.phone' => $searchUser)
			)),
			'recursive' => 2
		));
		$user = mb_convert_encoding($user, 'UTF-8', 'UTF-8');
		echo json_encode($user);
	}

	public function edit_user()
	{  
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchUser = $_POST['idUser'];
		$user = $this->User->find('first', array(
			'fields' => array('User.id', 'User.name', 'User.phone', 'User.status', 'User.password', 'User.type', 'User.color'),
			'conditions' => array('User.id' => $searchUser),
			'recursive' => 2
		));
		$roles = $this->Role->find('all',array('fields' => array('Role.id_module'),'conditions'=>array('Role.id_user'=>$searchUser)));
		array_push($user,$roles);
		$user = mb_convert_encoding($user, 'UTF-8', 'UTF-8');
		echo json_encode($user);
	}

	public function search_Services()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$service = $this->Service->find('all', array(
			'fields' => array('Service.id', 'Service.service_name')
		));
		$service = mb_convert_encoding($service, 'UTF-8', 'UTF-8');
		echo json_encode($service);
	}

	public function search_duration()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchUser = $_POST['searchDuration'];
		$duration = $this->Duration->find('all', array(
			'fields' => array('Duration.id', 'Duration.duration', 'Duration.barber', 'Duration.service_id', 'Service.id', 'Service.service_name'),
			'conditions' => array('Duration.barber' => $searchUser),
			'joins' =>
			array(
				array(
					'table' => 'services',
					'alias' => 'Service',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Duration.service_id = Service.id')
				)
			),
			'recursive' => 2
		));
		$duration = mb_convert_encoding($duration, 'UTF-8', 'UTF-8');
		echo json_encode($duration);
	}

	public function add_user()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->User->create();
			$data['User']['name'] = $_POST['nameAdd'];
			$data['User']['phone'] = $_POST['phoneAdd'];
			$data['User']['color'] = $_POST['colorAdd'];
			$data['User']['type'] = $_POST['typeAdd'];
			$pass = $this->Encrypt->encrypt($_POST['passwordAdd']);
			$data['User']['password'] = $pass;
			$data['User']['status'] = 1;
			$data['User']['creation_date'] = date('Y-m-d');
			if ($this->User->save($data)) {
				$services = $this->Service->find('all', array(
					'fields' => array('Service.id')
				));
				$barberId = $this->User->getLastInsertID();
				for( $i=1; $i<=9; $i++){
					if( isset($_POST['role'.$i]) ){
						$this->Role->create();
						$dataRole['Role']['id_user'] = $barberId;
						$dataRole['Role']['id_module'] = $i;
						$dataRole['Role']['creation_date'] = date('Y-m-d');
						$this->Role->save($dataRole);
					}
				}

				foreach ($services as $service) {
					$this->Duration->create();
					if (empty($_POST['inputService_' . $service['Service']['id']])) {
						$data['Duration']['duration'] = 0;
					} else {
						$data['Duration']['duration'] = $_POST['inputService_' . $service['Service']['id']];
					}

					$data['Duration']['barber'] = $barberId;
					$data['Duration']['service_id'] = $service['Service']['id'];
					$this->Duration->save($data);
				}

				sleep(3);
				$this->redirect(array('action' => '../users'));
			}
		}
	}

	public function update_user()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->User->id = $_POST['idEdit'];
			$data['User']['name'] = $_POST['nameEdit'];
			$data['User']['phone'] = $_POST['phoneEdit'];
			$data['User']['status'] = $_POST['statusEdit'];
			$data['User']['type'] = $_POST['typeEdit'];
			$data['User']['color'] = $_POST['colorEdit'];
			$barberId = $_POST['idEdit'];
			if (empty($_POST['passwordEdit'])) {
				$data['User']['password'] = $_POST['passwordEditEncrypt'];
			} else {
				$pass = $this->Encrypt->encrypt($_POST['passwordEdit']);
				$data['User']['password'] = $pass;
			}

			if ($this->User->save($data)) {
				$barberId = $_POST['idEdit'];
				$this->Role->query('delete from roles where id_user='.$barberId);
				for( $i=1; $i<=9; $i++){
					if( isset($_POST['roleEdit'.$i]) ){
						
						$this->Role->create();
						$dataRole['Role']['id_user'] = $barberId;
						$dataRole['Role']['id_module'] = $i;
						$dataRole['Role']['creation_date'] = date('Y-m-d');
						$this->Role->save($dataRole);
					}
				}

				$services = $this->Service->find('all', array(
					'fields' => array('Service.id')
				));
				$this->Duration->query('delete from durations where barber=' . $barberId);
				foreach ($services as $service) {
					$this->Duration->create();
					if (empty($_POST['inputEditService_' . $service['Service']['id']])) {
						$dataD['Duration']['duration'] = 0;
					} else {
						$dataD['Duration']['duration'] = $_POST['inputEditService_' . $service['Service']['id']];
					}

					$dataD['Duration']['barber'] = $barberId;

					$dataD['Duration']['service_id'] = $service['Service']['id'];
					$this->Duration->save($dataD);
				}
				sleep(3);
				$this->redirect(array('action' => '../users'));
			}
		Cache::clear();
		sleep(3);
		$this->redirect(array('action' => '../users'));
		}
	}


	function validateReservations($reservationUser){
		
		$activeReservations = $this->Reservation->find('all',array('conditions'=>array('Reservation.reservation_user'=>$reservationUser,'Reservation.reservation_status <>'=>2,'Reservation.payment_type '=>0,'Reservation.reservation_date >= '=>date('Y-m-d'))));
		
		if( count($activeReservations) < 2 ){
			return true;
		} else {
			return false;
		}
	}

	function cancel_appointment()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$appointmentId = $_POST['reservation_id'];
		$reservation_time = $_POST['reservation_time'];
		$reservation_date = $_POST['reservation_date'];
		$this->Reservation->id = $appointmentId;
		$data['Reservation']['reservation_status'] = 2;
		if ($this->Reservation->save($data)) {
			$activeReservationid = $this->getActiveReservationId($appointmentId);
			$this->Activereservation->id = $activeReservationid;
			$data['Activereservation']['reservation_status'] = 2;
			$this->Activereservation->save($data);
			//Guardar Notification
			$this->validate_cancel($appointmentId, $reservation_time, $reservation_date);
			Cache::clear();
		}
	}

	public function getActiveReservationId($reservationId)
	{
		$activeReservation = $this->Activereservation->find('first', array('conditions' => array('Activereservation.id_reservation' => $reservationId)));
		return $activeReservation['Activereservation']['id'];
	}
	public function validate_cancel($appointmentId, $reservation_time, $reservation_date)
	{
		$currentDate = date('Y-m-d');
		$reservationTime = date($reservation_time);
		$timeLess = strtotime('-1 hour', strtotime($reservationTime));
		$timePlus = strtotime('+1 hour', strtotime($reservationTime));
		$newTimeLess = date('H', $timeLess);
		$newTimePlus = date('H', $timePlus);
		$newTimeLess = $newTimeLess . ':00';
		$newTimePlus = $newTimePlus . ':00';
		$data = array();
		$this->Remove->create();
		$data['Remove']['id_reservation'] = $appointmentId;
		$data['Remove']['time_from'] = $newTimeLess;
		$data['Remove']['reservation_time'] = $reservationTime;
		$data['Remove']['time_to'] = $newTimePlus;
		$data['Remove']['reservation_date'] = date('Y-m-d', strtotime($reservation_date));
		$data['Remove']['date_creation'] = date('Y-m-d H:i:s');
		$this->Remove->save($data);
	}

	function confirm_appointment()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$appointmentId = $_POST['reservation_id'];
		$this->Reservation->id = $appointmentId;
		$data['Reservation']['reservation_status'] = 1;
		if ($this->Reservation->save($data)) {
			$activeReservationid = $this->getActiveReservationId($appointmentId);
			$this->Activereservation->id = $activeReservationid;
			$data['Activereservation']['reservation_status'] = 1;
			$this->Activereservation->save($data);
			Cache::clear();
		}
	}

	function load_appointment()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$appointmentId = $_POST['reservation_id'];
		$conditions['Reservation.id'] = $appointmentId;
		$conditions['Reservation.reservation_status <>'] = 2;
		$reservation = $this->Reservation->find('first', array(
			'fields' =>
			array(
				'Reservation.id', 'Reservation.reservation_status','Reservation.reservation_service', 'Reservation.reservation_price', 'Reservation.reservation_date', 'Reservation.reservation_time',
				'Barber.id', 'Barber.name', 'Barber.color',
			),
			'conditions' =>
			array($conditions),
			'joins' =>
			array(
				array(
					'table' => 'users',
					'alias' => 'Barber',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Barber.id = Reservation.reservation_barber')
				)
			)
		));
		$reservationLoad = array();
			$servicesIds = explode(',',$reservation['Reservation']['reservation_service']);
			$serviceNames = $this->Service->find('all',array('fields'=>array('Service.service_name'),'conditions'=>array('Service.id'=>$servicesIds)));
			$service = '';
			foreach( $serviceNames as $serviceName ){
				$service .= $serviceName['Service']['service_name'].'/';
			}
			array_push($reservation,$service);
		

		$reservation = mb_convert_encoding($reservation, 'UTF-8', 'UTF-8');
		echo json_encode($reservation);
	}

	public function filter_barber()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$user = $_SESSION['User'];
		if ($_POST['barber'] != 0) {
			$conditions['Reservation.reservation_barber'] = $_POST['barber'];
		}
		if ($user['User']['type'] == 2) {
			$conditions['Reservation.reservation_barber'] = $user['User']['id'];
		}
		if ($_POST['filter_date'] != '') {
			$conditions['Reservation.reservation_date'] = $_POST['filter_date'];
		} else {
			$conditions['Reservation.reservation_date >='] = date('Y-m-d');
		}

		$conditions['Reservation.reservation_status <>'] = 2;
		$reservations = array();
		$reservations = $this->Reservation->find('all', array(
			'fields' =>
			array(
				'Reservation.id','Reservation.reservation_service','Reservation.reservation_price','Reservation.payment_type','Reservation.reservation_bill', 'Reservation.reservation_status', 'Reservation.reservation_date', 'Reservation.reservation_time',
				'Barber.id', 'Barber.name', 'Barber.color',
				'User.id', 'User.name', 'User.phone',
			),
			'conditions' =>
			array($conditions),
			'joins' =>
			array(
				array(
					'table' => 'users',
					'alias' => 'Barber',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Barber.id = Reservation.reservation_barber')
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('User.id = Reservation.reservation_user')
				)
			),
			'order' => array('Reservation.reservation_date' => 'ASC', 'Reservation.reservation_time' => 'ASC')
		));
		$reservationResponse = array();
		foreach ($reservations as $reservationFirst) {
			$servicesIds = explode(',',$reservationFirst['Reservation']['reservation_service']);
			$timeDurations = $this->Duration->find('all', array('fields' => array('Duration.duration'), 'conditions' => array('Duration.barber' => $reservationFirst['Barber']['id'], 'Duration.service_id' => $servicesIds)));
			$duration = 0;
			foreach( $timeDurations as $timeDuration ){
				$duration = $duration + $timeDuration['Duration']['duration'];
			}

			array_push($reservationFirst, $duration);

			$serviceNames = $this->Service->find('all',array('fields'=>array('Service.service_name'),'conditions'=>array('Service.id'=>$servicesIds)));
			$nameService = '';
			foreach( $serviceNames as $serviceName ){
				$nameService .= $serviceName['Service']['service_name'].'/';
			}

			array_push($reservationFirst, $nameService);

			array_push($reservationResponse, $reservationFirst);
		}


		$response = '('.count($reservationResponse).')***';

		if (!empty($reservationResponse)) {

			foreach ($reservationResponse as $reservation) {
				$date = $reservation['Reservation']['reservation_date'];
				$day  = date('w', strtotime($date));
				$days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
				$year = date('Y', strtotime($date));
				$month = date('m', strtotime($date));
				$months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
				$currentDay = date('d', strtotime($date));
				$dayOfTheWeek = $days[$day];


				$response .= '<form name="subirArchivo" action="" method="post" enctype="multipart/form-data">
                			  <li>
                    		  <span class="event-list-item-content">
                    		  <div class="event-list-info">
                        	  <h3>'.substr($reservation[1],0,-1).'</h3>
                        	  <p>Fecha : '.$dayOfTheWeek.' '.$currentDay.' de '.$months[(int)$month-1].' del '.$year.'</p>
                        	  <p>Hora : '.$reservation['Reservation']['reservation_time'].'</p>
                        	  <p>Barbero : '.$reservation['Barber']['name'].'</p>
                        	  <p>Cliente : '.$reservation['User']['name'].'<a taget="_blank" href="https://api.whatsapp.com/send?phone=506'.$reservation['User']['phone'].'&text=Hola '.$reservation['User']['name'].'!
							   💈 Tienes cita para corte a las '.$reservation['Reservation']['reservation_time'].' , por favor confirmar en el siguiente link: https://alofresa.com/confimar/jhakjahsd"><img width="30px" src="img/layout/whatsapp.png" alt=""></a></p>
                        	  <p>Tiempo : '.$reservation[0].' minutos</p>
                        	  <p>Estatus de la cita :';
							  if( $reservation['Reservation']['reservation_status'] == 0 ){ $response .= 'Sin Confirmar'; }
							  if( $reservation['Reservation']['reservation_status'] == 1 ){ $response .= 'Confirmada'; }
							  if( $reservation['Reservation']['reservation_status'] == 2 ){ $response .= '<b class="blink_me">CANCELADA</b>'; }
							  $response .= '</p>
                        	  <p>Precio : ₡'.number_format($reservation['Reservation']['reservation_price']).'</p>';
							 if( $reservation['Reservation']['reservation_status'] == 1 && $reservation['Reservation']['payment_type'] != '2' && $reservation['Reservation']['payment_type'] != '1'  && $reservation['Reservation']['reservation_status'] != 2 ){    
							  $response .= '<p>Selecciona el tipo de pago:</p>  
                    		  <select onchange="tipopago(this.value)" class="form-control" name="tipoPago'.$reservation['Reservation']['id'].'" id="tipoPago'.$reservation['Reservation']['id'].'">
                    		  <option value="1">SINPE Movil</option>
                    		  <option value="2">Efectivo</option>
                    		  </select>    
						      </br> 
							  <span id="comprobanteSubir">
							  <p>Subir comprobante de pago:</p>    
							  <input type="file"  class="form-control" name="comprobante'.$reservation['Reservation']['id'].'" id="comprobante'.$reservation['Reservation']['id'].'">
							  </span>
							  <input type="hidden" name="idReservation" id="idReservation" value="'.$reservation['Reservation']['id'].'">
							  </br>';  
                   
							if( $reservation['Reservation']['reservation_status'] == 0 ){
							$response .= '<button type="button" class="btn btn-secondary" onclick="confirmAppointment('.$reservation['Reservation']['id'].')"><a>Confirmar Cita</a></button>';
						    }else{
							$response .= '<button type="submit" class="btn btn-success"><a>Guardar</a></button>';
							}
							$reservatioTime = "'".$reservation['Reservation']['reservation_time']."'";
							$reservatioDate = "'".$reservation['Reservation']['reservation_date']."'";
						
							$response .= '<button type="button" class="btn btn-danger" onclick="cancelAppointment('.$reservation['Reservation']['id'].','.$reservatioTime.','.$reservatioDate.')"><a>Eliminar</a></button>
										  </div>
										  </span>';
						   }else{ 
								if( $reservation['Reservation']['reservation_status'] == 0 ){
								
									$response .= '<button type="button" class="btn btn-secondary" onclick="confirmAppointment('.$reservation['Reservation']['id'].')"><a>Confirmar Cita</a></button>';
									$reservatioTime = "'".$reservation['Reservation']['reservation_time']."'";
									$reservatioDate = "'".$reservation['Reservation']['reservation_date']."'";
									$response .= '<button type="button" class="btn btn-danger" onclick="cancelAppointment('.$reservation['Reservation']['id'].','.$reservatioTime.','.$reservatioDate.')"><a>Eliminar</a></button>
									</div>
									</span>';
									
								}else{
									if( $user['User']['type'] == 1 ){
									
										$response .= '<p>Forma de pago :';
										if($reservation['Reservation']['payment_type'] == 2){ $response .= 'Efectivo'; }else{ 
											if($reservation['Reservation']['payment_type'] == 1){ $response .= 'SINPE'; }else{ $response .= 'N/A'; } 
										}
										$response .= '</p>';  
										if( $reservation['Reservation']['payment_type'] == 1 && $reservation['Reservation']['reservation_bill'] != '' ){
											$comprobante = 'bills/'.$reservation['Reservation']['id'].'_'.$reservation['Reservation']['reservation_bill'];
                            				$comprobante = "'".$comprobante."'";
											$response .= '<img id="comprobante_imagen" onclick="comprobanteShow('.$comprobante.');" src="bills/'.$reservation['Reservation']['id'].'_'.$reservation['Reservation']['reservation_bill'].'" width="40px" data-bs-toggle="modal" data-bs-target="#modalAmpliarImagen">';
										
										}
									}
								} 
							}
				$response .= '</li>
                			  </form>';
			}
		} else {
			$response .=    '<span style="color:white">No hay Citas programadas</span>';
		}
		echo $response;
	}

	/**
	 * Run onces a day
	 */

	 public function notification_biweekly(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$ch = curl_init();
		$token = "EAAZAeI4i9EJ8BOwPXWyIBLkuOHIpMAU0IwFqIeiX0aEr5zBQoNergR3WbZBk2zauyM7GosrbshJj6ZAytEktxTh88sJCRVZA9NY5RnDl4PM0yMdNXLh0ZBoL6YjT67EnbNBzunF2ew0kcOh2XvZCD7EDoZArydz9QHIrGnRhGLsOjoD6Vip08DrLZBZAnnaT1MnDHilqMkNYAG0VgZAeZCYVjWpyosqQdIZD";
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v17.0/136967432828861/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);

		$customers = $this->Customer->query('SELECT DATEDIFF(CURDATE(),clientes.last_appointment) as dias_transcurridos,clientes.user_id,usuarios.name,usuarios.phone from customers as clientes INNER JOIN users as usuarios ON clientes.user_id=usuarios.id where DATEDIFF(CURDATE(),clientes.last_appointment) = 15');
		foreach( $customers as $customer ){
			$nombre = $customer["usuarios"]["name"];
			//$phone = $customer["usuarios"]["phone"];
			$info = base64_encode($customer["clientes"]["user_id"]);
			$phone = '83481182';
			$data = array();
			$data = array(
				'messaging_product' => 'whatsapp',
				'to' => '506'.$phone,
				'type' => 'template',
				'template' => array(
						'name' => 'quince',
						 'language' => array( 'code' => 'es_MX'),
						 'components' =>array(
												array(
													'type'=>'header',
													'parameters'=> array(
														array(
															'type'=> 'image',
															'image' => array(
																'link' => 'https://eibyz.com/app/webroot/barberiaimg/alofresa.jpeg'
															)
														)
													)
												),
												array(
													'type'=>'body',
													'parameters'=> array(
														array(
																'type'=>'text',
																'text'=> $nombre
														)
														),
														
													),
													array(
														'type'=>'button',
														"index"=> "0",
														"sub_type"=> "url",
															'parameters'=> array(
															 array(
																'type'=>'text',
																'text'=> $info
															)
														)
													),
											)
						)
			);
			$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			var_dump($server_output);
			curl_close($ch);
			
		}
	}

	/**
	 * Run every minute
	 * cachecron
	 */
	public function notification_confirm(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$ch = curl_init();
		$token = "EAAZAeI4i9EJ8BOwPXWyIBLkuOHIpMAU0IwFqIeiX0aEr5zBQoNergR3WbZBk2zauyM7GosrbshJj6ZAytEktxTh88sJCRVZA9NY5RnDl4PM0yMdNXLh0ZBoL6YjT67EnbNBzunF2ew0kcOh2XvZCD7EDoZArydz9QHIrGnRhGLsOjoD6Vip08DrLZBZAnnaT1MnDHilqMkNYAG0VgZAeZCYVjWpyosqQdIZD";
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v17.0/136967432828861/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);

		$currentDate = date('Y-m-d');
		$currentTime= date('H:i:s'); 
		$newTime = strtotime ( '+3 hour' , strtotime ($currentTime) ) ; 
		$newTime = date ( 'H:i' , $newTime);
		$newTime = $newTime.':00';
		
		$reservations = Cache::read('notification_confirm');
		
		if( !$reservations ){

		$reservations = $this->Activereservation->find('all',array('fields'=>array('Activereservation.id_reservation,Activereservation.reservation_date,Activereservation.reservation_time,User.id,User.name,User.phone'),
															 'conditions'=>array(
																				'Activereservation.reservation_time'=>$newTime,'Activereservation.reservation_date'=>$currentDate,'Activereservation.reservation_status <>'=>2
																				),
															 'joins' =>																			array(
																		array(
																			'table' => 'users',
																			'alias' => 'User',
																			'type' => 'inner',
																			'foreignKey' => false,
																			'conditions'=> array('User.id = Activereservation.reservation_user'),
																		)
																	)));
		Cache::write('notification_confirm', $reservations);															
																	
		}

		foreach( $reservations as $reservation ){
			$data = array();
			$nombre = $reservation['User']['name'];
			//$phone = $reservation['User']['phone'];
			$phone = '83481182';
			$hora = $reservation['Activereservation']['reservation_time'];
			$info = base64_encode($reservation['Activereservation']['id_reservation'].'|'.$hora.'|'.$reservation['Activereservation']['reservation_date']);
			$data = array(
				'messaging_product' => 'whatsapp',
				'to' => '506'.$phone,
				'type' => 'template',
				'template' => array(
						'name' => 'recordar_cita',
						 'language' => array( 'code' => 'es_MX'),
						 'components' =>array(
												array(
													'type'=>'header',
													'parameters'=> array(
														array(
															'type'=> 'image',
															'image' => array(
																'link' => 'https://eibyz.com/app/webroot/barberiaimg/alofresa.jpeg'
															)
														)
													)
												),
												array(
													'type'=>'body',
													'parameters'=> array(
														array(
																'type'=>'text',
																'text'=> $nombre
														),
														array(
															'type'=>'text',
															'text'=> $hora
														)
														),
														
													),
													array(
														'type'=>'button',
														"index"=> "0",
														"sub_type"=> "url",
															'parameters'=> array(
															 array(
																'type'=>'text',
																'text'=> $info
															)
														)
													),
													array(
														'type'=>'button',
														"index"=> "1",
														"sub_type"=> "url",
															'parameters'=> array(
															 array(
																'type'=>'text',
																'text'=> $info
															)
														)
													)
											)
						)
			);
			$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			var_dump($server_output);
			curl_close($ch);
		}
		
		
	}

	/**
	 * everytime cancel reservation every 1 min
	 * cachecron
	 */
	public function notification_cancel(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$ch = curl_init();
		$token = "EAAZAeI4i9EJ8BOwPXWyIBLkuOHIpMAU0IwFqIeiX0aEr5zBQoNergR3WbZBk2zauyM7GosrbshJj6ZAytEktxTh88sJCRVZA9NY5RnDl4PM0yMdNXLh0ZBoL6YjT67EnbNBzunF2ew0kcOh2XvZCD7EDoZArydz9QHIrGnRhGLsOjoD6Vip08DrLZBZAnnaT1MnDHilqMkNYAG0VgZAeZCYVjWpyosqQdIZD";
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v17.0/136967432828861/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);
		$reservations = array();
		$currentDate = date('Y-m-d');
		$reservations = Cache::read('notification_cancel');
		
		if( !$reservations ){

		$reservations = $this->Remove->find('all',array('fields'=>array('Remove.id','Remove.id_reservation','Remove.reservation_time','Remove.reservation_date','Notification.user_id','Notification.reservation_date','User.id','User.name','User.phone'),
														'conditions'=>array(
																			'Remove.reservation_date >='=>$currentDate,
																			'Remove.reservation_date = Notification.reservation_date'
																			),
														 'joins'=>
														 array(
															 array(
																 'table' => 'notifications',
																 'alias' => 'Notification',
																 'type' => 'inner',
																 'foreignKey' => false,
																 'conditions'=> array('Notification.reservation_time >= Remove.time_from','Notification.reservation_time <= Remove.time_to'),
															 ),
															 array(
																'table' => 'users',
																'alias' => 'User',
																'type' => 'inner',
																'foreignKey' => false,
																'conditions'=> array('Notification.user_id = User.id'),
															)         
															)
														));
	

			Cache::write('notification_cancel', $reservations);															
						
		}												

		foreach( $reservations as $reservation ){

			
			$removeId = $reservation['Remove']['id'];
			$date = $reservation['Remove']['reservation_date'];
			$day  = date('w', strtotime($date));
			$days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
			$year = date('Y', strtotime($date));
			$month = date('m', strtotime($date));
			$months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
			$currentDay = date('d', strtotime($date));
			$dayOfTheWeek = $days[$day];
			$dateFormat = $dayOfTheWeek.' '.$currentDay.' de '.$months[(int)$month-1].' del '.$year;
			
			$data = array();
			$nombre = $reservation['User']['name'];
			//$phone = $reservation['User']['phone'];
			$phone = '72795112';
			$info = base64_encode($reservation['User']['id']);
			$hora = $dateFormat.' a las '.$reservation['Remove']['reservation_time'];
			
			$data = array(
				'messaging_product' => 'whatsapp',
				'to' => '+506'.$phone,
				'type' => 'template',
				'template' => array(
						'name' => 'reagendar',
						 'language' => array( 'code' => 'es_MX'),
						 'components' =>array(
												array(
													'type'=>'header',
													'parameters'=> array(
														array(
															'type'=> 'image',
															'image' => array(
																'link' => 'https://eibyz.com/app/webroot/barberiaimg/alofresa.jpeg'
															)
														)
													)
												),
												array(
													'type'=>'body',
													'parameters'=> array(
														array(
																'type'=>'text',
																'text'=> $nombre
														),
														array(
															'type'=>'text',
															'text'=> $hora
														)
														),
														
													),
													array(
														'type'=>'button',
														"index"=> "0",
														"sub_type"=> "url",
															'parameters'=> array(
															 array(
																'type'=>'text',
																'text'=> $info
															)
														)
													),
											)
						)
			);
			$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			var_dump($server_output);
			curl_close($ch);
			$this->Remove->query('delete from removes where id='.$removeId);
			Cache::clear();
		}
		

	}

	public function testWhatsapp()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$ch = curl_init();
		$token = "EAAZAeI4i9EJ8BOwPXWyIBLkuOHIpMAU0IwFqIeiX0aEr5zBQoNergR3WbZBk2zauyM7GosrbshJj6ZAytEktxTh88sJCRVZA9NY5RnDl4PM0yMdNXLh0ZBoL6YjT67EnbNBzunF2ew0kcOh2XvZCD7EDoZArydz9QHIrGnRhGLsOjoD6Vip08DrLZBZAnnaT1MnDHilqMkNYAG0VgZAeZCYVjWpyosqQdIZD";
		curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v17.0/136967432828861/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);
		$phone = '83481182';
		$data = array(
			'messaging_product' => 'whatsapp',
			'to' => '506' . $phone,
			'type' => 'template',
			'template' => array(
				'name' => 'prueba',
				'language' => array('code' => 'es_MX')
			)
		);


		$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		var_dump($server_output);
		curl_close($ch);
	}


	public function remove_block()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Block->query('delete from blocks where id=' . $_POST['blockId']);
		echo $_POST['blockId'];
	}

	public function edit_appointment()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Reservation->id = $_POST['reservation_id'];
		$data['Reservation']['reservation_barber'] = $_POST['barberId'];
		if ($this->Reservation->save($data)) {
			$activeReservationid = $this->getActiveReservationId($_POST['reservation_id']);
			$this->Activereservation->id = $activeReservationid;
			$data['Activereservation']['reservation_barber'] = $_POST['barberId'];
			$this->Activereservation->save($data);
			Cache::clear();
			echo 1;
		}
	}




	/**
	 * CronJob Run onces at midnight
	 */
	public function clean_notifications()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$currenDate = date('Y-m-d');
		$currenDate = "'" . $currenDate . "'";
		$this->Remove->query('delete from removes where reservation_date <=' . $currenDate);
		$this->Notification->query('delete from notifications where reservation_date <=' . $currenDate);
		$this->Activereservation->query('delete from activereservations where reservation_date <=' . $currenDate);
		Cache::clear();
	}

	public function checksession($moduleId)
	{
		if (!isset($_SESSION['User'])) {
			$this->redirect(array('action' => 'home'));
		}else{
			if( $moduleId != 1 && $_SESSION['User']['User']['type'] != 1){
				$permission = $this->checkRole( $moduleId );
				if( !$permission ){
					$this->redirect(array('action' => 'home'));
				}
			}
			
		}
	}

	public function checkRole( $moduleId ){
		$roles = $_SESSION['Role'];
		foreach( $roles as $role ){
			if( $moduleId == $role['Role']['id_module'] ){
				return true;
			}
		}
		return false;
	}

	public function work()
	{
		$this->checksession(6);
		if ($this->request->is('post')) {
			$this->Workhour->query('delete from workhours');
			$days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
			for ($i = 1; $i <= 7; $i++) {
				$current = $days[$i - 1];
				$this->Workhour->create();
				$data['Workhour']['work_day'] = $i;
				$data['Workhour']['work_open'] = $_POST[$current . '_open'];
				$data['Workhour']['work_close'] = $_POST[$current . '_close'];
				$data['Workhour']['date_creation'] = date('Y-m-d');
				$this->Workhour->save($data);
			}
		}
		$work_hours = $this->Workhour->find('all', array('order' => 'Workhour.work_day asc'));
		$this->set('work_hours', $work_hours);
	}

	public function block_check()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$conditions = array();
		$response = 'si';
		$barber_block = $_POST['barber_block'];
		if ($_POST['barber_block'] != 0) {
			$conditions['Reservation.reservation_barber'] = $barber_block;
		}
			$schedule_block = $_POST['schedule_block'];

			switch ($schedule_block) {
				case 0:
					/**
					 * No necesita evalución
					 */
					break;
				case 1:

					$conditions['Reservation.reservation_time <='] = date('H:i:s', strtotime('11:59:59'));
					break;
				case 2:
					$conditions['Reservation.reservation_time >='] = date('H:i:s', strtotime('12:00:00'));
					$conditions['Reservation.reservation_time <='] = date('H:i:s', strtotime('17:59:59'));
					break;
				case 3:
					$conditions['Reservation.reservation_time >='] = date('H:i:s', strtotime('18:00:00'));
					$conditions['Reservation.reservation_time <='] = date('H:i:s', strtotime('23:59:59'));
					break;
			}
		

				
	
				
		$date_block = $_POST['date_block'];
		if ($date_block == '') {
			$date_block = date('Y-m-d');
		}


		$reservation = $this->Reservation->find('first', array('conditions' => array('Reservation.reservation_date' => $date_block, 'Reservation.reservation_status <>' => 2, $conditions)));
		
		
		if (!empty($reservation)) {
			$response = 'no';
		}
		
		return $response;
	}

	public function product_sales(){
		$this->checksession(8);
	    $dateFrom = '';
		$dateTo = '';
		if ($this->request->is('post')) {
			$dateFrom = $_POST['desde_reporte'];
			if( $_POST['desde_reporte'] == ''){
				$dateFrom = date('Y-m-d');
			}

			$dateTo = $_POST['hasta_reporte'];
			if( $_POST['hasta_reporte'] == ''){
				$dateTo = date('Y-m-d');
			}
			
		}else{
			$dateFrom = date('Y-m-01');
			$dateTo = date("Y-m-t");
		}	
		
			/**
			 * Services
			 */
			$resevationsTotal = $this->Reservation->find('all',array('fields' => array('sum(Reservation.reservation_price)   AS ctotal'),'conditions'=>array('Reservation.reservation_date >='=>$dateFrom,'Reservation.reservation_date <='=>$dateTo,'Reservation.reservation_status'=>1)));
			$bankTotal = $this->Reservation->find('all',array('fields' => array('sum(Reservation.reservation_price)   AS ctotal'),'conditions'=>array('Reservation.reservation_date >='=>$dateFrom,'Reservation.reservation_date <='=>$dateTo,'Reservation.payment_type'=>1)));
			$cashTotal = $this->Reservation->find('all',array('fields' => array('sum(Reservation.reservation_price)   AS ctotal'),'conditions'=>array('Reservation.reservation_date >='=>$dateFrom,'Reservation.reservation_date <='=>$dateTo,'Reservation.payment_type'=>2)));
			/**
			 * Products
			 */
			
			$productsTotalResponse = $this->Saleproduct->find('all',array('fields' => array('Saleproduct.price,Saleproduct.quantity,Saleproduct.discount'),'conditions'=>array('Saleproduct.sale_date >='=>$dateFrom,'Saleproduct.sale_date <='=>$dateTo)));
			$productsTotal = 0;
			foreach( $productsTotalResponse as $productTotalResponse ){
				
				$priceNoDiscount = $productTotalResponse['Saleproduct']['price'] * $productTotalResponse['Saleproduct']['quantity'];
				$Discount = 0;
				if( $productTotalResponse['Saleproduct']['discount'] != 0 ){
					$Discount = ($productTotalResponse['Saleproduct']['price'] * $productTotalResponse['Saleproduct']['quantity']) * $productTotalResponse['Saleproduct']['discount'];
				}
				$productsTotal += $priceNoDiscount - $Discount;
			}
			
			$bankProductsResponse = $this->Saleproduct->find('all',array('fields' => array('Saleproduct.price,Saleproduct.quantity,Saleproduct.discount'),'conditions'=>array('Saleproduct.sale_date >='=>$dateFrom,'Saleproduct.sale_date <='=>$dateTo,'Saleproduct.payment_type'=>1)));
			$bankProduct = 0;
			foreach( $bankProductsResponse as $bankProductResponse ){
				
				$priceNoDiscount = $bankProductResponse['Saleproduct']['price'] * $bankProductResponse['Saleproduct']['quantity'];
				$Discount = 0;
				if( $bankProductResponse['Saleproduct']['discount'] != 0 ){
					$Discount = ($bankProductResponse['Saleproduct']['price'] * $bankProductResponse['Saleproduct']['quantity']) * $bankProductResponse['Saleproduct']['discount'];
				}
				$bankProduct += $priceNoDiscount - $Discount;
			}


			$cashProductsResponse = $this->Saleproduct->find('all',array('fields' => array('Saleproduct.price,Saleproduct.quantity,Saleproduct.discount'),'conditions'=>array('Saleproduct.sale_date >='=>$dateFrom,'Saleproduct.sale_date <='=>$dateTo,'Saleproduct.payment_type'=>2)));
			$cashProduct = 0;
			foreach( $cashProductsResponse as $cashProductResponse ){
				
				$priceNoDiscount = $cashProductResponse['Saleproduct']['price'] * $cashProductResponse['Saleproduct']['quantity'];
				$Discount = 0;
				if( $cashProductResponse['Saleproduct']['discount'] != 0 ){
					$Discount = ($cashProductResponse['Saleproduct']['price'] * $cashProductResponse['Saleproduct']['quantity']) * $cashProductResponse['Saleproduct']['discount'];
				}
				$cashProduct += $priceNoDiscount - $Discount;
			}
			/**
			 * Expenses
			 */
			$expensesTotal = $this->Expense->find('all',array('fields' => array('sum(Expense.expense_price)   AS ctotal'),'conditions'=>array('Expense.date_creation >='=>$dateFrom,'Expense.date_creation <='=>$dateTo)));
			$bankExpenses = $this->Expense->find('all',array('fields' => array('sum(Expense.expense_price)   AS ctotal'),'conditions'=>array('Expense.date_creation >='=>$dateFrom,'Expense.date_creation <='=>$dateTo,'Expense.payment_type'=>1)));
			$cashExpenses = $this->Expense->find('all',array('fields' => array('sum(Expense.expense_price)   AS ctotal'),'conditions'=>array('Expense.date_creation >='=>$dateFrom,'Expense.date_creation <='=>$dateTo,'Expense.payment_type'=>2)));
			
		$totalReservation = 0;	
		if($resevationsTotal[0][0]['ctotal'] != null){
			$totalReservation = $resevationsTotal[0][0]['ctotal'];
		}
		$this->set('resevationsTotal',$resevationsTotal);

		$totalReservationBank = 0;	
		if($bankTotal[0][0]['ctotal'] != null){
			$totalReservationBank = $bankTotal[0][0]['ctotal'];
		}
		$this->set('bankTotal',$bankTotal);

		$totalReservationCash = 0;	
		if($cashTotal[0][0]['ctotal'] != null){
			$totalReservationCash = $cashTotal[0][0]['ctotal'];
		}
		$this->set('cashTotal',$cashTotal);


		
		$this->set('productsTotal',$productsTotal);

		
		$totalProductBank = $bankProduct;
		
		$this->set('bankProduct',$bankProduct);

		$totalProductCash = $cashProduct;
		
		$this->set('cashProduct',$cashProduct);


		$totalExpenses = 0;	
		if($expensesTotal[0][0]['ctotal'] != null){
			$totalExpenses = $expensesTotal[0][0]['ctotal'];
		}
		$this->set('expensesTotal',$expensesTotal);

		$totalBankExpenses = 0;	
		if($bankExpenses[0][0]['ctotal'] != null){
			$totalBankExpenses = $bankExpenses[0][0]['ctotal'];
		}
		$this->set('bankExpenses',$bankExpenses);

		$totalCashExpenses = 0;	
		if($cashExpenses[0][0]['ctotal'] != null){
			$totalCashExpenses = $cashExpenses[0][0]['ctotal'];
		}
		$this->set('cashExpenses',$cashExpenses);
		
		$generaTotal = ( $totalReservation + $productsTotal ) - $totalExpenses;
		$this->set('generaTotal',$generaTotal);
		$cashGeneral = ( $totalReservationCash + $totalProductCash ) - $totalCashExpenses;
		$this->set('cashGeneral',$cashGeneral);

		$bankGeneral = ( $totalReservationBank	 + $totalProductBank ) - $totalBankExpenses;
		
		$this->set('bankGeneral',$bankGeneral);

		$dateFromFormat = $this->dateFormat($dateFrom);
		$this->set('dateFromFormat',$dateFromFormat);

		$dateToFormat = $this->dateFormat($dateTo);
		$this->set('dateToFormat',$dateToFormat);
	}


	public function dateFormat($date){
		$day  = date('w', strtotime($date));
		$days = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves','Viernes', 'Sábado');
		$year = date('Y', strtotime($date));
		$month = date('m', strtotime($date));
		$months = array('Enero', 'Febrero', 'Marzo', 'Abril','Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$currentDay = date('d', strtotime($date));
		$dayOfTheWeek = $days[$day];
		$dayFormat = $dayOfTheWeek.' '.$currentDay.' de '.$months[(int)$month-1].' del '.$year;
		return $dayFormat;
	}

	public function download() {
		$this->layout = 'ajax';
	}

	public function schedule($info){
		$this->layout = 'cron';
		$user = base64_decode($info);
		$infoUser = $user.'-'.'user';
		$this->set('client_id',$infoUser);
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
		
	}

	public function cancel($info){
		$this->layout = 'cron_cancel';
		$appointmentInfo = base64_decode($info);
		$appointment = explode('|',$appointmentInfo);
		
		$appointmentId = $appointment[0];
		$reservation_time = $appointment[1];
		$reservation_date = $appointment[2]; 
		$this->Reservation->id = $appointment[0];
		$data['Reservation']['reservation_status'] = 2;
		if($this->Reservation->save($data)){
			$activeReservationid = $this->getActiveReservationId($appointmentId);
			$this->Activereservation->id = $activeReservationid;
			$data['Activereservation']['reservation_status'] = 2;
			$this->Activereservation->save($data);
			//Guardar Notification
			$this->validate_cancel($appointmentId,$reservation_time,$reservation_date);
			Cache::clear();
		}
	}

	public function confirm($info){
		$this->layout = 'cron_confirm';
		$appointmentInfo = base64_decode($info);
		$appointment = explode('|',$appointmentInfo);
		$appointmentId = $appointment[0];
		$this->Reservation->id = $appointmentId;
		$data['Reservation']['reservation_status'] = 1;
		if($this->Reservation->save($data)){
			$activeReservationid = $this->getActiveReservationId($appointmentId);
			$this->Activereservation->id = $activeReservationid;
			$data['Activereservation']['reservation_status'] = 1;
			$this->Activereservation->save($data);
			Cache::clear();
		}
	}
  /**
   * $log = $this->Model->getDataSource()->getLog(false, false);
   * echo '<pre>';
   * var_dump($log);
   * die;		
   */
	public function products(){
		$this->checksession(5);
	}
	public function products_edit(){
		$this->checksession(5);
	}
	public function add_product()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			
		
			$this->Product->create();
			$data['Product']['name'] = $_POST['nameAdd'];
			$data['Product']['price'] = $_POST['priceAdd'];
			$data['Product']['provider'] = $_POST['sellerAdd'];
			$data['Product']['quantity'] = $_POST['countAdd'];
			$data['Product']['codigo_barra'] = $_POST['codigo_barra'];
			$data['Product']['creation_date'] = date('Y-m-d');
			if ($this->Product->save($data)) {
				
				sleep(2);
				$this->redirect(array('action' => '../products'));
			}
		}
	}

	public function search_product()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchUser = $_POST['searchProduct'];
		if( $_POST['search_producto'] == 1 ){
			$user = $this->Product->find('all', array(
				'fields' => array('Product.id', 'Product.name', 'Product.provider'),
				'conditions' => array('Product.name LIKE' => "%$searchUser%"),
				'recursive' => 2
			));
		}
		if( $_POST['search_producto'] == 2 ){
			$user = $this->Product->find('all', array(
				'fields' => array('Product.id', 'Product.name', 'Product.provider'),
				'conditions' => array('Product.codigo_barra ' => trim($searchUser)),
				'recursive' => 2
			));
		}
		$user = mb_convert_encoding($user, 'UTF-8', 'UTF-8');
		echo json_encode($user);
	}

	public function edit_product()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchProduct = $_POST['idProduct'];
		$product = $this->Product->find('first', array(
			'fields' => array('Product.id', 'Product.name', 'Product.price', 'Product.quantity', 'Product.provider'),
			'conditions' => array('Product.id' => $searchProduct),
			'recursive' => 2
		));
		$product = mb_convert_encoding($product, 'UTF-8', 'UTF-8');
		echo json_encode($product);
	}

	public function update_product()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Product->id = $_POST['idEdit'];
			$data['Product']['name'] = $_POST['nameEdit'];
			
			$data['Product']['price'] = $_POST['priceEdit'];
			$data['Product']['provider'] = $_POST['sellerEdit'];

			$data['Product']['quantity'] = $_POST['countEdit'] + $_POST['NewcountEdit'];
			

			if ($this->Product->save($data)) {
				sleep(3);
				$this->redirect(array('action' => '../products_edit'));
			}
		}
	}


	public function expenses()
	{
	}

	public function add_expenses()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$user = $_SESSION['User'];
			$this->Expense->create();
			$data['Expense']['expense_title'] = $_POST['nameAddExpense'];
			$data['Expense']['expense_price'] = $_POST['priceAddExpense'];
			$data['Expense']['user_id'] = $user['User']['id'];
			$data['Expense']['payment_type'] = $_POST['payAddExpense'];
			$data['Expense']['date_creation'] = date('Y-m-d');
			if ($this->Expense->save($data)) {
				sleep(3);
				$this->redirect(array('action' => '../expenses'));
			}
		}
	}


	public function search_expenses()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$expenseName = $_POST['searchProduct'];
		$user = $this->Expense->find('all', array(
			'fields' => array('Expense.id', 'Expense.expense_title', 'Expense.date_creation'),
			'conditions' => array('Expense.expense_title LIKE' => "%$expenseName%"),
			'recursive' => 2
		));
		$user = mb_convert_encoding($user, 'UTF-8', 'UTF-8');
		echo json_encode($user);
	}

	public function edit_expenses()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchProduct = $_POST['idProduct'];
		$product = $this->Expense->find('first', array(
			'fields' => array('Expense.id', 'Expense.expense_title', 'Expense.expense_price', 'Expense.payment_type', 'Expense.date_creation'),
			'conditions' => array('Expense.id' => $searchProduct),
			'recursive' => 2
		));
		$product = mb_convert_encoding($product, 'UTF-8', 'UTF-8');
		echo json_encode($product);
	}

	public function update_expenses()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Expense->id = $_POST['idEditExpense'];
			$data['Expense']['expense_title'] = $_POST['nameEditExpense'];
			$data['Expense']['expense_price'] = $_POST['priceEditExpense'];
			$data['Expense']['payment_type'] = $_POST['payEditExpense'];
			$data['Expense']['date_creation'] = $_POST['dateEditExpense'];


			if ($this->Expense->save($data)) {
				sleep(3);
				$this->redirect(array('action' => '../expenses'));
			}
		}
	}

	public function sales()
	{
		$products = array();
		$products = $this->Product->find('all');
		$this->set('products', $products);

		$sellers = array();
		$sellers = $this->User->find('all', array(
			'fields' => array('id', 'User.name'),
			'conditions' => array('User.type' => 2),
			'recursive' => 2
		));
		$this->set('sellers', $sellers);
	}

	public function add_sales()
	{
		$this->layout = 'ajax';
		if ($this->request->is('post')) {

			$client = explode('-', $_POST['clientSale']);
			$clientId = $client[0];
			$product = explode('-', $_POST['productSales']);
			$productId = $product[0];
			$seller = explode('-', $_POST['seller']);
			$sellerId = $seller[0];
			$this->Sale->create();

			$data['Sale']['client_id'] = $clientId;
			$data['Sale']['seller_id'] = $sellerId;
			$data['Sale']['creation_date'] = date('Y-m-d');
			if ($this->Sale->save($data)) {
				$this->Saleproduct->create();
				$saleId = $this->Sale->getLastInsertID();
				$datac['Saleproduct']['sales_id'] = $saleId;
				if (empty($_POST['dateAddSale'])) {
					$datac['Saleproduct']['sale_date'] = date('Y-m-d');
				} else {
					$datac['Saleproduct']['sale_date'] = $_POST['dateAddSale'];
				}
				$quantitySelected = $_POST['MaxCountAdd'];

				$stock = ($_POST['countAddAvaiableProduct']-$quantitySelected);

				$datac['Saleproduct']['product_id'] = $productId;
				$datac['Saleproduct']['price'] = $_POST['originalPriceAddSale'];
				if(empty($_POST['priceDiscount'])){
					$datac['Saleproduct']['discount'] = 0;
				}else{
					$discount = ($_POST['priceDiscount']/100);
					$datac['Saleproduct']['discount'] = $discount;
				}
				
				$datac['Saleproduct']['notes'] = $_POST['notesAddSale'];
				$datac['Saleproduct']['quantity'] = $quantitySelected;
				$datac['Saleproduct']['payment_type'] = $_POST['payAddSale'];
				$datac['Saleproduct']['date_creation'] = date('Y-m-d');

				$this->Product->id = $this->Product->field('id', array('id' => $productId));
				if ($this->Product->id) {
					$this->Product->saveField('quantity', $stock);
				}
				$this->Saleproduct->save($datac);
				sleep(3);
				$this->redirect(array('action' => '../sales'));
			}
		}
	}

	public function search_quantity()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$searchProduct = $_POST['idProduct'];
		$cantidad = $this->Product->find('first', array(
			'fields' => array('Product.id', 'Product.quantity', 'Product.price'),
			'conditions' => array('Product.id' => $searchProduct),
			'recursive' => 2
		));
		$cantidad = mb_convert_encoding($cantidad, 'UTF-8', 'UTF-8');
		echo json_encode($cantidad);
	}

	public function search_sales()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$dateSearch = $_POST['searchSales'];
		if( $dateSearch == '' ){
			$dateSearch = date('Y-m-d');
		}
		$sales = $this->Sale->find('all', array(
			'fields' => array('Sale.id','Sale.client_id','Sale.seller_id','Saleproduct.sales_id','Saleproduct.product_id','Saleproduct.sale_date',
			'User.name','Product.name'),
			'conditions' => array('Saleproduct.sale_date' => $dateSearch),
			'joins' =>
			array(
				array(
					'table' => 'saleproducts',
					'alias' => 'Saleproduct',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Sale.id = Saleproduct.sales_id')
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Sale.client_id = User.id')
				),
				array(
					'table' => 'products',
					'alias' => 'Product',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Saleproduct.product_id = Product.id')
				)
			),
			'recursive' => 2
		));
		$sales = mb_convert_encoding($sales, 'UTF-8', 'UTF-8');
		echo json_encode($sales);
	}

	public function edit_sales()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$idSearch = $_POST['idSale'];
		$sales = $this->Sale->find('first', array(
			'fields' => array('Sale.id','Sale.client_id','Sale.seller_id','Saleproduct.id','Saleproduct.sales_id','Saleproduct.product_id','Saleproduct.price',
			'Saleproduct.quantity','Saleproduct.payment_type','Saleproduct.sale_date','Saleproduct.notes','Saleproduct.discount','User.id','User.name','User.phone',
			'Product.name','Product.id','Product.provider','Product.quantity','Product.price','Seller.id','Seller.name'),
			'conditions' => array('Saleproduct.sales_id' => "$idSearch"),
			'joins' =>
			array(
				array(
					'table' => 'saleproducts',
					'alias' => 'Saleproduct',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Sale.id = Saleproduct.sales_id')
				),
				array(
					'table' => 'users',
					'alias' => 'Seller',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions'=> array('Sale.seller_id = Seller.id')
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Sale.client_id = User.id')
				),
				array(
					'table' => 'products',
					'alias' => 'Product',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('Saleproduct.product_id = Product.id')
				)
			),
			'recursive' => -1
		));
		$sales = mb_convert_encoding($sales, 'UTF-8', 'UTF-8');
		echo json_encode($sales);
	}

	public function update_sales()
	{
		
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Sale->id = $_POST['idSaleEdit'];
			$client = explode('-', $_POST['clientSaleEdit']);
			$clientId = $client[0];
			$product = explode('-', $_POST['productSalesEdit']);
			$productId = $product[0];
			$seller = explode('-', $_POST['sellerEdit']);
			$sellerId = $seller[0];
			//$this->Sale->create();
			$data['Sale']['client_id'] = $clientId;
			$data['Sale']['seller_id'] = $sellerId;
			$data['Sale']['creation_date'] = date('Y-m-d');
			if ($this->Sale->save($data)) {
				echo "entro2";
				$this->Saleproduct->id = $_POST['idSaleProductEdit'];
				//$this->Saleproduct->create();
				//$saleId = $this->Sale->getLastInsertID();
				$datac['Saleproduct']['sales_id'] = $_POST['idSaleEdit'];
				if (empty($_POST['dateAddSaleEdit'])) {
					$datac['Saleproduct']['sale_date'] = date('Y-m-d');
				} else {
					$datac['Saleproduct']['sale_date'] = $_POST['dateAddSaleEdit'];
				}
				$quantitySelected = $_POST['MaxCountAddEdit'];

				$stock = ($_POST['idSaleCantEdit']-$quantitySelected);

				$datac['Saleproduct']['product_id'] = $productId;
				$datac['Saleproduct']['price'] = $_POST['originalPriceAddSaleEdit'];
				echo "entro3";
				if(empty($_POST['priceDiscountEdit'])){
					$datac['Saleproduct']['discount'] = 0;
				}else{
					$discount = ($_POST['priceDiscountEdit']/100);
					$datac['Saleproduct']['discount'] = $discount;
				}
				
				$datac['Saleproduct']['notes'] = $_POST['notesAddSaleEdit'];
				$datac['Saleproduct']['quantity'] = $quantitySelected;
				$datac['Saleproduct']['payment_type'] = $_POST['payAddSaleEdit'];
				$datac['Saleproduct']['date_creation'] = date('Y-m-d');

				$this->Product->id = $this->Product->field('id', array('id' => $productId));
				echo "entro4";
				if ($this->Product->id) {
					$this->Product->saveField('quantity', $stock);
				}
				echo "entro5";
				$this->Saleproduct->save($datac);
				sleep(3);
				$this->redirect(array('action' => '../sales'));
			}
		}
	}

	public function saleproducts()
	{
	}

	public function check_barcode()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$barCode = $_POST['barcode'];
		$barCodes = $this->Product->find('first',array('conditions'=>array('Product.codigo_barra'=>$barCode)));
		if(empty($barCodes)){
			return false;
		}
		return true;
		
	}

	function profile_save()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		if ($this->request->is('post')) {
			//Initialize
			$nombreUsuario = $_POST['usuario_perfil'];
			$celular = $_POST['telefono_perfil'];
			$userId = $_POST['id_perfil'];
			$userContrasena = $_POST['contrasena_perfil'];
			//Save user
			$this->User->id = $userId;
			$data['User']['name'] = $nombreUsuario;
			$data['User']['phone'] = $celular;
			if ($userContrasena != '') {
				$pass = $this->Encrypt->encrypt($userContrasena);
				$data['User']['password'] = $pass;
			}

			if ($this->User->save($data)) {
				sleep(5);
				$this->redirect(array('action' => '../'));
			} 
		}
	}

	/**
	 * Run onces a day
	 */

	 public function notification_register(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$ch = curl_init();
		$token = "EAAZAeI4i9EJ8BOwPXWyIBLkuOHIpMAU0IwFqIeiX0aEr5zBQoNergR3WbZBk2zauyM7GosrbshJj6ZAytEktxTh88sJCRVZA9NY5RnDl4PM0yMdNXLh0ZBoL6YjT67EnbNBzunF2ew0kcOh2XvZCD7EDoZArydz9QHIrGnRhGLsOjoD6Vip08DrLZBZAnnaT1MnDHilqMkNYAG0VgZAeZCYVjWpyosqQdIZD";
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v17.0/136967432828861/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $token
		));
		curl_setopt($ch, CURLOPT_POST, 1);


		$registers = $this->Sendpassword->find('all',array('fields'=>array('User.id,User.phone'),
												   'conditions'=> array('Sendpassword.status_password'=>0),
												    'joins' => array(
																	array(
																		'table' => 'users',
																		'alias' => 'User',
																		'type' => 'inner',
																		'foreignKey' => false,
																		'conditions'=> array('User.id = Sendpassword.id_user'),
																		)
																	)
												   ));
		
		foreach( $registers as $register ){
			
			//$phone = $register["User"]["phone"];
			$info = base64_encode($register["User"]["id"]);
			$phone = '83481182';
			$data = array();
			$data = array(
				'messaging_product' => 'whatsapp',
				'to' => '506'.$phone,
				'type' => 'template',
				'template' => array(
						'name' => 'change_password',
						 'language' => array( 'code' => 'es_MX'),
						 'components' =>array(
												array(
													'type'=>'header',
													'parameters'=> array(
														array(
															'type'=> 'image',
															'image' => array(
																'link' => 'https://eibyz.com/app/webroot/barberiaimg/alofresa.jpeg'
															)
														)
													)
												),
												array(
													'type'=>'button',
													"index"=> "0",
													"sub_type"=> "url",
														'parameters'=> array(
															array(
															'type'=>'text',
															'text'=> $info
														)
													)
												),
											)
						)
			);
			$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			var_dump($server_output);
			curl_close($ch);
			
		}
	}

	public function register($idUser){
		$this->layout = 'cron_register';
		//http://localhost/barberia/barber/register/NDY=
		$userId = base64_encode($idUser);
		$this->set('userId',$userId);
	}
	
	public function save_password(){
		$this->layout = 'cron_register';
		$this->autoRender = false;
		if ($this->request->is('post')) {
			//Initialize
			
			$userId = base64_decode(base64_decode($_POST['idUser']));
			$userContrasena = $_POST['passwordregister'];
			//Save user
			$this->User->id = $userId;
			if ($userContrasena != '') {
				$pass = $this->Encrypt->encrypt($userContrasena);
				$data['User']['password'] = $pass;
			}

			if ($this->User->save($data)) {
				sleep(5);
				$this->redirect(array('action' => '../'));
			} 
		}
	}
	
	public function searchProduct_barcode()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$barCodes = $_POST['barcode'];
		$barcode = $this->Product->find('all', array(
			'fields' => array('Product.id', 'Product.name', 'Product.price','Product.provider','Product.quantity'),
			'conditions' => array('Product.codigo_barra'=>$barCodes),
			'recursive' => 2
		));
		echo json_encode($barcode);
	}

	public function sales_edit(){
		$products = array();
		$products = $this->Product->find('all');
		$this->set('products', $products);

		$sellers = array();
		$sellers = $this->User->find('all', array(
			'fields' => array('id', 'User.name'),
			'conditions' => array('User.type' => 2),
			'recursive' => 2
		));
		$this->set('sellers', $sellers);
	}
}
