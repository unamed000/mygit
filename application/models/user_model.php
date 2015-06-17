<?php
/**
 * Created by PhpStorm.
 * User: gento
 * Date: 22/5/2015
 * Time: 2:02 PM
 */

class User_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->table = 'user';
        $this->table_type = 'main';
    }

}