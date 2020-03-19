<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}
	
    public function index()
	{
		$this->load->library('session');
		//проверка на авторизацию
		if($this->session->user['auth'] && isset($this->session->user['user_id'])){

			// получаем данные пользователя и его контакты и передаем в вид	
			$user = $this->home_model->get_user_data($this->session->user['user_id']);
			$contacts = $this->home_model->get_contacts_by_user_id($this->session->user['user_id']);
			$contacts_vk = $this->home_model->get_contacts_vk($this->session->user['user_id']);
			$count = count($contacts); // общее количество контактов
			$count_vk = count($contacts_vk); //количество контактов из ВК
			$rec = $this->home_model->get_all_recomendations(); // рекомендации и рекламные контакты
			$data = [
						"user" => $user, // данные пользователя
						"count" => $count,
						"contacts" => $contacts, //массив контактов из БД
						"count_vk" => $count_vk, //массив контактов из БД
						"recomendations" => $rec,
						'column' => $column, 
						'direction' => $this->session->direction,
						'search_arr' => $res_search
					];

			$this->load->view('head_view');
			$this->load->view('user_view', $data);
			$this->load->view('footer');
				
		}
		// если нет авторизации показываем стартовую страницу
		else
		{
			$this->load->view('head_view');
			$this->load->view('home_view');
			$this->load->view('footer');
		}	
			
	}	
}		
        
	
                
        
	


