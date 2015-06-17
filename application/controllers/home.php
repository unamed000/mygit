<?php
/**
 * Created by PhpStorm.
 * User: gento
 * Date: 16/5/2015
 * Time: 1:31 PM
 */
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSDKException;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;

class Home extends MY_Controller{

    function index(){
        $this->page('home');
    }

}