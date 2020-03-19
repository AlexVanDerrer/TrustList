<?php
class Home_model extends CI_Model 
{
	public function __construct() 
	{
        parent::__construct();
        $this->load->database();
    }

  
    public function get_contacts_by_user_id(int $id = null)
    {
        $contacts = [];
        if ($id != null)
        {
            $contacts = $this->db->query("SELECT * FROM contacts WHERE parent = $id AND is_show > 0");
            return $contacts->result_array();
        }  
        else
        {
            $contacts = 
            [
                '0' => ['fname' => 'null', 'lname' => 'null'],
            ]; 
            return $contacts;
        }
    }

    public function get_user_data(int $id = null)
    {
        if ($id != null) 
        { 
            //TODO: добавить проверку, если пользователь не найден
            $sql = "SELECT * FROM users WHERE id = $id";
            $res = $this->db->query($sql);
            $user = $res->row_array();
            return $user;
        }
        else
        {
            $user = ["error" => "user_id is null"];
            return $user;
        }
    }

    public function get_contacts_vk(int $id=null){
        $contacts = [];
        if ($id != null)
        {
            $contacts = $this->db->query("SELECT * FROM contacts WHERE parent = $id AND is_show > 0 AND vk_uid IS NOT NULL ORDER BY fname");
            return $contacts->result_array();
        }  
        else
        {
            $contacts = 
            [
                '0' => ['fname' => 'null', 'lname' => 'null'],
            ]; 
            return $contacts;
        }
    }

    public function get_all_recomendations()
    {
        $contacts = $this->db->query("SELECT * FROM recomendations");
        return $contacts->result_array();
    }

	public function printArr($array)
	{
		echo "<pre>" . print_r($array, true) . "</pre>";
	}
}