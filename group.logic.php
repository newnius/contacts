<?php

require_once('util4p/util.php');
require_once('util4p/CRObject.class.php');
require_once('util4p/Random.class.php');
require_once('util4p/AccessController.class.php');
require_once('util4p/CRLogger.class.php');

require_once('Code.class.php');
require_once('GroupManager.class.php');
require_once('Spider.class.php');

require_once('config.inc.php');
require_once('init.inc.php');

function group_add(CRObject $group)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'group.add')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
    $group->set('owner', Session::get('uid'));
	$res['errno'] = GroupManager::add($group) ? Code::SUCCESS : Code::FAIL;
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'group.add');
	$content = array('group' => $group, 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function group_remove(CRObject $group)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'group.remove')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
	$origin = GroupManager::get($group);
	if($origin === null){
	    $res['errno'] = Code::RECORD_NOT_EXIST;
	    return $res;
    }
    if($origin['owner'] !== Session::get('uid')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
	$res['errno'] = GroupManager::remove($group) ? Code::SUCCESS : Code::FAIL;
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'group.remove');
	$content = array('group' => $group, 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function group_update(CRObject $group)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'group.update')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
    $origin = GroupManager::get($group);
    if($origin === null){
        $res['errno'] = Code::RECORD_NOT_EXIST;
        return $res;
    }
    if($origin['owner'] !== Session::get('uid')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
    $res['errno'] = GroupManager::update($group) ? Code::SUCCESS : Code::FAIL;
    $log = new CRObject();
    $log->set('scope', Session::get('uid'));
    $log->set('tag', 'group.update');
    $content = array('group' => $group, 'response' => $res['errno']);
    $log->set('content', json_encode($content));
    CRLogger::log($log);
    return $res;
}

function group_gets(CRObject $rule)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'group.get')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
	$rule->set('owner', Session::get('uid'));
	$res['groups'] = GroupManager::gets($rule);
	$res['errno'] = $res['groups'] === null?Code::FAIL:Code::SUCCESS;
	return $res;
}