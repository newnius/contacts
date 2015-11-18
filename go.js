selections = [];

$(function(){
  $table = $("#table-contacts");

  var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initToolbar = BootstrapTable.prototype.initToolbar,  
        _initSearch = BootstrapTable.prototype.initSearch;


  BootstrapTable.prototype.initToolbar = function() {
    _initToolbar.apply(this, Array.prototype.slice.apply(arguments));
    var that = this;
    $(document).on('click', 'div[id="groups"] ul li .clickable', function(e){
      var groupId = $(this).parent().data('group-id') ; 
      that.options.selectedGroup = groupId;
      that.options.pageNumber = 1;
      that.searchText = window.groupNames[groupId];
      that.initSearch();
      that.updatePagination();
      //add to indicate that user empty this to really refresh
      that.$toolbar.find('.search input').val('gId:'+groupId);
      });
   }

  BootstrapTable.prototype.initSearch = function () {
    _initSearch.apply(this, Array.prototype.slice.apply(arguments));
    if (this.options.selectedGroup == undefined || this.options.selectedGroup ==-1) {
            return;
        }
      var groupId = this.options.selectedGroup;
      var originData = $table.bootstrapTable('getData');
      var newData = [];
      for(var index in originData){
        if(originData[index].group_id == groupId)
          newData.push(originData[index]);
      }
      this.data = newData;
      //reset to make search work
      this.options.selectedGroup = -1;
    };


  loadAndShowGroups(loadAndShowAllContacts);

  $('#btn-add').click(
    function(){
      $('#addContactModal').modal('show');
      showGroupOptions('add');
    }
  );

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
       selections = getIdSelections();
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

    $('#groups').on('mouseout', 'ul li', function(e){
       $(this).children('.operates').addClass('hidden');
    });
    $('#groups').on('mouseover', 'ul li', function(e){
       $(this).children('.operates').removeClass('hidden');
    });
    $('#groups').on('click', 'ul li .group-edit', function(e){
      var thisLi = $(this).parent().parent();
      var groupId = thisLi.data('group-id'); 
      thisLi.children().remove();
      var inputEle = '<div class="input-group">'
        + '<input type="text" class="form-control" value="'
        + groupNames[groupId]
        + '">'
        + '<a class="input-group-addon group-edit-ok" href="javascript:void(0)"><span class="glyphicon glyphicon-ok"></span></a>'
        + '<a class="input-group-addon group-edit-cancel" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
        + '</div>';
      thisLi.append(inputEle);
    });
    $('#groups').on('click', 'ul li .group-remove', function(e){
      var groupId = $(this).parent().data('group-id'); 
    });

    $('#groups').on('click', 'ul li .group-edit-ok', function(e){
      var thisLi = $(this).parent().parent();
      var groupId = thisLi.data('group-id'); 
      var newGroupName = thisLi.find('input').val()
      thisLi.children().remove();
      var newGroupLiInner = '<a class="clickable" href="#">'
        + newGroupName
        + '</a>'
        + '<div class="hidden operates" style="float:right">'
        + '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>'
        + '&nbsp;&nbsp;<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
        + '</div>'
      thisLi.append(newGroupLiInner);
      updateGroupName(groupId, newGroupName);
    });

    $('#groups').on('click', 'ul li .group-edit-cancel', function(e){
      var thisLi = $(this).parent().parent();
      var groupId = thisLi.data('group-id'); 
      thisLi.children().remove();
      var newGroupLiInner = '<a class="clickable" href="#">'
        + groupNames[groupId]
        + '</a>'
        + '<div class="hidden operates" style="float:right">'
        + '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>'
        + '&nbsp;&nbsp;<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
        + '</div>'
      thisLi.append(newGroupLiInner);
    });

});

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
    showToggle: true,//开启视图切换功能
    showPaginationSwitch: false,//关闭分页功能
    minimumCountColumns: 2, // 设置最少显示列个数
    clickToSelect: true, // true: 单击行即可以选中
    sortName: 'contact_id', // 设置默认排序为 name
    sortOrder: 'asc', // 设置排序为反序 desc
    smartDisplay: true, // 智能显示 pagination 和 cardview 等
    mobileResponsive: true,
    showExport: true, 
    columns: [{ // 列设置
        field: 'state',
        title: '选择',
        checkbox: true // 使用复选框
    }, {
        field: 'contact_name',
        title: '姓名',
        align: 'right',
        valign: 'bottom',
        sortable: true // 开启排序功能
    }, {
        field: 'telephones',
        title: '电话',
        align: 'center',
        valign: 'middle',
        sortable: true,
        formatter: phoneFormatter
    }, {
        field: 'group_id',
        title: '分组',
        align: 'left',
        valign: 'top',
        sortable: true,
        formatter: idFormatter,
    }, {
        field: 'operate',
        title: '操作',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatter
    }]
  });
}

