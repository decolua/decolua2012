<?php
	function my_get_contents($szUrl, $szProxy){
		return file_get_contents($szProxy . "?url=" . $szUrl);
	}

	function filterContent($szContent)
	{
		$szContent = preg_replace('/(\r|\n)/', ' ', $szContent);
		$szContent = preg_replace('/(&nbsp;)/',' ', $szContent);
		$szContent = trim(minifyHtml($szContent));
		$szContent = preg_replace('/(<p)/','<p><', $szContent);
		$szContent = preg_replace('/(<p> <\/p>)/','<br/>', $szContent);
		$szContent = preg_replace('/(<br\/> <br\/>)/','<br/>', $szContent);
		$szContent = preg_replace('/(<br\/><br\/>)/','<br/>', $szContent);	
		$szContent = preg_replace('/(<p>)/','~~~', $szContent);
		$szContent = preg_replace('/(<br\/>)/','~~~', $szContent);
		$szContent = preg_replace('/(<br \/>)/','~~~', $szContent);
		$szContent = preg_replace('/(<br>)/','~~~', $szContent);
		$szContent = preg_replace('/(<br)/','<br><', $szContent);
		$szContent = preg_replace('/(<br>)/','~~~', $szContent);
		$szContent = preg_replace('/(\\\|santruyen|- Đọc Truyện Online|SanTruyen|hixx|tunghoanh|TruyệnY|.com|Truyện YY|truyenyy.com|truyenyy|Bạn đang đọc truyện tại|http:\/\/)/','', $szContent);
		if (substr($szContent, 0, 3) == '~~~')
			$szContent = substr($szContent, 3);
			
		$szContent = RemoveAllHtmlTag($szContent);
		$szContent = preg_replace('/(~~~~~~)/', '~~~', $szContent);
		$szContent = preg_replace('/(~~~)/', '<p></p>', $szContent);
		$szContent = preg_replace('/(<p><\/p><p><\/p>)/', '<p></p>', $szContent);
		$szContent = trim(minifyHtml($szContent));
		return $szContent;
	}
	
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

	function get_data($url) {
		$ch = curl_init();
		$timeout = 10;
		curl_setopt($ch, CURLOPT_URL, $url);
		$headers = array(
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36',
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Language: en-us,en;q=0.5',
						'Cache-Control: max-age=0',
					);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}	

	function session_get_data($url) {
		$ch = curl_init();
		$timeout = 1;
		curl_setopt($ch, CURLOPT_URL, $url);
		$headers = array(
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36',
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Language: en-us,en;q=0.5',
						'Cache-Control: max-age=0',
					);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
		$data = curl_exec($ch);
		if ($data == "")
		{
			$timeout = 10;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);		
			curl_close($ch);
		}
		return $data;
	}	

	
function removeDoubleLine($szContent)
{
    $nPost = strpos($szContent, "\r\n\r\n");
    if ($nPost === false)
        return $szContent;

    $szContent = preg_replace('/(\r\n\r\n)/', '\r\n', $szContent);
    return removeDoubleLine($szContent);
}

function removeDoubleString($szContent, $szStr)
{
    $nPost = strpos($szContent, "\n\r\n\r");
    if ($nPost === false)
        return $szContent;

    $szContent = preg_replace('/(' . $szStr . $szStr . ')/', $szStr, $szContent);
    return removeDoubleLine($szContent);
}

/* These are helper functions */
function textOverImage($szFileName, $szText)
{
    $fontSize = 11;
    $x = 25;
    $y = 205;
	
	// Create some colors
    $image = imagecreatefromjpeg($szFileName);
	$im = imagecreatetruecolor(350, 30);
	$color = imagecolorallocate($im, 255, 200, 0);	
	$font = 'utm_helvetins.ttf';
	
	imagettftext($image, $fontSize, 0, $x, $y, $color, $font, $szText);
    imagejpeg($image, $szFileName, 96);	
}

// Anti
function badRequest(){
    if ($_GET){
		foreach ($_GET as $antivar => $whatvar){
			if (eregi("'",$whatvar)) { echo "Bad Request"; exit; }
		}
	}
}

function render($template,$vars = array()){
	
	// This function takes the name of a template and
	// a list of variables, and renders it.
	
	// This will create variables from the array:
	extract($vars);
	
	// It can also take an array of objects
	// instead of a template name.
	if(is_array($template)){
		
		// If an array was passed, it will loop
		// through it, and include a partial view
		foreach($template as $k){
			
			// This will create a local variable
			// with the name of the object's class
			
			$cl = strtolower(get_class($k));
			$$cl = $k;
			
			include "views/_$cl.php";
		}
		
	}
	else {
		include "views/$template.php";
	}
}

