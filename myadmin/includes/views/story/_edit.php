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
Thêm truyện mới: <small>[ Thêm mới ]</small>
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
						

<form action="index.php?a=story&save=1" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
		<input name="id" value="<?php echo $nCatID; ?>" type="hidden">
		<center>
		<table id="tbCreate" border="0" cellpadding="0" cellspacing="0">

		<tbody>
		<tr>
			<td valign="top" style="background-color:#E9E9E9">
				<table class="adminform">
					
					<tbody>
					<center> <h2> Sửa thông tin truyện  </h2> </center>
					<tr>
						<td width="150px" style="text-align:right"> Tên truyện <span class="require">(*)</span>	</td>
						<td>
							<input class="w250" name="story_title" id="name" size="60" maxlength="255" type="text" value="<?php echo $storyData[0]->story_title ?>" />
						</td>
					</tr>
					
					<tr>
						<td width="150px" style="text-align:right"> Hình ảnh </td>
						<td>
							<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
							<input name="file" id="file" type="file" />
						</td>
					</tr>					
					
					<tr>
						<td style="text-align:right"> Thêm thể loại </td>
						<td>
							<select id="cbTheLoai" onChange="themTheLoai()">
							<?php 
								echo '<option value="">...</option>';
								foreach ($rs as $k) {
									echo '<option value="' . $k->category_alias . '">' . $k->category_name . '</option>';
								}
							?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td style="text-align:right"> Thể Loại <span class="require">(*)</span>	</td>
						<td>
							<input class="w250" name="story_cat_name" id="theloai" readonly="readonly"  size="51" maxlength="255" type="text" value="<?php echo $storyData[0]->story_cat_name ?>"/>
							<input class="w250" name="story_cat_alias" id="category" hidden="true" value="<?php echo $storyData[0]->story_cat_alias ?>"/>
							<input size="10" type="submit" value="Xóa" onclick="return xoaTheLoai();"/>
						</td>						
					</tr>

					<tr>
						<td style="text-align:right"> Tóm tắt </td>
						<td>
							<textarea class="w250" name="story_desc" id="storyDesc" rows="6"><?php echo $storyData[0]->story_desc ?></textarea>
						</td>
					</tr>							
							
					<tr>
						<td width="150px" style="text-align:right"> Trạng Thái </td>
						<td>
							<select name="story_status">
								<option value="Còn Tiếp" <?php if ($storyData[0]->story_cat_alias=="Còn Tiếp") echo 'selected' ?> > Còn Tiếp </option>
								<option value="Full" <?php if ($storyData[0]->story_cat_alias=="Full") echo 'selected' ?>> Full </option>
								<option value="Tạm Ngưng" <?php if ($storyData[0]->story_cat_alias=="Tạm Ngưng") echo 'selected' ?>> Tạm Ngưng </option>
							</select>						
						</td>
					</tr>		

					<tr>
						<td width="150px" style="text-align:right"> Tác Giả </td>
						<td>
							<input class="w250" name="story_author_name" id="author" size="60" maxlength="255" type="text" value="<?php echo $storyData[0]->story_author_name ?>"/>
						</td>
					</tr>	
					
					<tr>
						<td width="150px" style="text-align:right"> Youtube Clip </td>
						<td>
							<input class="w250" name="story_clip" id="clip" size="60" maxlength="255" type="text" value="<?php echo $storyData[0]->story_clip ?>"/>
						</td>
					</tr>					
							
					<tr>
						<td>
						</td>
						<td> <input value="Thêm mới" type="submit"> </td>
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