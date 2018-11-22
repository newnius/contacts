$(function () {
	do_query();
	$("#btn-search-1").click(function (e) {
		e.preventDefault();
		var telephone = $("#input-search-1").val();
		window.location.href = "#" + telephone;
		do_query();
	});
});

var do_query = function () {
	var url = decodeURIComponent(window.location.href);
	var array = url.split("#");
	if (array.length < 2) return "";
	var telephone = array[1];
	telephone = telephone.replace(/[() ]/g, '').split("-").join("");
	$("#telString").html(telephone);
	if (validateTel(telephone)) {
		getInfo(telephone, showInfo);
		getTrust(telephone, showTrust);
	} else {
		$("#telString").html("不支持的电话号码格式");
	}
};

var validateTel = function (telephone) {
	//var regex = new RegExp("^\\+?[0-9]+$"); // '+' is not supported
	var regex = new RegExp("^[0-9]+$");
	return regex.test(telephone);
};

var getInfo = function (tel, callback) {
	var ajax = $.ajax({
		url: 'https://www.sogou.com/websearch/phoneAddress.jsp?cb=?',
		type: 'GET',
		dataType: "jsonp",
		data: {phoneNumber: tel}
	});
	ajax.done(function (response) {
		callback(response);
	});
	ajax.fail(function (jqXHR, textStatus) {
		alert("加载归属地信息失败：" + textStatus);
	});
};

var getTrust = function (tel, callback) {
	var ajax = $.ajax({
		url: 'https://www.sogou.com/reventondc/inner/vrapi',
		type: 'GET',
		dataType: "jsonp",
		data: {number: tel}
	});
	ajax.done(function (response) {
		callback(response);
	});
	ajax.fail(function (jqXHR, textStatus) {
		alert("加载标记信息失败:" + textStatus);
	});
};

var showInfo = function (carrier) {
	$("#carrier").html(carrier);
};

var showTrust = function (res) {
	if (res.errorCode !== 0) {
		$("#identity").html(res.description);
		return;
	}
	var id = res.NumInfo;
	var amount = res.Amount;
	var array = id.split("：");
	if (array.length === 3) id = array[1];
	var html = "";
	if (amount > 0) {
		html = "<span class='text-danger'>" + id + "</span>";
	} else {
		html = "<span>" + id + "</span>";
	}
	$("#identity").html(html);
};