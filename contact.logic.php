<?php

require_once('util4p/util.php');
require_once('util4p/CRObject.class.php');
require_once('util4p/Random.class.php');
require_once('util4p/AccessController.class.php');
require_once('util4p/CRLogger.class.php');

require_once('Code.class.php');
require_once('ContactManager.class.php');
require_once('Spider.class.php');

require_once('config.inc.php');
require_once('init.inc.php');

function contact_add(CRObject $contact)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'contact.add')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
    $contact->set('owner', Session::get('uid'));
	$res['errno'] = ContactManager::add($contact) ? Code::SUCCESS : Code::FAIL;
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'contact.add');
	$content = array('contact' => $contact, 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function contact_remove(CRObject $contact)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'contact.remove')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
	$origin = ContactManager::get($contact);
	if($origin === null){
	    $res['errno'] = Code::RECORD_NOT_EXIST;
	    return $res;
    }
    if($origin['owner'] !== Session::get('uid')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
	$res['errno'] = ContactManager::remove($contact) ? Code::SUCCESS : Code::FAIL;
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'contact.remove');
	$content = array('contact' => $contact, 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function contact_update(CRObject $contact)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'contact.update')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
    $origin = ContactManager::get($contact);
    if($origin === null){
        $res['errno'] = Code::RECORD_NOT_EXIST;
        return $res;
    }
    if($origin['owner'] !== Session::get('uid')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
    $res['errno'] = ContactManager::update($contact) ? Code::SUCCESS : Code::FAIL;
    $log = new CRObject();
    $log->set('scope', Session::get('uid'));
    $log->set('tag', 'contact.update');
    $content = array('contact' => $contact, 'response' => $res['errno']);
    $log->set('content', json_encode($content));
    CRLogger::log($log);
    return $res;
}

function contact_gets(CRObject $rule)
{
    if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'contact.get')){
        $res['errno'] = Code::NO_PRIVILEGE;
        return $res;
    }
	$rule->set('owner', Session::get('uid'));
	$res['contacts'] = ContactManager::gets($rule);
	$res['errno'] = $res['contacts'] === null?Code::FAIL:Code::SUCCESS;
	return $res;
}