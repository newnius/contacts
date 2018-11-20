<?php

require_once('util4p/CRObject.class.php');
require_once('util4p/MysqlPDO.class.php');
require_once('util4p/SQLBuilder.class.php');

class ContactManager
{
	/*
	 * do add site
	 */
	public static function add(CRObject $contact)
	{
		$name = $contact->get('name', '');
		$telephones = $contact->get('telephones', '');
        $remark = $contact->get('remark', '');
        $group_id = $contact->getInt('group_id');
        $owner = $contact->get('owner');

		$key_values = array('name' => '?', 'telephones' => '?', 'remark' => '?', 'group_id' => '?', 'owner' => '?');
		$builder = new SQLBuilder();
		$builder->insert('tel_contact', $key_values);
		$sql = $builder->build();
		$params = array($name, $telephones, $remark, $group_id, $owner);
		$count = (new MysqlPDO())->execute($sql, $params);
		return $count === 1;
	}

	/* */
	public static function gets(CRObject $rule)
	{
		$owner = $rule->get('owner', '');
		$offset = $rule->getInt('offset', 0);
		$limit = $rule->getInt('limit', -1);
		$selected_rows = array();
		$where = array();
		$params = array();
		if ($owner) {
			$where['owner'] = '?';
			$params[] = $owner;
		}
		$builder = new SQLBuilder();
		$builder->select('tel_contact', $selected_rows);
		$builder->where($where);
		$builder->limit($offset, $limit);
		$sql = $builder->build();
		$sites = (new MysqlPDO())->executeQuery($sql, $params);
		return $sites;
	}

	/* */
	public static function get(CRObject $rule)
	{
		$id = $rule->getInt('id');
		$selected_rows = array();
		$where = array('id' => '?');
		$params = array($id);
		$builder = new SQLBuilder();
		$builder->select('tel_contact', $selected_rows);
		$builder->where($where);
		$sql = $builder->build();
		$contacts = (new MysqlPDO())->executeQuery($sql, $params);
		return count($contacts) > 0 ? $contacts[0] : null;
	}

	/* */
	public static function remove(CRObject $contact)
	{
		$id = $contact->getInt('id');
		$where = array('id' => '?');
		$builder = new SQLBuilder();
		$builder->delete('tel_contact');
		$builder->where($where);
		$sql = $builder->build();
		$params = array($id);
		$count = (new MysqlPDO())->execute($sql, $params);
		return $count > 0;
	}

	/* */
	public static function update(CRObject $contact)
	{
        $id = $contact->getInt('id');
        $name = $contact->get('name', '');
        $telephones = $contact->get('telephones', '');
        $remark = $contact->get('remark', '');
        $group_id = $contact->getInt('group_id');

        $key_values = array('name' => '?', 'telephones' => '?', 'remark' => '?', 'group_id' => '?');
		$where = array('id' => '?');
		$builder = new SQLBuilder();
		$builder->update('tel_contact', $key_values);
		$builder->where($where);
		$sql = $builder->build();
		$params = array($name, $telephones, $remark, $group_id, $id);
		$count = (new MysqlPDO())->execute($sql, $params);
		return $count === 1;
	}

}
