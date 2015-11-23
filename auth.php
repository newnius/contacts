<?php
  session_start();
  require_once('config.php');
  require_once('functions.php');
  $access_token = $_GET['access_token'];
  $userid = $_GET['userid'];
  
  // should be the same with request
  $url = urlencode(SITE.'/auth.php');

  $data = file_get_contents('http://quickauth.newnius.com/auth.php?userid='.$userid.'&access_token='.$access_token.'&url='.$url);
  $a_data = json_decode($data, true);
  if($a_data['errorno'] == 0){
    $_SESSION['contact_username'] = $a_data['user']['username'];
    $user = get_user_by_username($a_data['user']['username']);
    if($user == null){
      if(create_user($a_data['user']['username'])){
        $user = get_user_by_username($a_data['user']['username']);
        $_SESSION['contact_uid'] = $user['uid'];
        header('location:'.SITE.'/main');
      }echo 'Unable to init account';
      //skip readme
      //header('location:'.SITE.'/join');
    }else{
      $_SESSION['contact_uid'] = $user['uid'];
      header('location:'.SITE.'/main');
    }
  }else{
    echo 'Auth failed';
    exit;
  }
?>
