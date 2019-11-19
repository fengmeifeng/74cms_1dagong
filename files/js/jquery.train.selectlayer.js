function allaround(dir){
	if($("#divCityCate").length > 0) {
		fillCity("#divCityCate"); // 地区填充
		// 恢复地区选中条件
		if($("#sdistrict").val()) {
			var scityid = $("#sdistrict").val();
			$(".citycatebox .subcate a").each(function() {
				if(scityid == $(this).attr("rcoid")) {
					$(this).parent().prev().find('font a').addClass('selectedcolor');
					$(this).addClass('selectedcolor');
				}
			});
		}
		/* 地区点击显示到已选 */
		$("#divCityCate li p a").unbind().live('click', function(){
			$("#divCityCate li p a").each(function() {
				$(this).removeClass('selectedcolor');
			});
			$(this).addClass('selectedcolor');
			var checkID = $(this).attr('pid').split(".");
			var checkText = $(this).attr('title');
			$("#cityText").html(checkText);
			$("#district_cn").val(checkText);
			$("#district").val(checkID[0]);
			$("#sdistrict").val(checkID[1]);
			$("#divCityCate").hide();
		});
		$("#divCityCate .subcate a").unbind().live('click', function() {		
			$("#divCityCate .subcate a").each(function() {
				$(this).parent().prev().find('font a').removeClass('selectedcolor');
				$(this).removeClass('selectedcolor');
			});
			$(this).parent().prev().find('font a').addClass('selectedcolor');
			$(this).addClass('selectedcolor');
			var checkID = $(this).attr('pid').split(".");
			var checkText = $(this).attr('title');
			$("#cityText").html(checkText);
			$("#district_cn").val(checkText);
			$("#district").val(checkID[0]);
			$("#sdistrict").val(checkID[1]);
			$("#divCityCate").hide();
		});
	}
	//---fff
	if($("#divTrainCate").length > 0){
		fillTrain("#divTrainCate");
		// 恢复职位
		if($("#subclass").val()) {
			var sjobid = $("#subclass").val();
			if(sjobid == 0) {
				var cjobid = $("#category").val();
				$("#divTrainCate .jobcatebox p a").each(function() {
			 		if(cjobid == $(this).attr("rcoid")) {
			 			$(this).addClass('selectedcolor');
			 			$("#jobText").html($(this).attr('title'));
			 		}
			 	});
			} else {
			 	$("#divTrainCate .jobcatebox .subcate a").each(function() {
			 		if(sjobid == $(this).attr("rcoid")) {
						$(this).parent().prev().find('font a').addClass('selectedcolor');
			 			$(this).addClass('selectedcolor');
			 			$("#jobText").html($(this).attr('title'));
			 		}
			 	});
			}
		}
		/* 职位点击显示到已选 */
		$("#divTrainCate li p a").unbind().live('click', function() {
			$("#divTrainCate li p a").each(function() {
				$(this).removeClass('selectedcolor');
			});
			$(this).addClass('selectedcolor');
			var checkID = $(this).attr('pid').split(".");
			var checkText = $(this).attr('title');
			$("#template").show();
			$("#JobRequInfoTemplate").html('<a data="'+checkID[2]+'" href="javascript:void(0);">'+checkText+'</a>');
			$("#JobRequInfoTemplate a").unbind().die().live('click', function() {
				var aid = $(this).attr("data");
				$.get("train_course.php?act=get_content_by_train_cat&id="+aid, function(data) {
					if (data == "-1") {
						$("#contents").val('');
					} else {
						$("#contents").val(data);
					}
				});
			});
			$("#jobText").html(checkText);
			$("#category_cn").val(checkText);
			$("#topclass").val(checkID[0]);
			$("#category").val(checkID[1]);
			$("#subclass").val(checkID[2]);
			$("#divTrainCate").hide();
		});
		$("#divTrainCate .subcate a").unbind().live('click', function() {
			$("#divTrainCate .subcate a").each(function() {
				$(this).parent().prev().find('font a').removeClass('selectedcolor');
				$(this).removeClass('selectedcolor');
			});
			$(this).parent().prev().find('font a').addClass('selectedcolor');
			$(this).addClass('selectedcolor');
			var checkID = $(this).attr('pid').split(".");
			var checkText = $(this).attr('title');
			$("#template").show();
			$("#JobRequInfoTemplate").html('<a data="'+checkID[2]+'" href="javascript:void(0);">'+checkText+'</a>');
			$("#JobRequInfoTemplate a").unbind().die().live('click', function() {
				var aid = $(this).attr("data");
				$.get("train_course.php?act=get_content_by_train_cat&id="+aid, function(data) {
					if (data == "-1") {
						$("#contents").val('');
					} else {
						$("#contents").val(data);
					}
				});
			});
			$("#jobText").html(checkText);
			$("#category_cn").val(checkText);
			$("#topclass").val(checkID[0]);
			$("#category").val(checkID[1]);
			$("#subclass").val(checkID[2]);
			$("#divTrainCate").hide();
		});
	}
	//--ffff
}
//---fff
function fillTrain(fillID){
	var jobstr = '';
	$.each(QS_train_parent, function(pindex, pval) {
		//alert(QS_train_parent);
		if(pval) {
			jobstr += '<tr>';
			var jobs = pval.split(",");
		 	jobstr += '<th>'+jobs[1]+'</th>';
		 	jobstr += '<td><ul class="jobcatelist">';
		 	var sjobsArray = QS_train[jobs[0]].split("|");
		 	$.each(sjobsArray, function(sindex, sval) {
		 		if(sval) {
		 			var sjobs = sval.split(",");
			 		jobstr += '<li>';
			 		jobstr += '<p><font><a rcoid="'+sjobs[0]+'" pid="'+jobs[0]+'.'+sjobs[0]+'.0" title="'+sjobs[1]+'" href="javascript:;">'+sjobs[1]+'</a></font></p>';
			 		if(QS_train[sjobs[0]]) {
			 			jobstr += '<div class="subcate" style="display:none;">';
			 			var cjobsArray = QS_train[sjobs[0]].split("|");
				 		$.each(cjobsArray, function(cindex, cval) {
				 			if(cval) {
					 			var cjobs = cval.split(",");
					 			jobstr += '<a rcoid="'+cjobs[0]+'" title="'+cjobs[1]+'" pid="'+jobs[0]+'.'+sjobs[0]+'.'+cjobs[0]+'" href="javascript:;">'+cjobs[1]+'</a>';
				 			}
				 		});
			 			jobstr += '</div>';
			 		}
			 		jobstr += '</li>';
		 		}
		 	});
		 	jobstr += '</ul></td>';
			jobstr += '</tr>';
		}
	});
	$(fillID+" tbody").html(jobstr);
	$(".jobcatelist li").each(function() {
		if($(this).find('.subcate').length <= 0) {
			$(this).find('font').css("background","none");
		}
	});
}
//--faff
function fillCity(fillID){
	var citystr = '';
	citystr += '<tr>';
	citystr += '<td><ul class="jobcatelist">';
	$.each(QS_city_parent, function(pindex, pval) {
		if(pval) {
			var citys = pval.split(",");
	 		citystr += '<li>';
	 		citystr += '<p><font><a rcoid="'+citys[0]+'" pid="'+citys[0]+'.0" title="'+citys[1]+'" href="javascript:;">'+citys[1]+'</a></font></p>';
	 		if(QS_city[citys[0]]) {
	 			citystr += '<div class="subcate" style="display:none;">';
	 			var ccitysArray = QS_city[citys[0]].split("|");
		 		$.each(ccitysArray, function(cindex, cval) {
		 			if(cval) {
			 			var ccitys = cval.split(",");
			 			citystr += '<a rcoid="'+ccitys[0]+'" title="'+citys[1]+'/'+ccitys[1]+'" pid="'+citys[0]+'.'+ccitys[0]+'" href="javascript:;">'+ccitys[1]+'</a>';
		 			}
		 		});
	 			citystr += '</div>';
	 		}
	 		citystr += '</li>';
		}
	});
	citystr += '</ul></td>';
	citystr += '</tr>';
	$(fillID+" tbody").html(citystr);
	$(".jobcatelist li").each(function() {
		if($(this).find('.subcate').length <= 0) {
			$(this).find('font').css("background","none");
		}
	});
}