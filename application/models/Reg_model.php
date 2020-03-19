<?php
class Reg_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}
	/**
	 * Записывает нового пользователя в БД
	 * после регистрации 
	 */
	public function setUser($array)
	{
		//TODO: Добавить проверку на спецсимволы
		$user_login = $array['regUsername'];
        $email = $array['regEmail'];
        $mphone = $array['regTel'];
		$user_pass =  md5($array['regPassword']);
        $sql = "INSERT INTO users (user_login, email, mphone, user_pass ) 
                VALUES  ('$user_login', '$email', '$mphone','$user_pass')";
		$this->db->query($sql);
	}
	
	public function printArr($array)
	{
		echo "<pre>" . print_r($array, true) . "</pre>";
	}
}


?>