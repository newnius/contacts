<?php

require_once('util4p/util.php');
require_once('util4p/MysqlPDO.class.php');

require_once('config.inc.php');
require_once('init.inc.php');


create_table_user();
create_table_group();
create_table_contact();
create_table_log();

function execute_sqls($sqls)
{
	foreach ($sqls as $description => $sql) {
		echo "Executing $description: ";
		var_dump((new MysqlPDO)->execute($sql, array()));
		echo "<hr/>";
	}
}

function create_table_user()
{
	$sqls = array(
//		'DROP `tel_user`' =>
//			'DROP TABLE IF EXISTS `tel_user`',
		'CREATE `tel_user`' =>
			'CREATE TABLE `tel_user`(
				`uid` int AUTO_INCREMENT,
				 PRIMARY KEY (`uid`),
				`open_id` varchar(64) NOT NULL,
				 UNIQUE (`open_id`),
				`email` varchar(64),
				`role` varchar(12) NOT NULL,
				`level` int DEFAULT 0,
				`time` bigint
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci'
	);
	execute_sqls($sqls);
}

function create_table_group()
{
	$sqls = array(
//		'DROP `tel_group`' => 'DROP TABLE IF EXISTS `tel_group`',
		'CREATE `tel_group`' =>
			'CREATE TABLE `tel_group`(
				`id` BIGINT AUTO_INCREMENT,
				 PRIMARY KEY(`id`),
				`name` VARCHAR(32) NOT NULL,
				`owner` int NOT NULL,
				 INDEX(`owner`)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci',
	);
	execute_sqls($sqls);
}

function create_table_contact()
{
	$sqls = array(
//        'DROP `tel_contact`' => 'DROP TABLE IF EXISTS `tel_contact`',
		'CREATE `tel_contact`' =>
			'CREATE TABLE `tel_contact`(
				`id` BIGINT AUTO_INCREMENT,
				 PRIMARY KEY(`id`),
				`name` VARCHAR(32) NOT NULL,
                `telephones` varchar(255) NOT NULL DEFAULT "",
                `remark` varchar(255),
                `group_id` int NOT NULL DEFAULT 0,
				`owner` int NOT NULL,
				 INDEX(`owner`)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci',
	);
	execute_sqls($sqls);
}

function create_table_log()
{
	$sqls = array(
//		'DROP `tel_log`' => 'DROP TABLE IF EXISTS `tel_log`',
		'CREATE `tel_log`' =>
			'CREATE TABLE `tel_log`(
								`id` BIGINT AUTO_INCREMENT,
								 PRIMARY KEY(`id`),
								`scope` VARCHAR(128) NOT NULL,
								 INDEX(`scope`),
								`tag` VARCHAR(128) NOT NULL,
								 INDEX(`tag`),
								`level` INT NOT NULL, /* too small value sets, no need to index */
								`time` BIGINT NOT NULL,
								 INDEX(`time`), 
								`ip` BIGINT NOT NULL,
								 INDEX(`ip`),
								`content` json 
						)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci'
	);
	execute_sqls($sqls);
}
