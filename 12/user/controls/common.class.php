<?php
	class Common extends Action {
		function init(){
			if(!(isset($_SESSION["isLoginus"]) && $_SESSION["isLoginus"]===1)){
					$this->redirect("login/index");
			}
		}		
	}