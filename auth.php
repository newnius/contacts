<?php
  session_start();
  require_once('config.php');
  require_once('class-pdo.php');
  $access_token = $_GET['access_token'];
  $userid = $_GET['userid'];
  
  // should be the same with request
  $url = urlencode(SITE.'/auth.php');

  $data = file_get_contents('http://quickauth.newnius.com/auth.php?userid='.$userid.'&access_token='.$access_token.'&url='.$url);
  $a_data = json_decode($data, true);

  if($a_data['errorno'] == 0){
    $_SESSION['contact_username'] = $a_data['user']['username'];
    $_SESSION['contact_uid'] = 1;
    header('location:'.SITE.'/main.php');
  }else{
    echo 'not';
  }

  

  function get_user_by_username($username){
    $sql = 'SELECT * from `account` WHERE `username` = ?';
    $params = array($username);
    $user = (new MysqlPDO())->executeQuery($sql, $params);
    if($user == null || count($user) == 0){
      return null;
    }
  }

?>
