<?php
	class Common extends Action {
		function init(){
			if(!(isset($_SESSION["isLoginus"]) && $_SESSION["isLoginus"]=='crm')){
					$this->redirect("login/index");
			}
		}		
	}