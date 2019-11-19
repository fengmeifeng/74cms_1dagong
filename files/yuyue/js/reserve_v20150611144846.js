// JavaScript Document
var total = 60;
var timeoutID;

function checkServerTime() {
	var str = $("#datepicker").val();
	var time1 = $("#time1").val();
	var date = new Date;
	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();
	var hour = date.getHours();
	var time = str.split("-");
	if (time1 == "" || time1 == "请输入预约服务时间" || str == "" || str == "&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;") {
		alert("\u8bf7\u9009\u62e9\u9884\u7ea6\u65f6\u95f4\u76f8\u5173");
		return
	}
	if (time[0] == year && time[1] == month && time[2] == day) {
		if ($("#time1").val().split(":")[0].toString() <= hour) {
			alert("请选择正确的预约日期和时间");
			return false
		}
		return true
	}
	return true
}
/*
function sendvalidCode1() {
	var infoid = window.parent.____json4fe.infoid;
	var phone = $("#phone").val();
	//alert(phone+"_"+infoid);
	
	//if (!valPhone(phone)) {
		//return
	//}
	var url = "/plus/ajax_yuding.php?phone" + phone; //这里写程序处理的url，不要这个地址
	var param = {
		date: (new Date).getTime(),
		infoid: infoid
	};
	$.ajax({
		url: url,
		type: "GET",
		dataType: "json",
		data: param,
		//jsonpCallback: "success_submit",
		success: function(data) {
			//alert("11111")
			//$(".login_pop_box h2").html("111111");
			document.getElementById("h2").innerHTML("111111111");
			/*
			if (data.statu == "success") {
				cTime = 60;
				$("#reset").removeClass("none");
				$("#reset").val(cTime + "秒后可重新获取");
				$("#code_sender").addClass("none");
				$("#code_sender").attr("disabled", "disabled");
				timeoutID = self.setInterval("Timeload1()", 1e3)
			} else {
				alert(data.reason)
			}
			*/
