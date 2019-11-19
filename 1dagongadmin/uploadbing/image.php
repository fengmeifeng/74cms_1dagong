<?php
	class Imagesize {
		private $path;
		//构造方法用来对图片所在位置进行初使化
		function __construct($path="./"){
			$this->path=rtrim($path, "/")."/";
		}
		/* 对图片进行缩放
		 *
		 * 参数$name: 是需要处理的图片名称
		 * 参数$width:是缩放后的宽度
		 * 参数$height:是缩放后的高度
		 * 参数$qz: 是新图片的名称前缀
		 * 返回值:就是缩放后的图片名称，失败则返回false
		 *
		 */
		function thumb($name, $width, $height, $qz="th_"){
			//获取图片信息
			$imgInfo=$this->getInfo($name); //图片的宽度，高度，类型
			//获取图片资源, 各种类型的图片都可以创建资源 jpg, gif, png
			$srcImg=$this->getImg($name, $imgInfo);
			//获取计算图片等比例之后的大小, $size["width"], $size["height"]
			$size=$this->getNewSize($name, $width, $height, $imgInfo);
			//获取新的图片资源, 处理一下gif透明背景
			$newImg=$this->kidOfImage($srcImg, $size, $imgInfo);
			//另存为一个新的图片，返回新的缩放后的图片名称	
			$data=$this->createNewImage($newImg, $qz.$name, $imgInfo);	
			if($data!=""){
				return true;
			}else{
				return false;
			}

		}

		private function createNewImage($newImg, $newName, $imgInfo){
			switch($imgInfo["type"]){
				case 1://gif
					$result=imageGif($newImg, $this->path.$newName);
					break;
				case 2://jpg
					$result=imageJPEG($newImg, $this->path.$newName);
					break;
				case 3://png
					$return=imagepng($newImg, $this->path.$newName);
					break;
			}
			imagedestroy($newImg);
			return $newName;
		}

		private function kidOfImage($srcImg, $size, $imgInfo){
			$newImg=imagecreatetruecolor($size["width"], $size["height"]);
			
			$otsc=imagecolortransparent($srcImg);

			if($otsc >=0 && $otsc <= imagecolorstotal($srcImg)){
				$tran=imagecolorsforindex($srcImg, $otsc);

				$newt=imagecolorallocate($newImg, $tran["red"], $tran["green"], $tran["blue"]);

				imagefill($newImg, 0, 0, $newt);

				imagecolortransparent($newImg, $newt);
			}

			imagecopyresized($newImg, $srcImg, 0, 0, 0, 0, $size["width"], $size["height"], $imgInfo["width"], $imgInfo["height"]);

			imagedestroy($srcImg);

			return $newImg;
		}

		private function getNewSize($name, $width, $height, $imgInfo){
			$size["width"]=$imgInfo["width"];
			$size["height"]=$imgInfo["height"];

			//缩放的宽度如果比原图小才重新设置宽度
			if($width < $imgInfo["width"]){
				$size["width"]=$width;
			}
			//缩放的高度如果比原图小才重新设置高度
			if($height < $imgInfo["height"]){
				$size["height"]=$height;
			}

			//图片等比例缩放的算法
			if($imgInfo["width"]*$size["width"] > $imgInfo["height"] * $size["height"]){
				$size["height"]=round($imgInfo["height"]*$size["width"]/$imgInfo["width"]);
			}else{
				$size["width"]=round($imgInfo["width"]*$size["height"]/$imgInfo["height"]);
			}


			return $size;

		}

		private function getInfo($name){
			$data=getImageSize($this->path.$name);

			$imageInfo["width"]=$data[0];
			$imageInfo["height"]=$data[1];
			$imageInfo["type"]=$data[2];

			return $imageInfo;
		}

		private function getImg($name, $imgInfo){
			$srcPic=$this->path.$name;

			switch($imgInfo["type"]){
				case 1: //gif
					$img=imagecreatefromgif($srcPic);
					break;
				case 2: //jpg
					$img=imageCreatefromjpeg($srcPic);
					break;
				case 3: //png
					$img=imageCreatefrompng($srcPic);
					break;
				default:
					return false;
				
			}
			
			return $img;
		}
	}
