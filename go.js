selections = [];

$(function(){

  $table = $("#table-contacts");
  loadAndShowGroups(loadAndShowAllContacts);

  $('#btn-add').click(
    function(){
      $('#addContactModal').modal('show');
    }
  );

$(document).on('click', 'div[id="groups"] ul li a', function(){
      var groupId = $(this).data('group-id') ; // userName = '脚本之家'
      alert(groupId);
      console.log($(this));
  });

  $('#btn-add-contact').click(
    function(){
      var contactName = $('#add-contact-name').val();
      var telephones = '';
      $('#add-contact-telephones').children().each(
        function(){
          telephones += ($(this)).val();
	}
      );
      var remark = $('#add-contact-remark').val();
      var group = $('#add-contact-group').val();
      alert(telephones);
      var ajax = $.ajax({
        url: "http://localhost/contacts/ajax.php?action=addContact",
        type: 'POST',
        data: {
          contactName: contactName,
	  telephones: telephones,
	  remark: remark,
	  groupId: group
	}
      });

      ajax.done(function(resStr){
        response = JSON.parse(resStr);
	if(response.errno === 0 ){
          $('#addContactModal').modal('hide');
          $table.bootstrapTable("refresh");
	}else{
          alert('errorno');
	}
      });

      ajax.fail(function(jqXHR,textStatus){
        alert("Request failed :" + textStatus);
      });
    }
  );

  $('#btn-update-contact').click(
    function(){
      var contactId = $('#update-contact-id').val();
      var contactName = $('#update-contact-name').val();
      var array = new Array();
      var cnt = 0;
      $('#update-contact-telephones').children("input").each(
        function(){
          array.push(($(this)).val());
	}
      );
      var telephones = array.join(";");
      var remark = $('#update-contact-remark').val();
      var group = $('#update-contact-group').val();
      var ajax = $.ajax({
        url: "http://localhost/contacts/ajax.php?action=updateContact",
        type: 'POST',
        data: {
          contactId: contactId,
          contactName: contactName,
	  telephones: telephones,
	  remark: remark,
	  groupId: group
	}
      });

      ajax.done(function(resStr){
        response = JSON.parse(resStr);
	if(response.errno === 0 ){
          $('#updateContactModal').modal('hide');
          $table.bootstrapTable("refresh");
	}else{
          alert(response.errno);
	}
      });

      ajax.fail(function(jqXHR,textStatus){
        alert("Request failed :" + textStatus);
      });
    }
  );



  $table.on('check.bs.table uncheck.bs.table ' 
    + 'check-all.bs.table uncheck-all.bs.table', function () {
    $("#remove").prop('disabled', !$table.bootstrapTable('getSelections').length);
      // save your data, here just save the current page
       selections = getIdSelections();
      // push or splice the selections if you want to save all data selections
  });


  $table.on('click-row.bs.table', function (e, value, args) {

    $('#updateContactModal').modal('show');
    
    $('#update-contact-id').val(value.contact_id);
    $('#update-contact-name').val(value.contact_name);
    
    $('#update-contact-telephones').children().remove();
    var telephones = value.telephones.split(";");
    for(var i=0;i<telephones.length;i++){
      var newPhone = '<label for="telephone" class="sr-only">电话号</label>'     
      + '<input type="telephone" class="form-group form-control" placeholder="电话号码" value="'
      + telephones[i]
      + '">';
      $('#update-contact-telephones').append(newPhone);
    }
    $('#update-contact-remark').val(value.remark);
    $('#update-contact-group').children().remove();
    var newGroupOption = '<option value="0">默认分组</option>' 
    $('#update-contact-group').append(newGroupOption);
    for(var i=0; i<groups.length; i++){
      var newGroupOption = '<option value="'
        + groups[i].group_id 
        + '">'
        + groups[i].group_name
        + '</option>' 
      $('#update-contact-group').append(newGroupOption);
    }
  });


  $("#remove").click(function () {
    var ids = getIdSelections();
    deleteContacts(ids);
    $table.bootstrapTable('remove', {
      field: 'contact_id',
      values: ids
    });
    $("remove").prop('disabled', true);
  });


});


var phoneFormatter = function(telephones){
  return telephones.split(";")[0];
}

var idFormatter = function(id){
  if(id==0 || id===null)return "默认分组";
  return window.groupNames[id];
}

function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.contact_id;
   });
}

function loadAndShowAllContacts(){
  $table.bootstrapTable({
    url: 'http://localhost/contacts/ajax.php?action=getAllContacts', // 接口 URL 地址
    cache: true, // 缓存，避免每次排序操作都重新抓取信息
    striped: true, // 隔行加亮
    pagination: true, // 开启分页功能
    pageSize: 25, // 设置默认分页为 50
    pageList: [10, 25, 50, 100, 200], // 自定义分页列表
    search: true, // 开启搜索功能
    showColumns: true, // 开启自定义列显示功能
    showRefresh: true, // 开启刷新功能
    showToggle:true,//开启视图切换功能
    showPaginationSwitch:true,//开启视图切换功能
    minimumCountColumns: 2, // 设置最少显示列个数
    clickToSelect: false, // true: 单击行即可以选中
    sortName: 'contact_id', // 设置默认排序为 name
    sortOrder: 'asc', // 设置排序为反序 desc
    smartDisplay: true, // 智能显示 pagination 和 cardview 等
    columns: [{ // 列设置
        field: 'state',
        checkbox: true // 使用复选框
    }, {
        field: 'contact_name',
        title: 'name',
        align: 'right',
        valign: 'bottom',
        sortable: true // 开启排序功能
    }, {
        field: 'telephones',
        title: 'phone',
        align: 'center',
        valign: 'middle',
        sortable: true,
        formatter: phoneFormatter
    }, {
        field: 'group_id',
        title: 'group',
        align: 'left',
        valign: 'top',
        sortable: true,
        formatter: idFormatter,
    }]
  });
}

var loadAndShowGroups = function(callback){
  var ajax = $.ajax({
    url: "http://localhost/contacts/ajax.php?action=getAllGroups",
    type: 'GET',
    data: {  }
  });

  ajax.done(function(groupsStr){
    window.groups = JSON.parse(groupsStr);
    window.groupNames = new Object();
      for(var i=0; i<groups.length; i++){
        window.groupNames[groups[i].group_id] = groups[i].group_name;
      }
    callback();
    showGroups();
  });

  ajax.fail(function(jqXHR,textStatus){
    alert("Request failed :" + textStatus);
  });
};

var showGroups = function(){
  $('#groups ul').children().remove();
  
  var newGroupOption = '<li role="representation"><a data-group-id="'
    + '0'
    +'" href="#">'
    + '默认分组'
    + '</a></li>'
    $('#groups ul').append(newGroupOption);
  for(var i=0; i<groups.length; i++){
  var newGroupOption = '<li role="representation"><a data-group-id="'
    + groups[i].group_id 
    +'" href="#">'
    + groups[i].group_name
    + '</a></li>'
    $('#groups ul').append(newGroupOption);
  }
};

var deleteContacts = function(ids){
  for(var i=0;i<ids.length; i++){
    deleteContact(ids[i]);
  }
};

var deleteContact = function(contactId){
  var ajax = $.ajax({
    url: "http://localhost/contacts/ajax.php?action=deleteContact",
    type: 'GET',
    data: { contactId:contactId }
  });

  ajax.done(function(groupsStr){
  });

  ajax.fail(function(jqXHR,textStatus){
          $table.bootstrapTable("refresh");
    alert("Request failed :" + textStatus);
  });
};
