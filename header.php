<nav id="nav-header" class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo SITE.'/' ?>">云通讯录</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <form class="navbar-form navbar-left" role="search">
	  <div class="input-group input-group">
            <input id="input-search" type="text" class="form-control" placeholder="归属地查询">
            <span class="input-group-btn">
	      <button id="btn-search" type="submit" class="btn btn-default">搜索</button>
	    </span>
          </div>
        </form>
      <?php if(!isset($_SESSION['contact_username'])){ ?>
        <li id='login'><a href="http://quickauth.newnius.com/login.php?redirect=<?php echo SITE ?>/auth.php">登录</a></li>
        <li><a href="<?php echo SITE.'/join' ?>">注册</a></li>
      <?php }else{
      ?>
        <li><a href="<?php echo SITE.'/main#profile' ?>"><?php echo htmlspecialchars($_SESSION['contact_username']); ?></a></li>
      <?php } ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">更多<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="help.php">帮助</a></li>
            <li role="separator" class="divider"></li>
            <?php if(isset($_SESSION['contact_username'])){ ?>
            <li><a href="<?php echo SITE.'/main#logout' ?>">退出</a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>

<!-- Signup Modal -->
<div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="reg-model-body" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id = "regModalLabel">加入到吉大易物</h4>
      </div>
      <div class="modal-body">
        <form id="form-reg" action="#">
          <label for="Username" class="sr-only">Username</label>
          <input type="text" id="r-username" class="form-group form-control " placeholder="用户名" required autofocus>

          <label for="Email" class="sr-only">Email</label>
          <input type="email" id="r-email" class="form-group form-control " placeholder="邮箱" required autofocus>

          <label for="Password" class="sr-only">Password</label>
          <input type="password" id="r-password" class="form-group form-control" placeholder="密码" required>
          <div class="checkbox">
            <label>
              <input type="checkbox" id="r-agree" value="r-agree" />我同意...
            </label>
            <hr/>
            <div class="row">
              <div class="col-md-6 col-sm-6"><button id="btn-register" type="submit" class="btn btn-primary btn-block">注册</button></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- addContact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="reg-model-body" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id = "regModalLabel">添加联系人</h4>
      </div>
      <div class="modal-body">
        <form id="form-add-contact" action="#">
          <label for="contact_name" class="sr-only">姓名</label>
          <input type="text" id="add-contact-name" class="form-group form-control " placeholder="姓名" required autofocus>
          
          <div id="add-contact-telephones">
	    <label for="telephone" class="sr-only">电话号</label>
            <input type="telephone" class="form-group form-control " placeholder="电话号码" required autofocus>
          </div>
          <label for="remark" class="sr-only">备注</label>
          <input type="text" id="add-contact-remark" class="form-group form-control" placeholder="备注" required>
          <label for="contact_group" class="sr-only">分组</label>
          <select id="add-contact-group" class="form-group form-control "  required>
	  </select>
	  <div>
            <button id="btn-add-contact" type="submit" class="btn btn-primary btn-block">添加</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- updateContact Modal -->
<div class="modal fade" id="updateContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="reg-model-body" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" >修改联系人信息</h4>
      </div>
      <div class="modal-body">
        <form id="form-update-contact" action="#">
          <input type="hidden" id="update-contact-id" class="form-group form-control " >
          <label for="contact_name" class="sr-only">姓名</label>
          <input type="text" id="update-contact-name" class="form-group form-control " placeholder="姓名" required autofocus>
          
          <div id="update-contact-telephones">
          </div>
          <label for="remark" class="sr-only">备注</label>
          <input type="text" id="update-contact-remark" class="form-group form-control" placeholder="备注" required>
          <label for="contact_group" class="sr-only">分组</label>
          <select id="update-contact-group" class="form-group form-control "  required>
	  </select>
	  <div>
            <button id="btn-update-contact" type="submit" class="btn btn-primary">修改联系人信息</button>
            <button id="btn-update-delete" type="button" class="btn btn-danger">删除联系人</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