var phoneFormatter = function(telephones){
  return telephones.replace(';','<br/>');
}

var idFormatter = function(id){
  if(id===null)id=0;
  return window.groupNames[id];
}

function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.contact_id;
   });
}

function operateFormatter(value, row, index) {
  return [
    '<a class="edit" href="javascript:void(0)" title="Edit">',
    '<i class="glyphicon glyphicon-edit"></i>',
    '</a>  ',
    '<a class="like" href="javascript:void(0)" title="Like">',
    '<i class="glyphicon glyphicon-heart"></i>',
    '</a>  ',
    '<a class="remove" href="javascript:void(0)" title="Remove">',
    '<i class="glyphicon glyphicon-remove"></i>',
    '</a>'
  ].join('');
}


window.operateEvents = {
  'click .edit': function (e, value, row, index) {
    $('#updateContactModal').modal('show');
       
    var contact = row;
    $('#update-contact-id').val(contact.contact_id);
    $('#update-contact-name').val(contact.contact_name);
    $('#update-contact-telephones').children().remove();
    var telephones = contact.telephones.split(";");
    for(var i=0;i<telephones.length;i++){
      var newPhone = '<label for="telephone" class="sr-only">电话号</label>'     
        + '<input type="telephone" class="form-group form-control" placeholder="电话号码" value="'
        + telephones[i]
        + '">';
      $('#update-contact-telephones').append(newPhone);
    }
    $('#update-contact-remark').val(contact.remark);
    showGroupOptions('update', contact.group_id);
  },
  'click .like': function (e, value, row, index) {
    //alert('You click like action, row: ' + JSON.stringify(row));
  },
  'click .remove': function (e, value, row, index) {
    if(!confirm('确认删除' + row.contact_name + '吗（操作不可逆）')){
       return;
    }
    deleteContact(row.contact_id);
    $table.bootstrapTable('remove', {
      field: 'contact_id',
      values: Array(row.contact_id)
    });
    $("#remove").prop('disabled', !$table.bootstrapTable('getSelections').length);
  }
};

  var showGroupOptions = function(modal, selected = -1){
    $('#' + modal + '-contact-group').children().remove();
    for(var groupId in groupNames){
      var newGroupOption = '<option value="'
        + groupId 
        + '"'
        + (groupId==selected?' selected="selected"':' ')
        + '>'
        + groupNames[groupId]
        + '</option>'; 
      $('#' + modal + '-contact-group').append(newGroupOption);
    }
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
      window.groupNames[0] = '默认分组';
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
  var groupList = $('#groups ul');
  groupList.children().remove();
  
  for(var i in groupNames){
  var newGroupOption = '<li class="list-group-item" data-group-id="'
    + i
    + '"><a class="clickable" href="#">'
    + groupNames[i]
    + '</a>'
    + '<div class="hidden operates" style="float:right">'
    + '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>'
    + '&nbsp;&nbsp;<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
    + '</div></li>'
    groupList.append(newGroupOption);
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

  var updateGroupName = function(groupId, newGroupName){
      if(isNaN(groupId) || groupNames[groupId]==undefined || groupNames[groupId]==newGroupName)
        return;
      var oldGroupName = window.groupNames[groupId];
      window.groupNames[groupId] = newGroupName;
      $table.bootstrapTable("refresh");
      var ajax = $.ajax({
        url: "http://localhost/contacts/ajax.php?action=updateGroup",
        type: 'POST',
        data: {
          groupId: groupId,
          newGroupName: newGroupName
	}
      });

      ajax.done(function(resStr){
        response = JSON.parse(resStr);
	if(response.errno === 0 ){
          $window.groupNames[groupId] = newGroupName;
          $table.bootstrapTable("refresh");
	}else{
          //alert(response.errno);
          window.groupNames[groupId] = newGroupName;
          $table.bootstrapTable("refresh");
	}
      });

      ajax.fail(function(jqXHR,textStatus){
        alert("Request failed :" + textStatus);
      });
    }

