$(function(){
  var getInfo = function(tel, callback){
      var ajax = $.ajax({
        //url: "https://tcc.taobao.com/cc/json/mobile_tel_segment.htm",
        url:'https://www.sogou.com/websearch/phoneAddress.jsp?cb=?',
        type: 'GET',
        dataType: "jsonp",
        data: {
	  phoneNumber: tel
	}
      });

      ajax.done(function(response){
           callback(response);
      });

      ajax.fail(function(jqXHR,textStatus){
        alert("Request failed :" + textStatus);
      });
    }

  var getTrust = function(tel, callback){
      var ajax = $.ajax({
        url:'https://www.sogou.com/reventondc/inner/vrapi', 
        type: 'GET',
        dataType: "jsonp",
        data: {
	  number: tel
	}
      });

      ajax.done(function(response){
           callback(response);
      });

      ajax.fail(function(jqXHR,textStatus){
        alert("Request failed :" + textStatus);
      });
    }

  var showInfo = function(carrier){
    $("#carrier").html(carrier);
    //$("#telString").html(json.telString);
  }

  var showTrust = function(json){
    var id = json.NumInfo;
    var amount = json.Amount;
    var array = id.split("：");
    if(array.length==3)id = array[1];
    var html = "";
    if(amount>0){
      var html = "<span class='text-danger'>" + id + "</span>";
    }else{
      var html = "<span>" + id + "</span>";
    }
    $("#identity").html(html);
  }



var telephone = window.location.href.split('#')[1];
telephone = telephone.split("-").join("");
alert(telephone);
getInfo(telephone, showInfo);
getTrust(telephone, showTrust);

});
