<?php

require_once('util4p/CRObject.class.php');
require_once('util4p/MysqlPDO.class.php');
require_once('util4p/SQLBuilder.class.php');

class GroupManager
{
	/*
	 * do add site
	 */
	public static function add(CRObject $group)
	{
		$name = $group->get('name');
        $owner = $group->get('owner');

		$key_values = array('name' => '?', 'owner' => '?');
		$builder = new SQLBuilder();
		$builder->insert('tel_group', $key_values);
		$sql = $builder->build();
		$params = array($name, $owner);
		$count = (new MysqlPDO())->execute($sql, $params);
		return $count === 1;
	}

	/* */
	public static function gets(CRObject $rule)
	{
		$owner = $rule->get('owner');
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
		$builder->select('tel_group', $selected_rows);
		$builder->where($where);
		$builder->limit($offset, $limit);
		$sql = $builder->build();
		$groups = (new MysqlPDO())->executeQuery($sql, $params);
		return $groups;
	}

	/* */
	public static function get(CRObject $rule)
	{
		$id = $rule->getInt('id');
		$selected_rows = array();
		$where = array('id' => '?');
		$params = array($id);
		$builder = new SQLBuilder();
		$builder->select('tel_group', $selected_rows);
		$builder->where($where);
		$sql = $builder->build();
		$groups = (new MysqlPDO())->executeQuery($sql, $params);
		return count($groups) > 0 ? $groups[0] : null;
	}

	/* */
	public static function remove(CRObject $group)
	{
		$id = $group->getInt('id');
		$where = array('id' => '?');
		$builder = new SQLBuilder();
		$builder->delete('tel_group');
		$builder->where($where);
		$sql = $builder->build();
		$params = array($id);
		$count = (new MysqlPDO())->execute($sql, $params);
		return $count > 0;
	}

	/* */
	public static function update(CRObject $group)
	{
        $id = $group->getInt('id');
        $name = $group->get('name');

        $key_values = array('name' => '?');
		$where = array('id' => '?');
		$builder = new SQLBuilder();
		$builder->update('tel_group', $key_values);
		$builder->where($where);
		$sql = $builder->build();
		$params = array($name, $id);
		$count = (new MysqlPDO())->execute($sql, $params);
		return $count === 1;
	}

}
