<?php
  session_start();
  require_once('config.php'); 
  require_once('functions.php');

  $action = 'getAllContacts';
  if(isset($_GET['action'])){
    $action = $_GET['action'];
  }

  $uid = $_SESSION['contact_uid'];
  $username = $_SESSION['contact_username'];
  
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
      $res = add_contact($_POST['contactName'], $_POST['telephones'], $_POST['remark'], $uid ,$_POST['groupId']);
      $response['errno'] = $res==1? 0 : 1;
      $response['msg'] = $res==1? '':'添加联系人失败';
      echo json_encode($response);
      break;

    case 'deleteContact':
      $contact_id = $_GET['contactId'];
      $res = delete_contact_by_id($contact_id, $uid);
      $response['errno'] = $res==true?0:1;
      $response['msg'] = $res==1? '':'删除联系人失败';
      echo json_encode($response);
      break;

    case 'updateContact':
      $res = update_contact_by_id($_POST['contactId'], $_POST['contactName'], $_POST['telephones'], $_POST['remark'], $uid, $_POST['groupId']);
      $response['errno'] = $res==1?0:1;
      $response['msg'] = $res==1? '':'更新联系人失败';
      echo json_encode($response);
      break;
  }

?>
