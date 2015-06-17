<?php
/**
 * Created by PhpStorm.
 * User: gento
 * Date: 16/5/2015
 * Time: 2:15 PM
 */


class MY_Controller extends CI_Controller{

    var $pageName = '';

    function page($content_name = '', $var = '', $return = false){
        $head = $this->load->view('head',$var,true);
        $header = $this->load->view('header',$var,true);
        $content = $this->load->view('content/'.$content_name,$var,true);
        $footer = $this->load->view('footer',$var,true);
        $navigation = $this->load->view('navigation',$var,true);

        $this->load->view('page',array('head' => $head, 'content' => $content, 'header' => $header, 'footer' => $footer, 'navigation' => $navigation),$return);

    }

    public function _remap($method,$params = array())
    {
        if (!method_exists($this, $method)){
            show_404();
        }
        if($this->is_ajax_request()) {
            try{
                call_user_func_array(array($this, $method), $params);
            }catch(Exception $e){
                $this->return_content(REQUEST_FAIL,$e->getMessage());
            }
        }else{
            try{
                call_user_func_array(array($this, $method), $params);
            }catch(Exception $e){
                echo $e->getMessage();
            }

        }
    }

    function return_content($status, $msg = "", $data = "", $is_ret = false){
        if($this->is_ajax_request() && !$is_ret){
            echo json_encode(array(
                "status" => $status,
                "message" => $msg,
                "data" => $data
            ));
        }
        return array(
            "status" => $status,
            "message" => $msg,
            "data" => $data
        );
    }

    function is_ajax_request(){
        return $this->input->post('is_ajax');
    }

}