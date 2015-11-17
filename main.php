<?php
  session_start();
  require_once('config.php');
  if(!(isset($_SESSION['contact_username']) )){
    header('location:'.SITE.'/info?notloged');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="云通讯录,电话本,联系人,同步,备份,网络备份,联系人去重"/>
    <meta name="description" content="云通讯录是基于web的在线联系人管理中心。只需一次导入或添加，即可随时随地，在任意设备上使用，避免了更换设备所带来的联系人信息丢失或转移通讯录的麻烦。并且，这一切都是免费的" />
    <meta name="author" content="Newnius"/>
    <link rel="icon" href="favicon.ico"/>
    <title>云通讯录</title>
    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Table core css -->
    <link rel="stylesheet" href="bootstrap-table/bootstrap-table.min.css">
 
    <!-- Custom styles for this template -->

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  </head>

  <body>
    <?php require_once('header.php'); ?>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-md-3 hidden-xs">
          <div id="groups" class="panel panel-default">
            <div class="panel-heading">分组</div>
            <ul class="nav nav-pills nav-stacked panel-body">
              <li role="presentation" >
                <span class="text-info">Loading...</span>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-md-offset-1 ">
        <!--  <div class="visible-xs">
            <div class="panel panel-default">
              <div class="panel-heading">Menubar</div>
              <ul class="nav nav-pills panel-body">
                <li role="presentation" >
                  <a href="?home">Home</a>
                </li>
                <li role="presentation" >
                  <a href="?profile">Profile</a>
                </li>
                <li role="presentation" >
                  <a href="?changepwd">Password</a>
                </li>
                <li role="presentation" >
                  <a href="?verify">Verify</a>
                </li>
                <li role="presentation" class="disabled">
                  <a href="?logs">Logs</a>
                </li>
              </ul>
            </div>
          </div>
        -->

          <div id="contacts">
            <div class="panel panel-default">
              <div class="panel-heading">联系人</div> 
              <div class="panel-body table-responsive">
                <div id="toolbar">
                  <!-- close to avoid mistake
                  <button id="remove" class="btn btn-danger" disabled>
                    <i class="glyphicon glyphicon-remove"></i> Delete
                  </button>
                  -->
                  <button id="btn-add" class="btn btn-primary" >
                    <i class="glyphicon glyphicon-plus"></i> 添加联系人
                  </button>
                </div>
                <table id="table-contacts" data-toolbar="#toolbar" class="table table-striped">
                </table> 
                <span class="text-info">* 点击列名可以按照该列进行排序</span><br/>
                <span class="text-info">* 联系人过多时可以选择分页大小</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div> <!-- /container -->
    <?php require_once('footer.php'); ?>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--bootstrap table core js-->
    <script src="bootstrap-table/bootstrap-table.min.js"></script>
    <script src="bootstrap-table/bootstrap-table-locale-all.min.js"></script>
    <script src="bootstrap-table/bootstrap-table-mobile.js"></script>
    <script src="bootstrap-table/bootstrap-table-export.js"></script>
    <script src="//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
    <script src="go.js"></script>
  </body>
</html>
