var noteDrag={
	zIndex:99999,
    drag:false,		     //要不要拖
    obj2:null,
    obj:null,           //要拖的对象
    mouseOrigPosX:0,    //鼠标按下去时的坐标
    mouseOrigPosY:0,
    objOrigPosX:0,      //对象原来的位置
    objOrigPosY:0,
    dragWidth:0,
    dragHeight:0,
    
    isOpera:(navigator.userAgent.indexOf('Opera')>-1),
    
    init: function(dWidth,dHeight){
    	  document.onmousedown=noteDrag.start;
    	  document.onmousemove=noteDrag.drag;
    	  document.onmouseup=noteDrag.end,

        this.dragWidth = dWidth;
        this.dragHeight = dHeight; 	
    },
    
    checkObj: function(obj, name){
        while(obj.tagName != "BODY" && obj.tagName != "HTML" && obj.getAttribute('name') != name ){
		        obj = obj.parentNode;
	      }
	
	      if(obj.getAttribute('name') == name){
		        return obj;
	      }
	      else{
		        return false;
	      }
    },
   
    start: function(e){
	      //for firefox and ie 让他们都能用
	      var e = e || event;				
	      this.obj2 = e.target || e.srcElement;    
	      this.obj = noteDrag.checkObj(this.obj2, "note");
	      
	      //记录下鼠标和元素在刚点下鼠标左键时的坐标 
	      if(this.obj != false){
		        this.mouseOrigPosX = e.pageX || e.clientX + document.body.scrollLeft - document.body.clientLeft; //同上
		        this.mouseOrigPosY = e.pageY || e.clientY + document.body.scrollTop - document.body.clientTop;   //同上
		        this.objOrigPosX   = parseInt(this.obj.style.left);
		        this.objOrigPosY   = parseInt(this.obj.style.top);
		        this.drag = true;    
		        this.obj.style.zIndex = noteDrag.zIndex;
		        noteDrag.zIndex ++;
	      }
    },
    
    drag: function(e){
	      if(this.drag){
	          document.onselectstart = function() { return false; }
		        var e = e || event;
		        var mousePosX = e.pageX || e.clientX + document.body.scrollLeft - document.body.clientLeft;
		        var mousePosY = e.pageY || e.clientY + document.body.scrollTop  - document.body.clientTop;
		
		        var oLeft = this.objOrigPosX + mousePosX - this.mouseOrigPosX;
		        var oTop  = this.objOrigPosY + mousePosY - this.mouseOrigPosY;
		
		        //下面控制拖动的范围
		        oLeft = ( oLeft < 0 ) ? 0 : oLeft;
		        oLeft = ( oLeft > noteDrag.dragWidth ) ? noteDrag.dragWidth : oLeft;
		        oTop  = ( oTop  < 0 ) ? 0 : oTop;
		        oTop  = ( oTop  > noteDrag.dragHeight ) ? noteDrag.dragHeight : oTop;
		
		        this.obj.style.left = oLeft + "px";   //物体位置加上鼠标位置向量变化值
		        this.obj.style.top  = oTop  + "px";
		
		        //拖的时候透明，看上去牛逼点
		        if (document.all){
		        	  if(noteDrag.isOpera){
		        	  	  this.obj.style.opacity = 0.5;
		        	  }
		        	  else{	
			              this.obj.style.filter = "alpha(opacity=50)";
			          }		
		        }
		        else{
			          this.obj.style.opacity = 0.5;
		        }
	     }
   },
   
   end: function(){
	     //拖完了就恢复
	     if(this.drag){
           if(document.all){
		           if(noteDrag.isOpera){
		        	  	  this.obj.style.opacity = 1;
		        	  }
		        	  else{	
			              this.obj.style.filter = "";
			          }					
	         }
	         else{
		           this.obj.style.opacity = 1;
	         }
	     }
	     this.drag = false;
	     //obj  = null;
	     this.mouseOrigPosX = 0;
	     this.mouseOrigPosY = 0;
	     this.objOrigPosX   = 0;
	     this.objOrigPosY   = 0;
	     document.onselectstart = function() { return true; }
		 noteDrag.init(641,395);
   }
  
}

function closeDiv(obj){
   while(obj.getAttribute('name') != "note"){
           obj = obj.parentNode;
   }
   obj.parentNode.removeChild(obj);
}

var iLayerMaxNum=999;
function Show(n){
	document.getElementById("showqqbox").qqshows.value = n;
	var e=document.getElementById('layer'+ n);
	//if (e){		
		e.style.display = "none";		
		document.getElementById("qq_show").style.display = "block";		
		document.getElementById("qqshows_div").style.display = "block";
		document.getElementById("qqshows_iframe").style.display = "block";
		loadqqshow(n);
		/* 第二种效果时使
		e.style.zIndex = iLayerMaxNum+1;
		document.getElementById("mask").style.zIndex = iLayerMaxNum;
		document.getElementById("mask").style.display = "block";
		//var size = getPageSize();
		//document.getElementById("mask").style.width = size[0];
		//document.getElementById("mask").style.height = size[1];
	}else{
		alert("对不起，您搜索的字条不存在！");
		history.back(1);		
	}
	*/
}

function loadqqshow(objid) {
	loadXML("get","ajax.asp?action=qqshow&id="+ objid +"",qwbmloadqqshow);
}

function qwbmloadqqshow(xmlDom) {	
	var requestrss = unescape(xmlDom.responseText);
	document.getElementById("qq_show").innerHTML = requestrss;
}

function Hide(){
	var n = document.getElementById("qqshows").value;
	document.getElementById("qq_show").style.display = "none";
	document.getElementById("qqshows_div").style.display = "none";
	document.getElementById("qqshows_iframe").style.display = "none";
	document.getElementById("layer"+ n +"").style.display = "block";
	document.getElementById("layer"+ n +"").style.zIndex = "9999";
	/* 第二种效果时使用
	document.getElementById("mask").style.display = "none";
	iLayerMaxNum=iLayerMaxNum+2;
	*/
}

function Close(n){
	var e='Layer'+n;
	document.getElementById(e).style.display='none';
	Hide();
}

function loveopen(){
	var opendiv = document.getElementById("loveopens");
	var openvalueid = document.getElementById("lovepensow");
	var showdiv = document.getElementById("loveopenshow");
	if (showdiv.style.display == "block"){
			opendiv.className = "ywopen2";
			showdiv.style.display = "none";
			openvalueid.innerHTML = "打开<br/>动态";
		}
		else{
			opendiv.className = "ywopen1";
			showdiv.style.display = "block";
			openvalueid.innerHTML = "关闭<br/>动态";
		}
}

