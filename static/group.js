window.groups = {};

function register_events_group() {
	var groupPanel = $('#groups');

	groupPanel.on('mouseout', 'ul li', function (e) {
		$(this).children('.operates').addClass('hidden');
	});

	groupPanel.on('mouseover', 'ul li', function (e) {
		$(this).children('.operates').removeClass('hidden');
	});

	groupPanel.on('click', 'ul li .group-edit', function (e) {
		var thisLi = $(this).parent().parent();
		var id = thisLi.data('group-id');
		thisLi.children().remove();
		var inputEle = '<div class="input-group">'
			+ '<input type="text" class="form-control" value="' + get_group_name_by_id(id) + '">'
			+ '</div>';
		thisLi.append(inputEle);
	});

	groupPanel.on('click', 'ul li .group-remove', function (e) {
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

	groupPanel.on('click', 'ul li .group-add', function (e) {
		var thisLi = $(this).parent();

		var newLi = '<li class="list-group-item"><div class="input-group">'
			+ '<input type="text" class="form-control" value="">'
			+ '</div></li>';
		thisLi.before(newLi);
	});

	groupPanel.on('focusout', 'ul li input', function (e) {
		var thisLi = $(this).parent().parent();
		var name = thisLi.find('input').val();
		thisLi.children().remove();
		var id = thisLi.data('group-id');
		var action = 'group_add';
		if (id !== undefined) {
			action = 'group_update';
		}
		if (name.length === 0) {
			load_groups();
			return;
		}
		var newGroupLiInner = '<a class="clickable" href="#">'
			+ name
			+ '</a>'
			+ '<div class="hidden operates" style="float:right">'
			+ '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;'
			+ '<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
			+ '</div>';
		thisLi.append(newGroupLiInner);

		var ajax = $.ajax({
			url: "/service?action=" + action,
			type: 'POST',
			data: {id: id, name: name}
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

	groupPanel.on('click', 'ul li .clickable', function (e) {
		var group_id = $(this).parent().data('group-id');
		var table = $('#table-contact');
		var options = table.bootstrapTable('getOptions');
		options.url = '/service?action=contact_gets';
		options.pageNumber = 1;
		options.searchText = get_group_name_by_id(group_id);
		table.bootstrapTable('refreshOptions', options);
	});
}

function get_group_name_by_id(id) {
	if (id in window.groups) {
		return window.groups[id]['name'];
	}
	return '未知分组';
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
			res['groups'].forEach(function (group) {
				window.groups[group['id']] = group;
			});
			updateGroupPanel();
			$('#table-contact').bootstrapTable("refresh");
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

	$.each(window.groups, function (id, group) {
		var newGroupOption = '<li class="list-group-item" data-group-id="' + id + '">'
			+ '<a class="clickable" href="javascript:void(0)">' + get_group_name_by_id(id) + '</a>'
			+ '<div class="hidden '
			+ ('0' === id ? '' : 'operates')
			+ '" style="float:right">'
			+ '<a class="group-edit" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>'
			+ '&nbsp;&nbsp;<a class="group-remove" href="javascript:void(0)"><span class="glyphicon glyphicon-remove"></span></a>'
			+ '</div></li>';
		groupList.append(newGroupOption);
	});
	var addGroupEle = '<li class="list-group-item">'
		+ '<a class="group-add btn btn-default" href="javascript:void(0)">添加分组</a>'
		+ '</li>';
	groupList.append(addGroupEle);
}