// Helper function for title formatting:
function formatTitle($title = ''){
	if($title){
		$title.= ' | ';
	}
	
	$title .= $GLOBALS['defaultTitle'];
	
	return $title;
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

// Lấy link hiện tại
function getCurrentPageURL() {
	$pageURL = 'http';
	if (!empty($_SERVER['HTTPS'])) {if($_SERVER['HTTPS'] == 'on'){$pageURL .= 's';}} 
	$pageURL .= '://';
	if ($_SERVER['SERVER_PORT'] != '80') {
		$pageURL .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
	} else {
		$pageURL .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	return $pageURL;
}

function redirect($url) {
    if(0) {
        header('Location: '.$url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}

function uploadImage($szUploadName, $szSavePath, $szSaveName){
var_dump($szUploadName);
//echo "$szUploadName, $szSavePath, $szSaveName<br>" . $_FILES["file"]["name"];
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

function uploadSubtitle($szUploadName, $szSavePath, $szSaveName){
var_dump($szUploadName);
echo "$szUploadName, $szSavePath, $szSaveName<br>" . $_FILES["file"]["name"];
$allowedExts = array("srt", "stt");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "application/octet-stream")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 10000000)
&& in_array($extension, $allowedExts)) {	
	$pFile = $_FILES[$szUploadName];
	var_dump($pFile);
	move_uploaded_file($pFile["tmp_name"], $szSavePath . '/' . $szSaveName);
	move_uploaded_file($_FILES["file"]["tmp_name"],      $szSavePath . "/".  $_FILES["file"]["name"]);
	echo "done<br>";
	return true;
	}
else {
	echo "Check file : fail<br>";
	return false;
}
}

function generateUniqueImgName($str) {
	$imgName = uniqid(rand(), true);
	return $imgName;
}

function uploadImg($szUploadName, $szSavePath, $szSaveName){
$allowedExts = array("jpg", "jpeg", "gif", "png", "stt", 'srt');
echo $_FILES["file"]["type"];
return;
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
//&& ($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }
}

// Get Film Index
		function getIndexFromName($szName)
		{
			$pos1 = strpos($szName, '_');
			$pos2 = strpos($szName, '.');
			
			if ($pos1 > 0 && $pos2 >0 && $pos2 > $pos1)
			{
				return intval(substr($szName, $pos1 + 1, $pos2 - $pos1 - 1));
			}
			
			return -1;
		}
		
		function insertLink($lsLink, $szLink, $nIndex)
		{
			if ($lsLink == "")
				return $szLink;
				
			$szSplit = explode("||", $lsLink);
			$szArray = null;
			$nCount = 0;
			$bFlag = false;
			
			for ($i = count($szSplit) - 1; $i >= 0; $i--)
			{
				$nRetIndex = getIndexFromName($szSplit[$i]);
				if ($nRetIndex == -1)
					return "";
					
				if ($nRetIndex <= $nIndex && $bFlag == false)
				{
					$szArray[$nCount] = $szLink;
					$nCount++;
					$bFlag = true;
				}
				if ($nRetIndex != $nIndex)
				{
					$szArray[$nCount] = $szSplit[$i];
					$nCount++;
				}
			}
			
			
			if ($bFlag == false)
				$szRet = $szLink . "||";
			$szRet .= $szArray[count($szArray) - 1];
			for ($i = count($szArray) - 2; $i >= 0; $i--)
			{
				$szRet .= "||" . $szArray[$i];
			}
			
			return $szRet;
		}
		
		function convertImgName($szFilmName)
		{
			$szFilmName  = str_replace( ":", '', $szFilmName);
			$szFilmName  = str_replace( "*", '', $szFilmName);
			$szFilmName  = str_replace( '?', '', $szFilmName);
			$szFilmName  = str_replace( "\\", '', $szFilmName);
			$szFilmName  = str_replace( "/", '', $szFilmName);
			$szFilmName  = str_replace( ">", '', $szFilmName);
			$szFilmName  = str_replace( "<", '', $szFilmName);
			$szFilmName  = str_replace( "|", '', $szFilmName);
			$szFilmName  = str_replace( "\'", '', $szFilmName);
			$szFilmName  = str_replace( "'", '', $szFilmName);
			$szFilmName  = str_replace( '"', '', $szFilmName);		
			$szFilmName  = str_replace( '-', '', $szFilmName);	
			$szFilmName  = str_replace( '!', '', $szFilmName);
				
			return convert_vi_to_en($szFilmName);
		}		
		
		function convertFilmName($szFilmName)
		{
			$nIndex = strpos($szFilmName, "(");
			
			if ($nIndex > 1)
				$szFilmName = trim(substr($szFilmName, 0, $nIndex)); 
				
			$szFilmName  = str_replace( ":", '', $szFilmName);
			$szFilmName  = str_replace( "*", '', $szFilmName);
			$szFilmName  = str_replace( '?', '', $szFilmName);
			$szFilmName  = str_replace( "\\", '', $szFilmName);
			$szFilmName  = str_replace( "/", '', $szFilmName);
			$szFilmName  = str_replace( ">", '', $szFilmName);
			$szFilmName  = str_replace( "<", '', $szFilmName);
			$szFilmName  = str_replace( "|", '', $szFilmName);
			$szFilmName  = str_replace( "\'", '', $szFilmName);
			$szFilmName  = str_replace( "'", '', $szFilmName);
			$szFilmName  = str_replace( '"', '', $szFilmName);		
			$szFilmName  = str_replace( '-', '', $szFilmName);	
			$szFilmName  = str_replace( '!', '', $szFilmName);
			return convert_vi_to_en($szFilmName);
		}
		
function getAllFileInFolder($szFolderName)
{
    $dir = dir($szFolderName); 
	$lsFileName = null;
	$nIndex = 0;
    while (($file = $dir->read()) !== false)
    {
        if ($file != "." && $file != "..")
        {
            $Path = $dir->path."\\" . $file;
			$Path = str_replace('\\', '/', $Path);
            if (filetype($Path) != "dir")
			{
				$lsFileName[$nIndex++] = $file;
            }
        }
    }
    $dir->close();
	return $lsFileName;
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
function casttoclass($class, $object)
{
  return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
}

function ssRename($szName)
{
	$szBuffer = "";
	$nCount = strlen($szName);
	for ($i = 0; $i < $nCount; $i++)
	{
		$nOrd = ord($szName[$i]);
		
		if (($nOrd >= 48 && $nOrd <= 57) || ($nOrd >= 65 && $nOrd <= 90) || ($nOrd >= 97 && $nOrd <= 122) || $szName[$i] == ".")
		{
			$szBuffer .= $szName[$i];
		}
		else if ($szName[$i] == "-" || $szName[$i] == "_")
		{
			$szBuffer .= ".";
		}
	}
	return $szBuffer;
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
