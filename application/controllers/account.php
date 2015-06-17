<?php
/**
 * Created by PhpStorm.
 * User: gento
 * Date: 16/5/2015
 * Time: 1:31 PM
 */

class Account extends MY_Controller{

    function index(){

    }

    function register(){
        $this->load->library('form_validation');
        $this->load->helper('form');
        $config = array(
            array(
                'field'   => 'username',
                'label'   => 'Username',
                'rules'   => 'required|is_unique[user.username]|min_length[5]|max_length[12]'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'required|min_length[5]|max_length[12]|matches[cpassword]|md5'
            ),
            array(
                'field'   => 'cpassword',
                'label'   => 'Confirm Password',
                'rules'   => 'required|min_length[5]|max_length[12]|md5'
            ),
            array(
                'field'   => 'email',
                'label'   => 'Email',
                'rules'   => 'required|valid_email|is_unique[user.email]'
            )
        );
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() != FALSE)
        {
            $this->load->model('user_model','user');
            $this->user->save(array(
                'username' => $this->input->post('username'),
                'email'    => $this->input->post('email'),
                'password' => $this->input->post('password')
            ));
            return $this->return_content(REQUEST_SUCCESS,'Congratulation, you have successfully sign up!');
        }
        else
        {
            throw new Exception(validation_errors());
        }
    }

}