<?php
  session_start();

  if(isset($_SESSION['contact_uid'])){
    $uid = $_SESSION['contact_uid'];
  }else{
    $response['errno'] = '1';
    $response['msg'] = '您当前尚未登录';
    echo json_encode($response);
    exit;
  }

  require_once('config.php'); 
  require_once('functions.php');
    
  $response['errno'] = '1';
  $response['msg'] = 'Invalid request';
  $invalid_request =  json_encode($response);

  $action = 'getAllContacts';
  if(isset($_GET['action'])){
    $action = $_GET['action'];
  }
  
  switch($action){
    case 'getAllContacts':
      $contacts = get_all_contacts_by_uid($uid);
      echo json_encode($contacts);
      break;

    case 'getAllGroups':
      $groups = get_all_groups_by_uid($uid);
      echo json_encode($groups);
      break;

    case 'addContact':
      if(!isset($_POST['contactName']) || !isset($_POST['telephones']) || !isset($_POST['remark']) || !isset($_POST['groupId'])){
        echo $invalid_request;
        exit;
      }
      $res = add_contact($_POST['contactName'], $_POST['telephones'], $_POST['remark'], $uid ,$_POST['groupId']);
      $response['errno'] = $res==1? 0 : 1;
      $response['msg'] = $res==1? '':'添加联系人失败';
      echo json_encode($response);
      break;

    case 'deleteContact':
      if(!isset($_POST['contactId'])){
        echo $invalid_request;
        exit;
      }
      $res = delete_contact_by_id($_POST['contactId'], $uid);
      $response['errno'] = $res==true?0:1;
      $response['msg'] = $res==1? '':'删除联系人失败';
      echo json_encode($response);
      break;

    case 'updateContact':
      if(!isset($_POST['contactId']) || !isset($_POST['contactName']) || !isset($_POST['telephones']) || !isset($_POST['remark']) || !isset($_POST['groupId'])){
        echo $invalid_request;
        exit;
      }
      $res = update_contact_by_id($_POST['contactId'], $_POST['contactName'], $_POST['telephones'], $_POST['remark'], $uid, $_POST['groupId']);
      $response['errno'] = $res==1?0:1;
      $response['msg'] = $res==1? '':'更新联系人失败';
      echo json_encode($response);
      break;

    case 'updateGroup':
      if(!isset($_POST['groupId']) || !isset($_POST['newGroupName']) ){
        echo $invalid_request;
        exit;
      }
      $res = update_group_by_id($_POST['groupId'], $_POST['newGroupName'], $uid);
      $response['errno'] = $res == 1?0:1;
      $response['msg'] = $res == 1? '':'重命名分组失败';
      echo json_encode($response);
      break;

    case 'deleteGroup':
      if(!isset($_POST['groupId']) ){
        echo $invalid_request;
        exit;
      }
      $res = delete_group_by_id($_POST['groupId'], $uid);
      $response['errno'] = $res == 1?0:1;
      $response['msg'] = $res == 1? '':'删除分组失败';
      echo json_encode($response);
      break;

    case 'createGroup':
      if(!isset($_POST['groupName']) ){
        echo $invalid_request;
        exit;
      }
      $res = create_group($_POST['groupName'], $uid);
      $response['errno'] = $res == 1?0:1;
      $response['msg'] = $res == 1? '':'创建分组失败';
      echo json_encode($response);
      break;

    default:
      echo $invalid_request;
  }

?>
