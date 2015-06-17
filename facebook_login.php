<?php
define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__.'/Facebook/');
require 'autoload.php';
session_start();
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSDKException;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;

FacebookSession::setDefaultApplication("1429332237373438", "1f1de2a9bfbcdd3203ac87ccd3e7186c");
$helper = new FacebookRedirectLoginHelper('http://localhost/test/index.php');
if(!$_SESSION['facebook_session']){
    try {
        $session = $helper->getSessionFromRedirect();
    } catch(FacebookSDKException $e) {
        $session = null;
    };
    if ($session) {
        // User logged in, get the AccessToken entity.
        $accessToken = $session->getAccessToken();
        // Exchange the short-lived token for a long-lived token.
        $longLivedAccessToken = $accessToken->extend();
        $_SESSION['facebook_session'] = $session;
        // Now store the long-lived token in the database
        // . . . $db->store($longLivedAccessToken);
        // Make calls to Graph with the long-lived token.
        // . . .
    } else {
        echo '<a href="' . $helper->getLoginUrl() . '">Login with Facebook</a>';
    }
}
else{
    $session = $_SESSION['facebook_session'];
    try {
        var_dump($session);
        $response = (new FacebookRequest($session, 'GET', '/me/accounts'))->execute();
        $object = $response->getGraphObject();
        foreach($object->getProperty('data')->asArray() as $each_page){
            echo "<a href='page.php?id={$each_page->id}&access_token={$each_page->access_token}'>$each_page->name</a><br>";
        }
    } catch (FacebookRequestException $ex) {
        echo $ex->getMessage();
    } catch (\Exception $ex) {
        echo $ex->getMessage();
    }


}

?>
