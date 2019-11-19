function Ajax(recvType,bool){var aj=new Object;return aj.targetUrl="",aj.sendString="",aj.async="undefined"==typeof bool?!0:bool,aj.recvType=recvType?recvType.toUpperCase():"HTML",aj.resultHandle=null,aj.ff,aj.createXMLHttpRequest=function(){var a=!1;if(window.XMLHttpRequest)aj.ff=!0,a=new XMLHttpRequest,a.overrideMimeType&&a.overrideMimeType("text/xml");else if(window.ActiveXObject){aj.ff=!1;for(var b=["Microsoft.XMLHTTP","MSXML.XMLHTTP","Microsoft.XMLHTTP","Msxml2.XMLHTTP.7.0","Msxml2.XMLHTTP.6.0","Msxml2.XMLHTTP.5.0","Msxml2.XMLHTTP.4.0","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP"],c=0;c<b.length;c++)try{if(a=new ActiveXObject(b[c]))return a}catch(d){a=!1}}return a},aj.XMLHttpRequest=aj.createXMLHttpRequest(),aj.processHandle=function(){4==aj.XMLHttpRequest.readyState&&(aj.ff=!1,200==aj.XMLHttpRequest.status&&("HTML"==aj.recvType?aj.resultHandle(aj.XMLHttpRequest.responseText):"JSON"==aj.recvType?aj.resultHandle(eval("("+aj.XMLHttpRequest.responseText+")")):"XML"==aj.recvType&&aj.resultHandle(aj.XMLHttpRequest.responseXML)))},aj.get=function(a,b){aj.targetUrl=a,null!=b&&(aj.XMLHttpRequest.onreadystatechange=aj.processHandle,aj.resultHandle=b),window.XMLHttpRequest?(aj.XMLHttpRequest.open("GET",aj.targetUrl,aj.async),aj.XMLHttpRequest.send(null)):(aj.XMLHttpRequest.open("GET",a,aj.async),aj.XMLHttpRequest.send()),!aj.async&&aj.ff&&aj.processHandle()},aj.post=function(a,b,c){if(aj.targetUrl=a,"object"==typeof b){var d="";for(var e in b)d+=e+"="+b[e]+"&";aj.sendString=d.substr(0,d.length-1)}else aj.sendString=b;null!=c&&(aj.XMLHttpRequest.onreadystatechange=aj.processHandle,aj.resultHandle=c),aj.XMLHttpRequest.open("POST",a,aj.async),aj.XMLHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),aj.XMLHttpRequest.send(aj.sendString),!aj.async&&aj.ff&&aj.processHandle()},aj}

function gbt(){
	document.all.miaov_float_layer.style.display='none';
}
function ydzt(id,url){	   
   Ajax('html', false).post(url,{id:id}, function(data){
		if(data=='ok'){
			window.location.reload();
		}
  });
}