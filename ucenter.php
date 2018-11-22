<?php
require_once('predis/autoload.php');

require_once('util4p/util.php');
require_once('util4p/ReSession.class.php');
require_once('util4p/AccessController.class.php');

require_once('global.inc.php');

require_once('config.inc.php');
require_once('init.inc.php');


if (Session::get('uid') === null) {
	header('location:/?notloged');
	exit;
}

$page_type = 'contacts';
$uid = Session::get('uid');
$nickname = Session::get('nickname');

if (isset($_GET['logs'])) {
	$page_type = 'logs';

} elseif (isset($_GET['logs_all'])) {
	$page_type = 'logs_all';

} elseif (isset($_GET['contacts'])) {
	$page_type = 'contacts';

} elseif (isset($_GET['home'])) {
	$page_type = 'home';

}

$entries = array(
	array('home', '个人主页'),
	array('contacts', '联系人'),
	array('logs', '近期登陆'),
	array('logs_all', '站点日志')
);
$visible_entries = array();
foreach ($entries as $entry) {
	if (AccessController::hasAccess(Session::get('role', 'visitor'), 'ucenter.' . $entry[0])) {
		$visible_entries[] = array($entry[0], $entry[1]);
	}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php require_once('head.php'); ?>
	<title>个人中心 | 云通讯录</title>
	<link href="//cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/bootstrap-table.min.css" rel="stylesheet">
	<script type="text/javascript">
		var page_type = "<?=$page_type?>";
	</script>
</head>

<body>
<?php require_once('modals.php'); ?>
<div class="wrapper">
	<?php require_once('header.php'); ?>
	<div class="container">
		<div class="row">

			<div class="hidden-xs hidden-sm col-md-2 col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">Menu Bar</div>
					<ul class="nav nav-pills nav-stacked panel-body">
						<?php foreach ($visible_entries as $entry) { ?>
							<li role="presentation" <?php if ($page_type == $entry[0]) echo 'class="disabled"'; ?> >
								<a href="?<?= $entry[0] ?>"><?= $entry[1] ?></a>
							</li>
						<?php } ?>
					</ul>
				</div>

				<?php if ($page_type === 'contacts') { ?>
					<div id="groups" class="panel panel-default">
						<div class="panel-heading">分组</div>
						<ul class="list-group">
							<a class="list-group-item">
								<span class="text-info">Loading...</span>
							</a>
						</ul>
					</div>
				<?php } ?>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
				<div class="visible-xs visible-sm">
					<div class="panel panel-default">
						<div class="panel-heading">Menu Bar</div>
						<ul class="nav nav-pills panel-body">
							<?php foreach ($visible_entries as $entry) { ?>
								<li role="presentation" <?php if ($page_type == $entry[0]) echo 'class="disabled"'; ?> >
									<a href="?<?= $entry[0] ?>"><?= $entry[1] ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>

				<?php if ($page_type === 'home') { ?>
					<div id="home">
						<div class="panel panel-default">
							<div class="panel-heading">欢迎页</div>
							<div class="panel-body">
								欢迎回来， <?php echo htmlspecialchars($nickname) ?>.<br/>
								当前 IP: &nbsp; <?= cr_get_client_ip() ?>.<br/>
								现在时刻: &nbsp; <?php echo date('H:i:s', time()) ?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">通知</div>
							<div class="panel-body">
								<h4 class="text-info">通知</h4>
								<p>Nothing new here.</p>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'contacts') { ?>
					<div id="contacts">
						<div class="panel panel-default">
							<div class="panel-heading">联系人列表</div>
							<div class="panel-body">
								<div class="table-responsive">
									<div id="toolbar">
										<button id="btn-contact-add" class="btn btn-primary">
											<i class="glyphicon glyphicon-plus"></i> 添加联系人
										</button>
									</div>
									<table id="table-contact" data-toolbar="#toolbar" class="table table-striped">
									</table>
								</div>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'logs' || $page_type === 'logs_all') { ?>
					<div id="logs">
						<div class="panel panel-default">
							<div class="panel-heading">日志</div>
							<div class="panel-body">
								<div class="table-responsive">
									<div id="toolbar"></div>
									<table id="table-log" data-toolbar="#toolbar" class="table table-striped">
									</table>
									<span class="text-info">* At most 1000 recent activities</span>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
	</div> <!-- /container -->

	<!--This div exists to avoid footer from covering main body-->
	<div class="push"></div>
</div>
<?php require_once('footer.php'); ?>

<script src="static/util.js"></script>
<script src="static/group.js"></script>
<script src="static/contact.js"></script>
<script src="static/ucenter.js"></script>
<script src="static/search.js"></script>

<script src="//cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/bootstrap-table.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.1/tableExport.min.js"></script>
</body>
</html>