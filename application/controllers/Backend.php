<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {

  
  	public function __construct()
	{
    parent::__construct();
    $this->load->database();
    // $this->load->model('backend_model');
    
	}

    /**
	 * Авторизация пользователя через ВК
	 */
	public function auth_user_vk()
	{
      	$this->load->library('session');
		// TODO: заменить $_POST на ОО метод post()
		$user_uid = $this->input->post('user_id');
        $fname = $this->input->post('fname');
        $lname = ($_POST['lname']);
        $mphone = ($_POST['mphone']);
        $hphone = ($_POST['hphone']);
        $photo_url = ($_POST['photo_url']);
        $email = ($_POST['email']);
        $href = ($_POST['href']);
        $domain = ($_POST['domain']);

		// 1 есть ли такой пользователь в базе
		$query_check_user = "SELECT vk_uid FROM users WHERE vk_uid = $user_uid";
		$res = $this->db->query($query_check_user);
		$row = $res->row();
		// 2 если нет, записать в базу
		if (!$row) {
			$sql = "INSERT INTO users (vk_uid, fname, lname,  mphone, hphone, photo_url, email, href, domain ) 
			VALUES  ($user_uid,'$fname','$lname','$mphone','$hphone','$photo_url','$email','$href','$domain')";
			$this->db->query($sql);
		}
		// 3 если есть, проверить на авторизацию
		$user_auth = $this->authOpenAPIMember();
		// 4 записать данные в сессию  
		if ($user_auth) {
			$query = $this->db->query("SELECT id FROM users WHERE vk_uid = $user_uid");
			$user_id = $query->row_array();
			$this->session->user = 
			[
				"user_id" => (int)$user_id['id'],
				"auth" => true,

			];
			$response = ["status" => true, "message" => "auth vk ok"];
			echo json_encode($response);
        } else {
		  $this->session->user = 
		  [
            "auth" => false
		  ];
		  $response = ["status" => false, "message" => "Не авторизован"];
		  echo json_encode($response);
        }

	}
	
	/**
	 * Проверка авторизации через ВК
	 *  */ 
	public function authOpenAPIMember() 
	{
		$session = array();
		$member = FALSE;
		$valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
		$app_cookie = $_COOKIE['vk_app_'.$this->config->item('app_id')];
		if ($app_cookie) {
			$session_data = explode ('&', $app_cookie, 10);
			foreach ($session_data as $pair) {
				list($key, $value) = explode('=', $pair, 2);
				if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
					continue;
				}
				$session[$key] = $value;
			}
			foreach ($valid_keys as $key) {
				if (!isset($session[$key])) return $member;
			}
			ksort($session);
		
			$sign = '';
			foreach ($session as $key => $value) {
				if ($key != 'sig') {
					$sign .= ($key.'='.$value);
				}
			}
			$sign .= $this->config->item('app_secret');
			$sign = md5($sign);
			if ($session['sig'] == $sign && $session['expire'] > time()) {
				$member = array(
					'id' => intval($session['mid']),
					'secret' => $session['secret'],
					'sid' => $session['sid']
				);
			}
		}
		return $member;
	}
	/**
	 * Авторизация зарегистрированного пользователя
	 *  
	 */ 
	public function auth_user()
	{
		$this->load->library('session');
		$user_id = $this->input->post('user_id');
		$login = $this->input->post('login');
		$password = md5($this->input->post('password')); 
		$sql = "SELECT * FROM users WHERE user_login = '$login' AND user_pass = '$password'";
		$check_user = $this->db->query($sql);
		$row_cnt = $check_user->num_rows();
		if ($row_cnt > 0) {
			$user = $check_user->result_array()[0];
			$this->session->user = 
			[
				"user_id" => $user['id'],
				"auth" => true
			];
			$response = ["status" => true];
			echo json_encode($response);
		} else {
			$response = ["status" => false, "message" => "Не верный логин или пароль"];
			echo json_encode($response);
		}
	}

	/**
	 * 
	 */
	public function get_user_friends()
	{
		$this->load->library('session');
		$user_uid = $this->input->post('user_uid');
		$friends = $this->input->post('friends');

		//получаем id  пользователя в БД
		$q1 = "SELECT id FROM users WHERE vk_uid = $user_uid";
		$query = $this->db->query($q1);
		$user_id = $query->row();
		// проходим циклом по массиву друзей
		$response = [];

		foreach ($friends as $friend) {
			$fid = $friend['id'];
			$fname = $friend['first_name'];
			$lname = $friend['last_name'];
			$mphone = (!empty($friend['mobile_phone'])) ? $friend['mobile_phone'] : 'Не указан';
			$hphone =  (!empty($friend['home_phone'])) ? $friend['home_phone'] : 'Не указан';
			$photo_url = $friend['photo_100'];
			$email = (isset($friend['email'])) ? $friend['email'] : '@ Не указан';
			$href = 'https://vk.com/'.$friend['domain'];
			$domain = $friend['domain'];
			$country = (isset($friend['country']['title'])) ? $friend['country']['title']  : 'Не указано';
			$city = (isset($friend['city']['title'])) ? $friend['city']['title']  : 'Не указано';
			if (isset($friend['sex'])) {
				if ($friend['sex'] == 2) { $sex = 'Муж'; } 
				elseif ($friend['sex'] == 1) { $sex = 'Жен'; }
				else { $sex = 'Не указан';}
			} 
			if (isset($friend['career'])) {
				$last_scope = end($friend['career']);
				if (isset($last_scope['group_id'])) {
					$scope = $last_scope['group_id'];
				} elseif (isset($last_scope['company'])) {
					$scope = $last_scope['company'];
				} else {
					$scope = 'Не указано';
				}
				
				if (isset($last_scope['position'])) {
					$position = $last_scope['position'];
				} else {
					$position = 'Не указано';
				}
			} else {
				$scope = 'Не указано';
				$position = 'Не указано';
			}
			// настройки приватности профиля друга
			if ($friend['is_closed']) { $profile_is_closed = 'Открытый профиль'; }
			else { $profile_is_closed = 'Закрытый профиль'; }

			$check_sql = "SELECT * FROM contacts WHERE vk_uid = $fid AND parent = $user_id->id";
			$result = $this->db->query($check_sql);
			$rows = $result->num_rows();

			if ($rows > 0) {
				$response[$fid] = ["status" => true, "message" => "Пользователь уже добавлен ранее"];
			} else {
				$sql = "INSERT INTO contacts (vk_uid, fname, lname,  mphone, hphone, photo_url, email, href, domain, country, city, scope, position, sex, profile_is_closed, parent ) 
						VALUES  ($fid,'$fname','$lname','$mphone','$hphone','$photo_url','$email','$href','$domain', '$country', '$city', '$scope', '$position', '$sex', '$profile_is_closed', $user_id->id)";
				$res = $this->db->query($sql);
				if ($res) {
					$response[$fid] = ["status" => true, "message" => "Пользователь  добавлен "];
				} else {
					$response[$fid] = ["status" => false, "message" => "Ошибка"];	
				}
			}
			unset($fid, $fname, $lname, $mphone, $hphone, $photo_url, $email, $href, $domain, $country, $city, $scope, $position, $sex);
		};
		echo json_encode($response);
	}

	/**
	 * Выход 
	 */
	public function ses_destroy()
	{
		$this->load->library('session');
		$this->session->unset_userdata('user');
		if (!$this->session->user['auth']) {
			$response = ["status" => true, "message" => "session destroy"];
			echo json_encode($response);
		} else {
			$response = ["status" => false, "message" => "error destroy"];
			echo json_encode($response);
		}
	}

	/**
	 * Добавление нового контакта пользователем
	 */
	public function add_new_user()
	{
		$result = 'Файл не был успешно загружен на сервер';
		$id = $this->input->post('id');
		$fname = $this->db->escape_str($this->input->post('fname'));
		$lname = $this->db->escape_str($this->input->post('lname'));
		$mphone = $this->db->escape_str($this->input->post('mphone'));
		$scope = $this->db->escape_str($this->input->post('scope'));
		$position = $this->db->escape_str($this->input->post('position'));
		$href = $this->db->escape_str($this->input->post('href'));
		$photo_url = '';
		$city = $this->db->escape_str($this->input->post('city'));

		// TODO: поставить ограничение на загружаемый файл по размеру и расширению
		if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
			$new_file_name = 'trustlist_'.date("YmdHis").'_'.$_FILES['image']['name'];
			$photo_url = './upload/'.$new_file_name;
			if (move_uploaded_file($_FILES['image']['tmp_name'], $photo_url)) {
				$result = 'Файл загружен';	
			} else {
				$result = "Произошла обшибка при загрузке файла на сервер";
				$photo_url = '';
			}
		}
		$sql = "INSERT INTO contacts (fname, lname,  mphone, scope, photo_url, href, position, city, parent ) 
				VALUES  ('$fname','$lname','$mphone','$scope','$photo_url','$href','$position','$city', $id)";
		$res = $this->db->query($sql); 
		
		if($res) {
			$response = ["status" => true, "message" => "Пользователь успешно добавлен!", 'image' => $result];
			echo json_encode($response);
		} else {
			$response = ["status" => false, "message" => "Ошибка", 'image' => $result];
			echo json_encode($response);
		}
	}

	public function del_contact_from_list()
	{
		$contact_id = $this->input->post('contact_id');
		$sql = "UPDATE `contacts` SET `is_show`= 0 WHERE id=$contact_id";
		$res = $this->db->query($sql);
		if($res) 
		{
			$response = ["status" => true, "message" => "Контакт удален из Вашего списка!"];
			echo json_encode($response);
		} 
		else 
		{
			$response = ["status" => false, "message" => "Ошибка удаления контакта!"];
			echo json_encode($response);
		}

	}

	public function add_comment_contact()
	{
		$contact_id = $this->input->post('id');
		$text = $this->db->escape_str($this->input->post('comment')); 
		$sql = "UPDATE `contacts` SET `comment`= '$text' WHERE id=$contact_id";
		$res = $this->db->query($sql);
		if($res) {
			$response = ["status" => true, "message" => "Комментарий добавлен!"];
			echo json_encode($response);
		} else {
			$response = ["status" => false, "message" => "Ошибка! Комментарий некорректен!"];
			echo json_encode($response);
		}
	}

	public function edit_contact()
	{
		$response = []; 
		$id = $this->input->post('id');
		// TODO: !!!!!!! DRY !!!!!!!!
		if ($this->input->post('fname') != "") {
			$fname = $this->db->escape_str($this->input->post('fname'));
			$res = $this->db->query("UPDATE `contacts` SET `fname`= '$fname' WHERE id=$id");
			($res) ? array_push($response, ["fname" => true]) : array_push($response, ["fname" => true]);
		}
		if ($this->input->post('lname') != "") {
			$lname = $this->db->escape_str($this->input->post('lname'));
			$res = $this->db->query("UPDATE `contacts` SET `lname`= '$lname' WHERE id=$id");
			($res) ? array_push($response, ["lname" => true]) : array_push($response, ["lname" => true]);
		}
		if ($this->input->post('mphone') != "") {
			$mphone = $this->db->escape_str($this->input->post('mphone'));
			$res = $this->db->query("UPDATE `contacts` SET `mphone`= '$mphone' WHERE id=$id");
			($res) ? array_push($response, ["mphone" => true]) : array_push($response, ["mphone" => true]);
		}
		if ($this->input->post('email') != "") {
			$email = $this->db->escape_str($this->input->post('email'));
			$res = $this->db->query("UPDATE `contacts` SET `email`= '$email' WHERE id=$id");
			($res) ? array_push($response, ["email" => true]) : array_push($response, ["email" => true]);
		}
		if ($this->input->post('scope') != "") {
			$scope = $this->db->escape_str($this->input->post('scope'));
			$res = $this->db->query("UPDATE `contacts` SET `scope`= '$scope' WHERE id=$id");
			($res) ? array_push($response, ["scope" => true]) : array_push($response, ["scope" => true]);
		}
		if ($this->input->post('position') != "") {
			$position = $this->db->escape_str($this->input->post('position'));
			$res = $this->db->query("UPDATE `contacts` SET `position`= '$position' WHERE id=$id");
			($res) ? array_push($response, ["position" => true]) : array_push($response, ["position" => true]);
		}
		if ($this->input->post('href') != "") {
			$href = $this->db->escape_str($this->input->post('href'));
			$res = $this->db->query("UPDATE `contacts` SET `href`= '$href' WHERE id=$id");
			($res) ? array_push($response, ["href" => true]) : array_push($response, ["href" => true]);
		}
		if ($this->input->post('city') != "") {
			$city = $this->db->escape_str($this->input->post('city'));
			$res = $this->db->query("UPDATE `contacts` SET `city`= '$city' WHERE id=$id");
			($res) ? array_push($response, ["city" => true]) : array_push($response, ["city" => true]);
		}
		if (in_array(false, $response)) {
			$response = ["status" => false, "message" => "Ошибка"];
			echo json_encode($response);
		} else {
			$response = ["status" => true, "message" => "Данные пользователя обновлены!"];
			echo json_encode($response);
		}	


	}

	/**
	 * Живой поиск
	 */
	public function ajax_search()
	{
		if (!empty($this->input->post('search'))) {

			$search = $this->db->escape_str($this->input->post('search'));
			$res = $this->db->query("SELECT * FROM `contacts` WHERE `fname` LIKE '{$search}%' ORDER BY `name`");
			$result = $res->result_array();
			if ($result) { // TODO: подключить вид
				?>
				<div class="search_result">
					<table>
						<?php foreach ($result as $row) : ?>
						<tr>
							<td class="search_result-name">
								<a href="#"><?php echo $row['fname']; ?></a>
							</td>
							<td class="search_result-btn">
								<a href="#">Перейти</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php
			}
		}
	}

	// вывода массива в читаемом виде 
	public function printArr($array)
	{
		echo "<pre>" . print_r($array, true) . "</pre>";
	}
    
} // end class