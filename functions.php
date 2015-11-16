<?php
  require_once('class-pdo.php');
  function add_contact($contact_name, $telephones, $remark, $uid, $group_id=0){
    $sql = 'INSERT INTO `contact`(`contact_name`, `telephones`, `remark`, `uid`,  `group_id`, `add_time`) VALUES(?, ?, ?, ?, ?, ?)';
    $params = array($contact_name, $telephones, $remark, $uid, $group_id, time());
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    return $affected_rows == 1;
  }



  function delete_contact_by_id($contact_id, $uid){
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
    $contact = get_contact_by_id($contact_id);
    if($contact == null || $contact['uid'] != $uid){
      return false;
    }

    $sql = 'UPDATE `contact` SET `contact_name` = ?, `telephones` = ?, `remark` = ? WHERE `contact_id` = ?';
    $params = array($contact_name, $telephones, $remark, $contact_id);
    $affected_rows = (new MysqlPDO())->execute($sql, $params);
    if($contact['group_id'] != $group_id){
      $affected_rows |= move_contact_to_group($contact_id, $group_id, $uid);
    }
    return $affected_rows == 1;
  }



  function move_contact_to_group($contact_id, $group_id, $uid){
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
    return $contacts;
  }



  function get_all_groups_by_uid($uid){
    $sql = 'SELECT * FROM `group` WHERE `uid` = ?';
    $params = array($uid);
    $groups = (new MysqlPDO())->executeQuery($sql, $params);
    return $groups;
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
  
?>
