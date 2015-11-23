<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="云通讯录,电话本,联系人,同步,备份,网络备份,联系人去重,号码归属地查询,骚扰电话查询"/>
    <meta name="description" content="云通讯录是基于web的在线联系人管理中心。只需一次导入或添加，即可随时随地，在任意设备上使用，避免了更换设备所带来的联系人信息丢失或转移通讯录的麻烦。并且，这一切都是免费的" />
    <meta name="author" content="Newnius"/>
    <link rel="icon" href="favicon.ico"/>
    <title>云通讯录</title>
    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet"/>
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  </head>

  <body>
  <?php require_once('header.php'); ?>
    <div class="container">
      <div id="tel-belong" class="panel panel-default text-center">
        <div>
          <form role="search">
	    <div class="input-group">
              <input id="input-search-1" type="text" class="form-control" placeholder="查归属地、查陌生人">
              <span class="input-group-btn">
	        <button id="btn-search-1" type="submit" class="btn btn-default">搜索</button>
	      </span>
            </div>
          </form>
        </div>
        <div id="carrier"></div>
        <div id="telString"></div>
        <div id="identity"></div>
      </div>
    </div> <!-- /container -->
    <?php require_once('footer.php'); ?>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="telephone.js"></script>
  </body>
</html>