/*
		}
	})
	
}
*/
function Timeload1() {
	var infoid = window.parent.____json4fe.infoid;
	if (cTime <= 0) {
		$(".codel").removeAttr("disabled");
		var url = "http://order.58.com/RandomCodeValidate/setUserValidateCode/" + infoid;
		$.ajax({
			url: url,
			dataType: "jsonp",
			data: "",
			complete: function(data) {}
		});
		$("#code_sender").removeClass("none");
		$("#reset").addClass("none");
		timeoutID = window.clearInterval(timeoutID);
		return
	}
	$("#reset").val(cTime + "秒后可重新获取");
	cTime--
}
function submitOrder() {
	var date = $.trim($("#datepicker").val());
	var time = $.trim($("#time1").val());
	var phone = $.trim($("#phone").val());
	var code = $.trim($("#valicode").val());
	var url = "http://order.58.com/sendcode/checkbindphoneajax/" + phone + "/" + code;
	if (time == "" || time == "请输入预约服务时间" || date == "" || date == "&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;") {
		alert("请选择预约时间相关");
		return
	}
	if (!checkServerTime() || !valContacts() || !valPhone() || !valcode()) {
		return
	}
	/*if ($(".codel_t").hasClass("none")) {
		$("#vr_cwtx").html("请重新获取验证码");
		$("#vr_cwtx").css({
			display: ""
		});
		$("#valicode").addClass("tkinput_t");
		$(".queren").addClass("queren_h");
		return
	}*/
	var params = {
		date: (new Date).getTime()
	};
	$.ajax({
		url: url,
		type: "GET",
		dataType: "jsonp",
		async: true,
		data: params,
		jsonpCallback: "success_submit",
		success: function(response) {
			if (response.statu == "nologin") {
				$("#order_form").attr("action", "http://order.58.com/passport/registerlogin/" + phone)
			}
			if (response.statu == "error") {
				if (response.type == "001") {
					$("#vr_cwtx").text(response.reason);
					$("#vr_cwtx").css({
						display: ""
					})
				} else if (response.type == "002") {
					$("#cwtx").text(response.reason);
					$("#cwtx").css({
						display: ""
					})
				} else {
					alert(response.reason)
				}
				$(".queren").addClass("queren_h").unbind("click");
				return
			}
			$("#time").val(date + " " + time + ":00");
			$("#order_form").submit();
			$(".queren").addClass("queren_h").unbind("click")
		},
		timeout: 5e3
	})
}
function sel_time() {
	var date = new Date;
	var time = date.getHours();
	var str = $("#datepicker").val();
	var day = date.getDate();
	var time1 = str.split("-");
	if (str == "" || str == "请输入预约服务日期") {
		$("#datepicker").addClass("tkinput_t");
		$("#vr_date").text("&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;");
		$("#vr_date").css({
			display: ""
		});
		$(".queren").addClass("queren_h");
		$("#vr_time").css({
			display: ""
		});
		$("#time1").addClass("tkinput_t");
		return false
	}
	$(".timeaf").removeClass("none");
	$(".time_up li").on("click", chooseTime);
	if (time1[2] == day) {
		var hui = $(".time_up li").filter(function() {
			return !(this.innerHTML.split(":")[0].toString() > time + 1)
		});
		hui.addClass("huitime").off("click")
	} else {
		$(".time_up li").removeClass("huitime")
	}
}
function sel_sex(org) {
	if (org.id == "man") {
		$("#women").removeClass("xzl").addClass("xzr");
		$("#man").removeClass("xzr").addClass("xzl");
		$("#sex").val("0")
	} else {
		$("#man").removeClass("xzl").addClass("xzr");
		$("#women").removeClass("xzr").addClass("xzl");
		$("#sex").val("1")
	}
}
function valPhone() {
	var value = $("#phone").val();
	var rex = new RegExp(/^1[3-9]{1}[0-9]{9}$/);

	if (!rex.test(value)) {
		$(".queren .queren_h").removeClass("queren_h");
		$("#phone").addClass("tkinput_t");
		$("#cwtx").css({
			display: ""
		});
		$(".queren").removeClass("queren_h");
		//$("#code_sender").addClass("codel_t");
		//$("#code_sender").val("免费获取验证码");
		$("#reset").addClass("none");
		if (!$(".queren").hasClass("queren_h")) {
			//$(".queren").addClass("queren_h");
			
			//$(".queren").addClass("flag")
		}
		return false
	} else {
		$("#phone").val(value).removeClass("tkinput_t");
		$("#cwtx").css({
			display: "none"
		});
		if ($(".queren").hasClass("flag")) {
			$(".queren.queren_h").removeClass("queren_h")
		}
		if ($("#code_sender").hasClass("codel_t")) {
			$("#code_sender").val("\u514d\u8d39\u83b7\u53d6\u9a8c\u8bc1\u7801");
			$("#reset").addClass("none");
			$("#code_sender").removeClass("codel_t");
			$("#code_sender").removeAttr("disabled")
		}
		return true
	}
	return false
}
function init() {
	var value = $("#phone").val();
	var rex = new RegExp(/^1[3-9]{1}[0-9]{9}$/);
	if (rex.test(value)) {
		if ($("#code_sender").hasClass("codel_t")) {
			$("#code_sender").removeClass("codel_t")
		}
	} else {
		$("#code_sender").addClass("codel_t")
	}
}
String.prototype.len = function() {
	return this.replace(/[^\x00-\xff]/g, "xx").length
};

