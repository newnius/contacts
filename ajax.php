<?php

require_once('util4p/util.php');
require_once('util4p/CRObject.class.php');

require_once('Code.class.php');
require_once('GroupManager.class.php');
require_once('ContactManager.class.php');

require_once('user.logic.php');
require_once('group.logic.php');
require_once('contact.logic.php');

require_once('config.inc.php');
require_once('init.inc.php');


function csrf_check($action)
{
	/* check referer, just in case I forget to add the method to $post_methods */
	$referer = $_SERVER['HTTP_REFERER'];
	$url = parse_url($referer);
	if (isset($url['host']) && $url['host'] != $_SERVER['HTTP_HOST']) {
		return false;
	}
	$post_methods = array(
		'group_add',
        'group_remove',
        'group_update',
        'contact_add',
        'contact_remove',
        'contact_update',
		'user_signout'
	);
	$csrf_token = null;
	if(isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
		$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'];
	}
	if (in_array($action, $post_methods)) {
		return $csrf_token !== null && isset($_COOKIE['csrf_token']) && $csrf_token === $_COOKIE['csrf_token'];
	}
	return true;
}

function print_response($res)
{
	if (!isset($res['msg']))
		$res['msg'] = Code::getErrorMsg($res['errno']);
	$json = json_encode($res);
	header('Content-type: application/json');
	echo $json;
}


$res = array('errno' => Code::UNKNOWN_REQUEST);

$action = cr_get_GET('action');

if (!csrf_check($action)) {
	$res['errno'] = 99;
	$res['msg'] = 'invalid csrf_token';
	print_response($res);
	exit(0);
}

switch ($action) {
	case 'group_add':
		$group = new CRObject();
		$group->set('name', cr_get_POST('name'));
		$res = group_add($group);
		break;

	case 'group_remove':
		$group = new CRObject();
		$group->set('id', cr_get_POST('id'));
		$res = group_remove($group);
		break;

    case 'group_update':
        $group = new CRObject();
        $group->set('id', cr_get_POST('id'));
        $group->set('name', cr_get_POST('name'));
        $res = group_update($group);
        break;

	case 'group_gets':
		$rule = new CRObject();
		$rule->set('who', cr_get_GET('who', 'self'));
		$res = group_gets($rule);
		break;

    case 'contact_add':
        $contact = new CRObject();
        $contact->set('name', cr_get_POST('name'));
        $contact->set('telephones', cr_get_POST('telephones'));
        $contact->set('remark', cr_get_POST('remark'));
        $contact->set('group_id', cr_get_POST('group_id'));
        $res = contact_add($contact);
        break;

    case 'contact_remove':
        $contact = new CRObject();
        $contact->set('id', cr_get_POST('id'));
        $res = contact_remove($contact);
        break;

    case 'contact_update':
        $contact = new CRObject();
        $contact->set('id', cr_get_POST('id'));
        $contact->set('name', cr_get_POST('name'));
        $contact->set('telephones', cr_get_POST('telephones'));
        $contact->set('remark', cr_get_POST('remark'));
        $contact->set('group_id', cr_get_POST('group_id'));
        $res = contact_update($contact);
        break;

    case 'contact_gets':
        $rule = new CRObject();
        $rule->set('who', cr_get_GET('who', 'self'));
        $res = contact_gets($rule);
        break;

	case 'user_signout':
		$res = user_signout();
		break;

	case 'log_gets':
		$rule = new CRObject();
		$rule->set('who', cr_get_GET('who', 'self'));
		$rule->set('offset', cr_get_GET('offset'));
		$rule->set('limit', cr_get_GET('limit'));
		$rule->set('order', 'latest');
		$res = log_gets($rule);
		break;

	default:
		break;
}

print_response($res);
