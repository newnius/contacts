<?php
  require_once('class-pdo.php');

  function add_contact($contact_name, $telephones, $remark, $uid, $group_id = 0){
    if(!is_numeric($group_id) || !($group_id>=0)){
      return false;
    }
    $sql = 'INSERT INTO `contact`(`contact_name`, `telephones`, `remark`, `uid`,  `group_id`, `add_time`) VALUES(?, ?, ?, ?, ?, ?)';
    $params = array($contact_name, $telephones, $remark, $uid, $group_id, time());
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }


  function delete_contact_by_id($contact_id, $uid){
    if(!is_numeric($contact_id) || !($contact_id>0)){
      return false;
    }
    $contact = get_contact_by_id($contact_id);
    if($contact == null || $contact['uid'] != $uid){
      return false;
    }
    $sql = 'DELETE FROM `contact` WHERE `contact_id` = ?';
    $params = array($contact_id);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }



  function update_contact_by_id($contact_id, $contact_name, $telephones, $remark, $uid, $group_id){
    if(!is_numeric($contact_id) || !is_numeric($group_id) || !($group_id >= 0) || !($contact_id > 0)){
      return false;
    }
    $contact = get_contact_by_id($contact_id);
    if($contact == null || $contact['uid'] != $uid){
      return false;
    }

    $sql = 'UPDATE `contact` SET `contact_name` = ?, `telephones` = ?, `remark` = ?, `last_edit_time` = ? WHERE `contact_id` = ?';
    $params = array($contact_name, $telephones, $remark, time(), $contact_id);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    if($contact['group_id'] != $group_id){
      $affected_rows |= move_contact_to_group($contact_id, $group_id, $uid);
    }
    return $affected_rows == 1;
  }


  function move_contact_to_group($contact_id, $group_id, $uid){
    if(!is_numeric($contact_id) || !is_numeric($group_id)){
      return false;
    }
    $contact = get_contact_by_id($contact_id);
    if($contact == null || $contact['uid'] != $uid){
      return false;
    }
    if($group_id != $contact['group_id'] && $group_id != 0){
      $group = get_group_by_id($group_id);
      if($group == null || $group['uid'] != $uid){
        return false;
      }
    }
    $sql = 'UPDATE `contact` SET `group_id` = ? WHERE `contact_id` = ?';
    $params = array($group_id, $contact_id);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }



  function get_contact_by_id($contact_id){
    if(!is_numeric($contact_id)){
      return null;
    }
    $sql = 'SELECT * FROM `contact` WHERE `contact_id` = ?';
    $params = array($contact_id);
    $contacts = (new MysqlPDO())->executeQuery($sql, $params);
    if(count($contacts) == 1){
      return $contacts[0];
    }else{
      return null;
    }
  }



  function get_all_contacts_by_uid($uid){
    $sql = 'SELECT * FROM `contact` WHERE `uid` = ?';
    $params = array($uid);
    $contacts = (new MysqlPDO())->executeQuery($sql, $params);
    $contacts_array = array();
    $cnt = count($contacts);
    for($i = 0; $i < $cnt; $i++){
      $contacts_array[$i]['contact_id'] = $contacts[$i]['contact_id'];
      $contacts_array[$i]['contact_name'] = $contacts[$i]['contact_name'];
      $contacts_array[$i]['telephones'] = $contacts[$i]['telephones'];
      $contacts_array[$i]['remark'] = $contacts[$i]['remark'];
      $contacts_array[$i]['group_id'] = $contacts[$i]['group_id'];
      $contacts_array[$i]['add_time'] = $contacts[$i]['add_time'];
      $contacts_array[$i]['last_edit_time'] = $contacts[$i]['last_edit_time'];
    }
    return $contacts_array;
  }



  function get_all_groups_by_uid($uid){
    $sql = 'SELECT * FROM `group` WHERE `uid` = ?';
    $params = array($uid);
    $groups = (new MysqlPDO())->executeQuery($sql, $params);
    $groups_array = array();
    $cnt = count($groups);
    for($i = 0; $i < $cnt; $i++){
      $groups_array[$i]['group_id'] = $groups[$i]['group_id'];
      $groups_array[$i]['group_name'] = $groups[$i]['group_name'];
    }
    return $groups_array;
  }



  function get_group_by_id($group_id){
    $sql = 'SELECT * FROM `group` WHERE `group_id` = ?';
    $params = array($group_id);
    $groups = (new MysqlPDO())->executeQuery($sql, $params);
    if(count($groups) == 1){
      return $groups[0];
    }else{
      return null;
    }
  }


  function create_group($group_name, $uid){
    $sql = 'INSERT INTO `group`(`group_name`, `uid`) VALUES(?, ?)';
    $params = array($group_name, $uid);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }

  
  function update_group_by_id($group_id, $new_group_name, $uid){
    if(!is_numeric($group_id)){
      return false;
    }
    $sql = 'UPDATE `group` SET `group_name` = ? WHERE `group_id` = ? AND `uid` = ?';
    $params = array($new_group_name, $group_id, $uid);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }

  function delete_group_by_id($group_id, $uid){
    if(!is_numeric($group_id)){
      return false;
    }
    $sql = 'DELETE FROM `group` WHERE `group_id` = ? AND `uid` = ?';
    $params = array($group_id, $uid);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    if($affected_rows == 1){
      move_contacts_by_group_to_group($group_id, 0, $uid);
    }
    return $affected_rows == 1;
  }

  function move_contacts_by_group_to_group($old_group_id, $new_group_id, $uid){
    if(!is_numeric($old_group_id) || !is_numeric($new_group_id)){
      return false;
    }
    $sql = 'UPDATE `contact` SET `group_id` = ? WHERE `group_id` = ? AND `uid` = ?';
    $params = array($new_group_id, $old_group_id, $uid);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows > 0;
  }

  function get_user_by_username($username){
    $sql = 'SELECT * from `account` WHERE `username` = ?';
    $params = array($username);
    $users = (new MysqlPDO())->executeQuery($sql, $params);
    if($users == null || count($users) == 0){
      return null;
    }
    return $users[0];
  }
  
  function create_user($username){
    $sql = 'INSERT INTO `account` (`username`) VALUES( ? )';
    $params = array($username);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }
?>
