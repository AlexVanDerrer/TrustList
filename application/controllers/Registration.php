<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('reg_model');
	}
	
	
	public function index()
	{ 
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('regUsername', 'Username', 'callback_username_check');
		$this->form_validation->set_rules('regEmail', 'Email', 'trim|required|valid_email', 
				array('required' => 'Поле Email должно быть заполнено'));
		$this->form_validation->set_rules('regTel', 'Phone', 'trim|required|min_length[5]|max_length[12]',
				array('required' => 'Поле Телефон должно быть заполнено',
					'min_length' => 'Номер телефона не может быть менее 5 символов',
					'max_length' => 'Номер телефона не может быть более 14 символов'));
		$this->form_validation->set_rules('regPassword', 'Password', 'trim|required|min_length[8]',
				array('required' => 'Поле Пароль должно быть заполнено',
					'min_length' => 'Ваш пароль должен быть не менее 8 символов'));
		$this->form_validation->set_rules('regPasswordConf', 'Password Confirmation', 'trim|required|matches[regPassword]',
				array('required' => 'Поле Подтверждение пароля должно быть заполнено',
					'matches' => 'Пароли не совпадают'));
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('head_view');
			$this->load->view('reg_view');
			$this->load->view('footer');
		}
		else
		{
			//если валидация прошла успешно, пользователь заносится в базу
			//и получается его id из базы
			$this->reg_model->setUser($this->input->post());

			if ($this->input->post('reg'))
			{
				
				$data = [
					"user_login" => $this->input->post('regUsername'),
					"user_pass" => $this->input->post('regPassword')
				];
			}
			else 
			{
				 $data['error'] = 'error no post';
			}
			
			//TODO: отправить сообщение на почту
			$this->load->view('head_view');
			$this->load->view('formsuccess', $data);
			$this->load->view('footer');
		}
	}
	/**
	 * Проверка поля UserName 
	 */
	public function username_check($str)
	{
		$sql = "SELECT * FROM users WHERE user_login = '$str'";
		$check_user = $this->db->query($sql);
		$row_cnt = $check_user->num_rows();
		if($row_cnt > 0)
		{
			$this->form_validation->set_message('username_check', "Логин $str уже занят");
			return FALSE;
		} 
		else 
		{
			switch ($str) 
			{
				case 'test':
					$this->form_validation->set_message('username_check', 'Ваш {field} не может быть "test"');
					return FALSE;
					break;
				case 'user':
					$this->form_validation->set_message('username_check', 'Ваш {field} не может быть "user"');
					return FALSE;
					break;
				case 'admin':
					$this->form_validation->set_message('username_check', 'Ваш {field} не может быть "admin"');
					return FALSE;
					break;
	
				default:
					return TRUE;
					break;
			}
		}	
	}
}