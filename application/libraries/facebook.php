<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Autoload the required files
require_once(APPPATH . 'libraries/facebook/src/autoload.php');

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;


class Facebook
{
    var $ci;
    var $helper;
    var $session;
    var $permissions;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->permissions = $this->ci->config->item('permissions', 'facebook');

        // Initialize the SDK
        FacebookSession::setDefaultApplication($this->ci->config->item('api_id', 'facebook'), $this->ci->config->item('app_secret', 'facebook'));
        $this->helper = new FacebookRedirectLoginHelper(site_url($this->ci->config->item('redirect_url', 'facebook')));
    }

    /**
     * Returns the login URL.
     */
    public function login_url()
    {
        return $this->helper->getLoginUrl($this->permissions);
    }

    /**
     * Returns the current user's info as an array.
     */
    public function get_user()
    {
        if ($this->session) {
            /**
             * Retrieve User’s Profile Information
             */
// Graph API to request user data
            $request = (new FacebookRequest($this->session, 'GET', '/me'))->execute();

// Get response as an array
            $user = $request->getGraphObject()->asArray();

            return $user;
        }
        return false;
    }
}
