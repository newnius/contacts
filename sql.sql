/*account*/
create table `account`(
  `uid` int NOT NULL AUTO_INCREMENT,
   primary key(`uid`),
  `username` char(12) NOT NULL UNIQUE,
   index(`username`),
  `level` int DEFAULT 0,
  `join_time` int,
  `join_ip` bigint
)ENGINE = MyISAM DEFAULT CHARSET = utf8;

/*contact*/
create table `contact`(
  `contact_id` int NOT NULL AUTO_INCREMENT,
   primary key(`contact_id`),
  `contact_name` varchar(35) NOT NULL,
  `telephones` varchar(255),
  `remark` varchar(255),
  `uid` int NOT NULL,
   index(`uid`),
  `group_id` int DEFAULT 0,
  `add_time` int,
  `last_edit_time` int DEFAULT 0
)ENGINE = MyISAM DEFAULT CHARSET = utf8;

/*group*/
create table `group`(
  `group_id` int NOT NULL AUTO_INCREMENT,
  primary key(`group_id`),
  `group_name` varchar(32) NOT NULL,
  `uid` int NOT NULL,
   index(`uid`)
)ENGINE = MyISAM DEFAULT CHARSET = utf8;


/*signin_log*/
create table `signin_log`(
  `log_id` bigint AUTO_INCREMENT,
  primary key(`log_id`),
  `uid` int NOT NULL,
  index(`uid`),
  `accepted` char NOT NULL,
  `time` int NOT NULL,
  `ip` bigint NOT NULL
)ENGINE = MyISAM DEFAULT CHARSET = utf8;
