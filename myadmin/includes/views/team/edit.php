<style>
	#tbCreate td{
		font-weight:bold;
		left:0px;
		padding-left:20px;
		padding-right:20px;
	}
	
	.w250 {
		width:350px;
	}
	
	.w500 {
		width:400px;
	}	
</style>

<div id="content-box">
		<div class="border">
			<div class="padding">
				<div id="toolbar-box">
   			<div class="t">

				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">
<table class="toolbar"><tbody><tr>
</tr></tbody></table>
</div>
				<div class="header icon-48-article">
Edit Team Info: <small>[ Edit Team ]</small>
</div>
				<div class="clr"></div>
			</div>
			<div class="b">

				<div class="b">
					<div class="b"></div>
				</div>
			</div>
  		</div>
   		<div class="clr"></div>

<div id="error_container" style="display:none">
<dl id="system-message">
<dt class="message">Cảnh báo</dt>
<dd class="message notice fade">
	<ul>
		<li>Hãy điền vào các thông tin cần thiết cho các dấu Sao (*)</li>

	</ul>
</dd>
</dl>
</div>
		<div id="element-box">
			<div class="t">
		 		<div class="t">

					<div class="t"></div>
		 		</div>
			</div>
			<div class="m">
						
			<form action="/myadmin/index.php?nav=team&action=update" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
					<input name="team_id" value="<?php echo $nId; ?>" type="hidden">
					<center>
					<table id="tbCreate" border="0" cellpadding="0" cellspacing="0">

					<tbody>
					<tr>
						<td valign="top" style="background-color:#E9E9E9">
							<table class="adminform">
								
								<tbody>
								<center> <h2> Edit Team Info </h2> </center>
								<tr>
									<td width="150px" style="text-align:right"> Name <span class="require">(*)</span>	</td>
									<td>
										<input class="w250" name="team_name" size="60" maxlength="255" type="text" value="<?php echo $pData[0]->team_name ?>" />
									</td>
								</tr>
								
								<tr>
									<td width="150px" style="text-align:right"> League <span class="require">(*)</span>	</td>
									<td>
										<select name="league_id">
										<?php 
											for ($i=0; $i<count($pLeague); $i++){
												echo '<option value="' . $pLeague[$i]->league_id . '">' . $pLeague[$i]->league_name . '</option>';
											}
										?>
										</select>
									</td>
								</tr>								
								
								<tr>
									<td width="150px" style="text-align:right"> Avatar <span class="require"></span>	</td>
									<td>
										<img src="/images/team/<?php echo $pData[0]->team_id ?>.png" style="width:50px; height:50px" />
									</td>
								</tr>

								<tr>
									<td width="150px" style="text-align:right"> Fetch URL <span class="require"></span>	</td>
									<td>
										<input class="w250" name="fetch_url" size="60" maxlength="255" type="text" value=""/>
									</td>
								</tr>	
								
								<tr>
									<td width="150px" style="text-align:right"> Short Name <span class="require"></span>	</td>
									<td>
										<input class="w250" name="team_short_name" size="60" maxlength="255" type="text" value="<?php echo $pData[0]->team_short_name ?>"/>
									</td>
								</tr>	

								<tr>
									<td width="150px" style="text-align:right"> City<span class="require"></span>	</td>
									<td>
										<input class="w250" name="team_city" size="60" maxlength="255" type="text" value="<?php echo $pData[0]->team_city ?>"/>
									</td>
								</tr>

								<tr>
									<td width="150px" style="text-align:right"> Stadium <span class="require"></span>	</td>
									<td>
										<input class="w250" name="team_stadium" size="60" maxlength="255" type="text" value="<?php echo $pData[0]->team_stadium ?>"/>
									</td>
								</tr>	
								
								<tr>
									<td width="150px" style="text-align:right"> Num Of Fans <span class="require"></span>	</td>
									<td>
										<input name="team_fans_num" size="10" maxlength="100" type="text" value="<?php echo $pData[0]->team_fans_num ?>"/>
									</td>
								</tr>									
								
								<tr>
									<td width="150px" style="text-align:right"> Visible <span class="require"></span>	</td>
									<td>
										<input name="team_visible"  type="checkbox" <?php if ($pData[0]->team_visible != 0) echo "checked" ?>/>
									</td>
								</tr>																	

								<tr>
									<td>
									</td>
									<td> <input value="Update" type="submit"> </td>
								</tr>

								</tbody>
							</table>
						</td>
					   
					</tr>
					</tbody></table>
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
		<noscript>
			Cảnh báo! JavaScript phải được bật trong trình duyệt web (Internet Explorer/ Fire Fox ...)	</noscript>
		<div class="clr"></div>

	</div>
	<div class="clr"></div>
</div>


</div>  