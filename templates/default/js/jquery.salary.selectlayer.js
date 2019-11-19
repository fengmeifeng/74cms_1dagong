function allaround(dir){
	if($("#divCityCate").length > 0) {
		fillCity("#divCityCate"); // 地区填充
		// 恢复地区选中条件
		if($("#district_cn").val()) {
			var scitycn = $("#district_cn").val();
			$(".citycatebox .subcate a").each(function() {
				if(scitycn == $(this).html()) {
					$(this).parent().prev().find('font a').addClass('selectedcolor');
					$(this).addClass('selectedcolor');
					$("#cityText").html(scitycn);
				}
			});
			$(".citycatebox p a").each(function() {
				if(scitycn == $(this).html()) {
					$(this).addClass('selectedcolor');
					$("#cityText").html(scitycn);
				}
			});
		}
		/* 地区点击显示到已选 */
		$("#divCityCate li p a").unbind().live('click', function(){
			$("#divCityCate li p a").each(function() {
				$(this).removeClass('selectedcolor');
			});
			$(this).addClass('selectedcolor');
			var checkText = $(this).attr('title');
			$("#cityText").html(checkText);
			$("#district_cn").val(checkText);
			$("#divCityCate").hide();
		});
		$("#divCityCate .subcate a").unbind().live('click', function() {		
			$("#divCityCate .subcate a").each(function() {
				$(this).parent().prev().find('font a').removeClass('selectedcolor');
				$(this).removeClass('selectedcolor');
			});
			$(this).parent().prev().find('font a').removeClass('selectedcolor');
			$(this).addClass('selectedcolor');
			var checkText = $(this).html();
			$("#cityText").html(checkText);
			$("#district_cn").val(checkText);
			$("#divCityCate").hide();
		});
	}
	if($("#divJobCate").length > 0){
		fillJobs("#divJobCate");
		// 恢复职位
		if($("#category_cn").val()) {
			var sjobcn = $("#category_cn").val();
			$(".jobcatebox p a").each(function() {
		 		if(sjobcn == $(this).attr("title")) {
		 			$(this).addClass('selectedcolor');
		 			$("#jobText").html($(this).attr('title'));
		 		}
		 	});
		 	$(".jobcatebox .subcate a").each(function() {
		 		if(sjobcn == $(this).attr("title")) {
					$(this).parent().prev().find('font a').addClass('selectedcolor');
		 			$(this).addClass('selectedcolor');
		 			$("#jobText").html($(this).attr('title'));
		 		}
		 	});
		}
		/* 职位点击显示到已选 */
		$("#divJobCate li p a").unbind().live('click', function() {
			$("#divJobCate li p a").each(function() {
				$(this).removeClass('selectedcolor');
			});
			$(this).addClass('selectedcolor');
			var checkText = $(this).html();
			$("#jobText").html(checkText);
			$("#category_cn").val(checkText);
			$("#divJobCate").hide();
		});
		$("#divJobCate .subcate a").unbind().live('click', function() {
			$("#divJobCate .subcate a").each(function() {
				$(this).parent().prev().find('font a').removeClass('selectedcolor');
				$(this).removeClass('selectedcolor');
			});
			$(this).parent().prev().find('font a').removeClass('selectedcolor');
			$(this).addClass('selectedcolor');
			var checkText = $(this).html();
			$("#jobText").html(checkText);
			$("#category_cn").val(checkText);
			$("#divJobCate").hide();
		});
	}
}
function fillJobs(fillID){
	var jobstr = '';
	$.each(QS_jobs_parent, function(pindex, pval) {
		if(pval) {
			jobstr += '<tr>';
			var jobs = pval.split(",");
		 	jobstr += '<th>'+jobs[1]+'</th>';
		 	jobstr += '<td><ul class="jobcatelist">';
		 	var sjobsArray = QS_jobs[jobs[0]].split("|");
		 	$.each(sjobsArray, function(sindex, sval) {
		 		if(sval) {
		 			var sjobs = sval.split(",");
			 		jobstr += '<li>';
			 		jobstr += '<p><font><a rcoid="'+sjobs[0]+'" pid="'+jobs[0]+'.'+sjobs[0]+'.0" title="'+sjobs[1]+'" href="javascript:;">'+sjobs[1]+'</a></font></p>';
			 		if(QS_jobs[sjobs[0]]) {
			 			jobstr += '<div class="subcate" style="display:none;">';
			 			var cjobsArray = QS_jobs[sjobs[0]].split("|");
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