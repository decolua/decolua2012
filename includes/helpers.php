<?php
	function minifyHtml($szContent)
	{
		$szContent = removeDoubleSpace($szContent);
		$szContent = preg_replace('/(	|\r|\n)/', '', $szContent);
		return $szContent;
	}	

	function removeDoubleSpace($szContent)
	{
		$nPost = strpos($szContent, "  ");
		if ($nPost === false)
			return $szContent;

		$szContent = preg_replace('/(  )/', ' ', $szContent);
		return removeDoubleSpace($szContent);
	}	

	function RemoveAllHtmlTag($szInString)
	{
		$szTmp = $szInString;
		while(1){
			$pos1 = strpos($szTmp, "<");
			$pos2 = strpos($szTmp, ">");
					
			if ($pos1 < 0 || $pos1 === false || $pos2 < 0 || $pos2 === false || $pos1 > $pos2)
				break;
						
			$szLeft = substr($szTmp, 0, $pos1);
			$szRight = substr($szTmp, $pos2 + 1);
			$szTmp = $szLeft . $szRight;
		}

		return $szTmp;
	}


	// Convert về không dấu.
	function convert_vi_to_en($str) {
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'A', $str);
		$str = preg_replace('/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'E', $str);
		$str = preg_replace('/(Ì|Í|Ị|Ỉ|Ĩ)/', 'I', $str);
		$str = preg_replace('/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'O', $str);
		$str = preg_replace('/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'U', $str);
		$str = preg_replace('/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'Y', $str);
		$str = preg_replace('/(Đ)/', 'D', $str);
		$str = preg_replace('/( )/', '-', $str);
		return $str;
	}	

	function ParseStringByPattern($szInString, $p1, $p2 = null)
	{
		$szTemp = "";
				
		if ($p1 != '')
		{
			$pos = strpos($szInString, $p1);
			if ($pos < 0 || $pos === false) 
				return "";
				$szTemp = substr($szInString, $pos); 
		}
		else
		{
			$szTemp = $szInString;
		}
				
		if ($p2 == null || $p2 == "")
			return $szTemp;
				
		$pos = strpos($szTemp, $p2);
		if ($pos < 0 || $pos === false)
			return "";
			   
		$szTemp = substr($szTemp, 0, $pos);
		return $szTemp;		
	}
		
	function GetDataByPattern($szHtml, $szPattern)
	{
		$szBuffer = $szHtml;
		if (trim($szPattern) == "")
			return $szHtml;
			
		$lsPattern = explode("||", $szPattern);
		for($i = 0; $i < count($lsPattern); $i++)
		{
			$lsSubPattern = explode(",", $lsPattern[$i]);
			if (count($lsSubPattern) != 2)
				return "";
					
			$szBuffer = ParseStringByPattern($szBuffer, $lsSubPattern[0], $lsSubPattern[1]);
			$szBuffer = substr($szBuffer, strlen($lsSubPattern[0]));
			
		}
		return $szBuffer;
	}

	function uploadImage($szUploadName, $szSavePath, $szSaveName){
		$allowedExts = array("jpg", "jpeg", "gif", "png", "srt", "stt");
		$extension = end(explode(".", $_FILES["file"]["name"]));
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/png")
		|| ($_FILES["file"]["type"] == "application/octet-stream")
		|| ($_FILES["file"]["type"] == "image/pjpeg"))
		&& ($_FILES["file"]["size"] < 10000000)
		&& in_array($extension, $allowedExts)) {	
			$pFile = $_FILES[$szUploadName];
			move_uploaded_file($pFile["tmp_name"], $szSavePath . $szSaveName);
			echo "done<br>";
			return true;
			}
		else {
			echo "Check file : fail<br>";
			return false;
		}
	}

	//Format films Description
	function myTruncate($string, $limit, $break=" ", $pad="...")
	{
	  if(is_null($limit)) {
		$limit=300;
	  }
	  // return with no change if string is shorter than $limit
	  if(strlen($string) <= $limit) return $string;

	  // is $break present between $limit and the end of the string?
	  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
		  $string = substr($string, 0, $breakpoint) . $pad;
		}
	  }

	  return $string;
	}

	function mydecrypt1($str) {
		$str = preg_replace('/&Agrave;/','À',$str);
		$str = preg_replace('/&Aacute;/','Á',$str);
		$str = preg_replace('/&Acirc;/','Â',$str);
		$str = preg_replace('/&Atilde;/','Ã',$str);
		$str = preg_replace('/&Auml;/','Ä',$str);
		$str = preg_replace('/&Aring;/','Å',$str);
		$str = preg_replace('/&AElig;/','Æ',$str);
		$str = preg_replace('/&Ccedil;/','Ç',$str);
		$str = preg_replace('/&Egrave;/','È',$str);
		$str = preg_replace('/&Eacute;/','É',$str);
		$str = preg_replace('/&Ecirc;/','Ê',$str);
		$str = preg_replace('/&Euml;/','Ë',$str);
		$str = preg_replace('/&Igrave;/','Ì',$str);
		$str = preg_replace('/&Iacute;/','Í',$str);
		$str = preg_replace('/&Icirc;/','Î',$str);
		$str = preg_replace('/&Iuml;/','Ï',$str);
		$str = preg_replace('/&ETH;/','Ð',$str);
		$str = preg_replace('/&Ntilde;/','Ñ',$str);
		$str = preg_replace('/&Ograve;/','Ò',$str);
		$str = preg_replace('/&Oacute;/','Ó',$str);
		$str = preg_replace('/&Ocirc;/','Ô',$str);
		$str = preg_replace('/&Otilde;/','Õ',$str);
		$str = preg_replace('/&Ouml;/','Ö',$str);
		$str = preg_replace('/&Oslash;/','Ø',$str);
		$str = preg_replace('/&Ugrave;/','Ù',$str);
		$str = preg_replace('/&Uacute;/','Ú',$str);
		$str = preg_replace('/&Ucirc;/','Û',$str);
		$str = preg_replace('/&Uuml;/','Ü',$str);
		$str = preg_replace('/&Yacute;/','Ý',$str);
		$str = preg_replace('/&THORN;/','Þ',$str);
		$str = preg_replace('/&szlig;/','ß',$str);
		$str = preg_replace('/&agrave;/','à',$str);
		$str = preg_replace('/&aacute;/','á',$str);
		$str = preg_replace('/&acirc;/','â',$str);
		$str = preg_replace('/&atilde;/','ã',$str);
		$str = preg_replace('/&auml;/','ä',$str);
		$str = preg_replace('/&aring;/','å',$str);
		$str = preg_replace('/&aelig;/','æ',$str);
		$str = preg_replace('/&ccedil;/','ç',$str);
		$str = preg_replace('/&egrave;/','è',$str);
		$str = preg_replace('/&eacute;/','é',$str);
		$str = preg_replace('/&ecirc;/','ê',$str);
		$str = preg_replace('/&euml;/','ë',$str);
		$str = preg_replace('/&igrave;/','ì',$str);
		$str = preg_replace('/&iacute;/','í',$str);
		$str = preg_replace('/&icirc;/','î',$str);
		$str = preg_replace('/&iuml;/','ï',$str);
		$str = preg_replace('/&eth;/','ð',$str);
		$str = preg_replace('/&ntilde;/','ñ',$str);
		$str = preg_replace('/&ograve;/','ò',$str);
		$str = preg_replace('/&oacute;/','ó',$str);
		$str = preg_replace('/&ocirc;/','ô',$str);
		$str = preg_replace('/&otilde;/','õ',$str);
		$str = preg_replace('/&ouml;/','ö',$str);
		$str = preg_replace('/&oslash;/','ø',$str);
		$str = preg_replace('/&ugrave;/','ù',$str);
		$str = preg_replace('/&uacute;/','ú',$str);
		$str = preg_replace('/&ucirc;/','û',$str);
		$str = preg_replace('/&uuml;/','ü',$str);
		$str = preg_replace('/&yacute;/','ý',$str);
		$str = preg_replace('/&thorn;/','þ',$str);
		return $str;
	}
?>
