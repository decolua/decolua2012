<?php 
session_start();
unset($_SESSION['logged']); 
unset($_SESSION['mod']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
<meta name="robots" content="index, follow">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="generator" content="">
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.login.un.select();
		document.login.un.focus();
	}
</script>
</head>
<body onload="javascript:setFocus()">
	<div id="border-top" class="h_green">
		<div class="h_green_right">
			<div class="h_green_left">
				<!--<div class="title">FootballChallenger.net - Hệ thống Quản trị</div>-->
			</div>
		</div>
	</div>

	<div id="content-box">
		<div class="padding">
			<div id="element-box" class="login">
				<div class="t">
					<div class="t">
						<div class="t"></div>
					</div>
				</div>
				<div class="m">

					<!--<h1>FootballChallenger.net - Đăng nhập hệ thống!</h1>-->
					
							<div id="section-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
		 		</div>
	 		</div>
			<div class="m">
				<form action="index.php" method="post" name="login" id="form-login" style="clear: both;">
					<center>
					<p id="form-login-username">
						<label for="modlgn_username">User</label>
						<input name="un" id="un" type="text" class="inputbox" size="15">
					</p>

					<p id="form-login-password">
						<label for="modlgn_passwd">Pass</label>
						<input name="pw" id="pw" type="password" class="inputbox" size="15">  
					</p>
						
					<div class="button_holder">
					<div class="button1">

						<div class="next">
							<a onclick="login.submit();">
							<button>
								Login
							</button>
							</a>
						</div>
					</div>
					</div>
					<div class="clr"></div>
					<input type="submit" style="border: 0; padding: 0; margin: 0; width: 0px; height: 0px;" value="Login">

					<input type="hidden" name="task" value="login">
					</center>
				</form>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
		 			<div class="b"></div>
				</div>

			</div>
		</div>
				
					<!--<p>Sử dụng Tên truy cập và Mật khẩu hợp lệ để đăng nhập hệ thống quản trị.</p>
					<p>
						<a href="#">Trở về Trang chủ</a>
					</p>-->
					<div id="lock"></div>
					<div class="clr"></div>

				</div>
				<div class="b">
					<div class="b">
						<div class="b"></div>
					</div>
				</div>
			</div>
			<noscript>
				Cảnh báo! JavaScript phải được bật trong trình duyệt web (Internet Explorer/ Fire Fox ...)			</noscript>

			<div class="clr"></div>
		</div>
	</div>
	<div id="border-bottom"><div><div></div></div>
</div>
<!--
<div id="footer">
	<p class="copyright">
		Phát triển bởi <a href="http://FootballChallenger.net/" target="_blank">FootballChallenger.net</a>
     </p>

</div>
-->


</body></html>