<?php
class Auth_Vk {

    private $code;
    private $token;
    private $uid;

    public function __construct ()
    {
        require 'config.php';
    }

    /** Присвоить значение свойству $code */
    public function set_code ($code)
    {
        $this->code = $code;
    }

    /** Присвоить значение свойству $token */
    public function set_token ($token)
    {
        $this->token = $token;
    }

    /** Присвоить значение свойству $uid */
    public function set_uid ($uid)
    {
        $this->uid = $uid;
    }

    /** Метод редиректа */
    public function redirect ($utl)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:".$utl);
        exit();
    }
    
    /** Метод получение токена ВК */
    public function get_token()
    {
        if (!$this->code)
        { 
            exit('неверный код');
        }
        $ku = curl_init();
        $query = 'client_id='. APP_ID.'&client_secret='. APP_SECRET .'&code='.$this->code.'&redirect_uri='. REDIRECT_URI;
        curl_setopt($ku, CURLOPT_URL, URL_ACCESS_TOKEN.'?'.$query);
        curl_setopt($ku, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ku);
        curl_close($ku);

        $ob = json_decode($result);

        if ($ob->access_token)
        {
            $this->set_token($ob->access_token);
            $this->set_uid($ob->user_id);
            return true;
        }
        elseif ($ob->error)
        {
            $_SESSION['error'] = "error";
            return false;
        }
    }

    public function get_user()
    {
        if(!$this->token)
        {
            exit("Wrong code");
        }
        if(!$this->uid)
        {
            exit("Wrong code");
        }
        
        $fields = 'first_name,last_name,bdate,city,country,photo,photo_medium';

        //$query = 'uids='.$this->uid.'$fields='.$fields.'first_name,last_name,bdate,city,country,photo,photo_medium''&access_token='.$this->token.'&v=5.103';
        $kur = curl_init();
        curl_setopt($kur, CURLOPT_URL, URL_GET_USER.'?'.$query);
        curl_setopt($kur, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($kur, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($kur, CURLOPT_RETURNTRANSFER, true);

        $result2 = curl_exec($kur);
        $_SESSION['user'] = json_decode($result2);

        $this->redirect("http://cu26250.tmweb.ru");


    }

}



?>