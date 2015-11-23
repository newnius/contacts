<?php
  session_start();
  require_once('config.php');
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <!-- Bootstrap core CSS -->
    <meta name="keywords" content="云通讯录,电话本,联系人,同步,备份,网络备份,联系人去重,号码归属地查询,骚扰电话查询"/>
    <meta name="description" content="云通讯录是基于web的在线联系人管理中心。只需一次导入或添加，即可随时随地，在任意设备上使用，避免了更换设备所带来的联系人信息丢失或转移通讯录的麻烦。并且，这一切都是免费的" />
    <meta name="author" content="Newnius"/>
    <link rel="icon" href="favicon.ico"/>
    <title>云通讯录</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet"/>
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  </head>

<body >
  <?php require_once('header.php'); ?>
  <div class="container">

    <div class="jumbotron">
      <h3>如果你</h3>
      <div>
        <h4><span class="glyphicon glyphicon-question-sign"></span>有多部手机，嫌倒腾通讯录太麻烦</h4>
      </div>
      <div>
        <h4><span class="glyphicon glyphicon-question-sign"></span>非常注重隐私，不想把所有人的联系方式都存在手机上</h4>
      </div>
      <div>
        <h4><span class="glyphicon glyphicon-question-sign"></span>由于各种原因，通讯录里存下了太多的人，想删除却又不知道哪天就用上了</h4>
      </div>
      <h3>那么，这</h3>
      <h2>就是为你而设计的</h2>
      <p>只需一次录入，即可一劳永逸。随时随地打开浏览器，无论电脑还是手机，联系人信息就在你眼前。不用再担心手机坏了，因为你有云通讯录！</p>
      <h4>科技，改变生活</h4>
    </div>
  </div> <!-- /container -->
  <?php require_once('footer.php'); ?>

  <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
  <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
