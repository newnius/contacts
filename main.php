<?php
  session_start();
  require_once('config.php');
  require_once('functions.php');
  if(!(isset($_SESSION['contact_username']) )){
    header('location:'.SITE.'/info?notloged');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="QuickAuth, free, quick, OAuth"/>
    <meta name="description" content="QuickAuth is an implement of authorization. By using QuickAuth, you can log in to some websites without sign up for another account, which most likely will be used only once. Also,it is totally free!" />
    <meta name="author" content="Newnius"/>
    <link rel="icon" href="favicon.ico"/>
    <title>Ucenter | QuickAuth</title>
    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Table core css -->
    <link rel="stylesheet" href="bootstrap-table.min.css">
 
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet"/>
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  </head>

  <body>
    <?php require_once('header.php'); ?>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-md-3 hidden-xs">
          <div id="groups" class="panel panel-default">
            <div class="panel-heading">Settings</div>
            <ul class="nav nav-pills nav-stacked panel-body">
              <li role="presentation" >
                <a data-group-id="s" href="#">Home</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-md-offset-1 ">
          <div class="visible-xs">
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

        <div id="contacts">
          <div class="panel panel-default">
            <div class="panel-heading">Recent activities</div> 
            <div class="panel-body table-responsive">
<div id="toolbar">
        <button id="remove" class="btn btn-danger" disabled>
            <i class="glyphicon glyphicon-remove"></i> Delete
        </button>
        <button id="btn-add" class="btn btn-primary" >
            <i class="glyphicon glyphicon-plus"></i> Add
        </button>
    </div>
              <table id="table-contacts" data-toolbar="#toolbar" class="table table-striped">
              </table> 
              <span class="text-info">* Only the last 20 records are listed</span><br/>
              <span class="text-info">* If you find any strange record, be careful and should better <a href="?changepwd">update your password</a></span>
            </div>
          </div>
        </div>

      </div>
    </div> <!-- /container -->
    <?php require_once('footer.php'); ?>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--bootstrap table core js-->
    <script src="bootstrap-table.min.js"></script>
    <script src="bootstrap-table-locale-all.min.js"></script>
    <script src="go.js"></script>
  </body>
</html>