function valContacts() {
	var value = $("#contacts").val();
	var reg = new RegExp(/^[a-zA-Z\u4e00-\u9fa5]+$/);
	var length = value.len();
	if (!reg.test(value) || length > 12) {
		$("#contacts").addClass("tkinput_t");
		$("#con_wrong").css({
			display: ""
		});
		if (!$(".queren").hasClass("queren_h")) {
			$(".queren").addClass("queren_h");
			$(".queren").addClass("flag")
		}
		return false
	} else {
		$("#contacts").val(value).removeClass("tkinput_t");
		$("#con_wrong").css({
			display: "none"
		});
		if ($(".queren").hasClass("flag")) {
			$(".queren.queren_h").removeClass("queren_h")
		}
		return true
	}
	return false
}
function hidde(e) {
	$(".timeaf").addClass("none")
}
function valcode() {
	var code = $("#valicode").val();
	if (isNaN(code) || "" == $.trim(code) || code.length != 6) {
		$("#vr_cwtx").css({
			display: ""
		});
		$("#valicode").addClass("tkinput_t");
		if (!$(".queren").hasClass("queren_h")) {
			$(".queren").addClass("queren_h");
			$(".queren").addClass("flag")
		}
		return false
	} else {
		$("#code").val(code);
		if (valPhone()) {
			$("#vr_cwtx").css({
				display: "none"
			});
			$("#valicode").removeClass("tkinput_t");
			$(".queren.queren_h").removeClass("queren_h");
			return true
		}
	}
	return false
}
function handleIEhide(tagName) {
	if (tagName != "INPUT" && tagName != "SPAN" && tagName != "LI") {
		var ele = $(".timeaf").hasClass("none");
		var date = $("#ui-datepicker-div").css("display");
		if (!ele) {
			hidde();
			if ($("#time1").val() == "" || $("#time1").val() == "请输入预约服务时间") {
				$("#vr_time").css({
					display: ""
				});
				$("#time1").addClass("tkinput_t")
			}
			if ($("#datepicker").val() == "&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;") {
				$("#datepicker").addClass("tkinput_t");
				$("#vr_date").css({
					display: ""
				})
			}
		}
		var pickerDiv = $("#ui-datepicker-div").children();
		if (pickerDiv.length > 0) {
			handleDatePicker()
		}
	}
}
function handleDatePicker() {
	var str = $("#datepicker").val();
	if (str == "" || str == "&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;") {
		$("#datepicker").addClass("tkinput_t");
		$("#vr_date").css({
			display: ""
		});
		return false
	} else {
		$("#datepicker").removeClass("tkinput_t");
		$("#vr_date").css({
			display: "none"
		})
	}
}
function handleOtherBrowser(e) {
	if (!e) {
		return
	}
	if (e.target.tagName != "INPUT" && e.target.tagName != "SPAN" && e.target.tagName != "A" && e.target.tagName != "LI") {
		var ele = $(".timeaf").hasClass("none");
		var date = $("#ui-datepicker-div").css("display");
		if (!ele) {
			hidde();
			if ($("#time1").val() == "" || $("#time1").val() == "请输入预约服务时间") {
				$("#vr_time").css({
					display: ""
				});
				$("#time1").addClass("tkinput_t")
			}
			if ($("#datepicker").val() == "&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;") {
				$("#datepicker").addClass("tkinput_t");
				$("#vr_date").css({
					display: ""
				})
			}
		}
		var pickerDiv = $("#ui-datepicker-div").children();
		if (pickerDiv.length > 0) {
			handleDatePicker()
		}
	}
}
function callHide(evt) {
	var e = evt || window.event;
	if (document.body.attachEvent) {
		var tagName = e.srcElement.tagName;
		handleIEhide(tagName)
	} else {
		handleOtherBrowser(e)
	}
}
function chooseTime() {
	$("#time1").val($(this).text());
	if ($("#datepicker").val() != "&#35831;&#36755;&#20837;&#39044;&#32422;&#26381;&#21153;&#26085;&#26399;" && $("#datepicker").val() != "") {
		$("#vr_date").css({
			display: "none"
		});
		$("#datepicker").removeClass("tkinput_t")
	}
	$("#vr_time").css({
		display: "none"
	});
	$("#time1").removeClass("tkinput_t");
	$(".timeaf").addClass("none")
}
$(function() {
	$(".time_up li").on("click", chooseTime);
	if (document.body.attachEvent) {
		document.body.attachEvent("onclick", callHide)
	} else {
		document.body.addEventListener("click", {
			handleEvent: callHide
		}, false)
	}
	init();
	$("#datepicker").datepicker({
		closeText: "关闭",
		prevText: "<",
		nextText: ">",
		currentText: "\u4eca\u5929",
		monthNames: ["\u4e00\u6708", "\u4e8c\u6708", "\u4e09\u6708", "\u56db\u6708", "\u4e94\u6708", "\u516d\u6708", "\u4e03\u6708", "\u516b\u6708", "\u4e5d\u6708", "\u5341\u6708", "\u5341\u4e00\u6708", "\u5341\u4e8c\u6708"],
		monthNamesShort: ["\u4e00", "\u4e8c", "\u4e09", "\u56db", "\u4e94", "\u516d", "\u4e03", "\u516b", "\u4e5d", "\u5341", "\u5341\u4e00", "\u5341\u4e8c"],
		dayNames: ["\u661f\u671f\u65e5", "\u661f\u671f\u4e00", "\u661f\u671f\u4e8c", "\u661f\u671f\u4e09", "\u661f\u671f\u56db", "\u661f\u671f\u4e94", "\u661f\u671f\u516d"],
		dayNamesShort: ["\u5468\u65e5", "\u5468\u4e00", "\u5468\u4e8c", "\u5468\u4e09", "\u5468\u56db", "\u5468\u4e94", "\u5468\u516d"],
		dayNamesMin: ["\u65e5", "\u4e00", "\u4e8c", "\u4e09", "\u56db", "\u4e94", "\u516d"],
		weekHeader: "\u5468",
		dateFormat: "yy-mm-dd",
		firstDay: 1,
		isRTL: false,
		minDate: 0,
		showMonthAfterYear: true,
		yearSuffix: "\u5e74",
		onSelect: function(dateText) {
			handleDatePicker()
		}
	})
});