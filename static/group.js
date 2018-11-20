window.groups = [];

function register_events_group() {
    $("#form-group-submit").click(function (e) {
        $("#form-group-submit").attr("disabled", "disabled");
        var id = $("#form-group-id").val();
        var name = $("#form-group-name").val();
        var type = $("#form-group-submit-type").val();
        var action = "group_add";
        if (type === "update")
            action = "group_update";
        var ajax = $.ajax({
            url: "/service?action=" + action,
            type: 'POST',
            data: {name: name, id: id}
        });
        ajax.done(function (res) {
            if (res["errno"] === 0) {
                $('#modal-group').modal('hide');
                $('#table-group').bootstrapTable("refresh");
            } else {
                $("#form-group-msg").html(res["msg"]);
                $("#modal-group").effect("shake");
            }
            $("#form-group-submit").removeAttr("disabled");
        });
        ajax.fail(function (jqXHR, textStatus) {
            alert("Request failed :" + textStatus);
            $("#form-group-submit").removeAttr("disabled");
        });
    });


    var groupPanel = $('#groups');
    groupPanel.on('mouseout', 'ul li', function(e){
        $(this).children('.operates').addClass('hidden');
    });
    groupPanel.on('mouseover', 'ul li', function(e){
        $(this).children('.operates').removeClass('hidden');
    });

    groupPanel.on('click', 'ul li .group-edit', function(e){
        var thisLi = $(this).parent().parent();
        var id = thisLi.data('group-id');
        thisLi.children().remove();
        var inputEle = '<div class="input-group">'
            + '<input type="text" class="form-control" value="'
            + window.groups[id]['name']
            + '">'
            + '</div>';
        thisLi.append(inputEle);
    });
    groupPanel.on('click', 'ul li .group-remove', function(e){
        var thisLi = $(this).parent().parent();
        var id = thisLi.data('group-id');
        if (!confirm('确认删除' + window.groups[id]['name'] + '吗（操作不可逆）')) {
            return;
        }
        thisLi.remove();
        var ajax = $.ajax({
            url: "/service?action=group_remove",
            type: 'POST',
            data: {id: id}
        });
        ajax.done(function (res) {
            if (res["errno"] !== 0) {
                $("#modal-msg-content").html(res["msg"]);
                $("#modal-msg").modal('show');
            }
            load_groups();
        });
        ajax.fail(function (jqXHR, textStatus) {
            $("#modal-msg-content").html(res["msg"]);
            $("#modal-msg").modal('show');
            load_groups();
        });
    });

    groupPanel.on('click', 'ul li .group-add', function(e){
        var thisLi = $(this).parent();

        var newLi = '<li class="list-group-item"><div class="input-group">'
            + '<input type="text" class="form-control" value="">'
            + '</div></li>';
        thisLi.before(newLi);
    });

    groupPanel.on('focusout', 'ul li input', function(e){
        var thisLi = $(this).parent().parent();
        var name = thisLi.find('input').val()
        thisLi.children().remove();
        var id = thisLi.data('group-id');
        var action = 'group_add';
        if(id !== undefined){
            action = 'group_update';
        }

        var newGroupLiInner = '<a class="clickable" href="#">'
            + name
            + '</a>'
            + '<div class="hidden operates" style="float:right">'
            + '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>'
            + '&nbsp;&nbsp;<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
            + '</div>';
        thisLi.append(newGroupLiInner);

        var ajax = $.ajax({
            url: "/service?action=" + action,
            type: 'POST',
            data: {id:id, name: name}
        });
        ajax.done(function (res) {
            if (res["errno"] !== 0) {
                $("#modal-msg-content").html(res["msg"]);
                $("#modal-msg").modal('show');
            }
            load_groups();
        });
        ajax.fail(function (jqXHR, textStatus) {
            $("#modal-msg-content").html(res["msg"]);
            $("#modal-msg").modal('show');
            load_groups();
        });
    });

    groupPanel.on('click', 'ul li .clickable', function(e){
        var groupId = $(this).parent().data('group-id');
        that = $('#table-contact');
        // that.options.selectedGroup = groupId;

        //that.initSearch();
        //that.updatePagination();

        var options = that.bootstrapTable('getOptions');
        options.url = '/service?action=contact_gets';
        options.pageNumber = 1;
        options.searchText = window.groups[groupId]['name'];
        that.bootstrapTable('refreshOptions', options);
        //that.bootstrapTable("refresh");
        //add to indicate that user empty this to really refresh
        //$('#contacts').find('.search input').val('group:' + window.groups[groupId]['name']);
    });
}

function load_groups(scope) {
    var ajax = $.ajax({
        url: "/service?action=group_gets",
        type: 'GET',
        data: {}
    });
    ajax.done(function (res) {
        if (res["errno"] === 0) {
            window.groups = {0: {'name': '默认分组'}};
            for (var id in res['groups']) {
                window.groups[res['groups'][id]['id']] = res['groups'][id];
            }
            updateGroupPanel();
        } else {
            $("#modal-msg-content").html(res["msg"]);
            $("#modal-msg").modal('show');
        }
    });
    ajax.fail(function (jqXHR, textStatus) {
        alert("Request failed :" + textStatus);
    });
}

function updateGroupPanel() {
    var groupList = $('#groups ul');
    groupList.children().remove();
    for(var id in window.groups){
        var newGroupOption = '<li class="list-group-item" data-group-id="'
            + id
            + '"><a class="clickable" href="#">'
            + window.groups[id]['name']
            + '</a>'
            + '<div class="hidden '
            + ('0' === id ? '':'operates' )
            + '" style="float:right">'
            + '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>'
            + '&nbsp;&nbsp;<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
            + '</div></li>';
        groupList.append(newGroupOption);
    }
    var addGroupEle = '<li class="list-group-item">'
        + '<a class="group-add btn btn-default" href="javascript:void(0)">'
        + '添加分组'
        + '</a>'
        + '</li>';
    groupList.append(addGroupEle);
}