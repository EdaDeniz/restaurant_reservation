<?php

class App {


/*
*   Back-end of our Celikler Sys ♥
*/
    protected $controller = 'Home';

    protected $method = 'index';

    protected $prams = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (isset($url[0]) && !empty($url[0])) {// If the first one is present, it //will not be empty
            if (file_exists("../app/controllers/{$url[0]}.php")) { 
                $this->controller = $url[0];
                unset($url[0]); 
            } else {
                $this->method = 'error';
            }
        }

        require_once "../app/controllers/{$this->controller}.php";

        $this->controller = new $this->controller; 

        if (isset($url[1]) && method_exists($this->controller, $url[1])) { // If the second box is present and the method is available
            $this->method = $url[1];
            unset($url[1]); 
        }

        $this->params = $url ? array_values($url) : []; 
                call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl() {
        if (isset($_GET['url'])) { 
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    //Tab, user etc I get it from database
    //Ender hoca alert!
    
    public static function allowedPages($id){
        $DB = Database::getObject();
        $sql = "SELECT `tab`.`file_name`
                FROM `tab` JOIN `user_access`
                ON `tab`.`id` = `user_access`.`tab_id`
                JOIN `user_types`
                ON `user_types`.`id` = `user_access`.`type_id`
                WHERE `user_types`.`id` = (select `user`.`user_type_id` FROM `user` where `user`.`id` = $id)
                ORDER BY `tab`.`id`";
        $result = $DB->execute($sql);
        $pages = [];
        foreach ($result as $value) {
            $pages[] = $value['file_name'];
        }
        return $pages;
    }
    public static function getUserType($id){
        $DB = Database::getObject();
        $sql = "select `user_types`.`type`
                FROM `user_types` JOIN `user` ON `user_types`.`id` = `user`.`user_type_id`
                WHERE `user`.`id` = '$id'";
        $result = $DB->execute($sql);
        $type = mysqli_fetch_array($result)[0];
        if ($type == "user"){
            $type = 0;
        }else if ($type == "guest" || $type == NULL){
            $type = 2;
        }else {
            $type = 1;
        }
        return $type;
    }
}
