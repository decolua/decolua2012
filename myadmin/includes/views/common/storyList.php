  	<script>
		function confirmDelete(url) {
			Sexy.confirm("<h1>Xác nhận</h1><p>Bạn có chắc chắn muốn xoá vĩnh viễn dữ liệu?</p>", { onComplete: 
				function(returnvalue) {
				  if(returnvalue)
				  {
					location.href=url;
				  }
				  
				}
			  });
		}
	</script>

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

<td class="button" id="toolbar-delete">
<a href="#" onclick="" class="toolbar">
<span class="icon-32-delete" title="Xóa">
</span>
Xóa
</a>
</td>

<td class="button" id="toolbar-new">
<a href="index.php?a=story&create=1" onclick="" class="toolbar">
<span class="icon-32-new" title="Thêm mới">
</span>
Thêm mới
</a>

</td>

</tr></tbody></table>
</div>
				<div class="header icon-48-article">
Danh sách truyện: <small><small> [ Quản lý ]</small></small>
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
				
<div id="element-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>

    </div>
    <div class="m">
<form action="index.php?a=story&search" method="GET" name="adminForm" id="adminForm">
    <table>
        <tbody><tr>
            <td width="100%">
                Tiêu đề:
				<input name="a" value="story" type="text" style="visibility:hidden;width:0px"/>
                <input name="search" id="search" class="text_area" onchange="document.adminForm.submit();" title="" type="text">
				
                <button onclick="">Tìm kiếm</button>
            </td>
            <td nowrap="nowrap">
			</td>

        </tr>
    </tbody></table>

	<table class="adminlist" cellspacing="1">
    <thead>
        <tr>
            <th width="5">#</th>
            <th width="5">
                <input name="toggle" value="" onclick="" type="checkbox">
            </th>
            <th class="title">
            <a href="#" title="">Tên</a>
            </th>
            <th class="title">
            <a href="#" title="">Lên Top</a>
            </th>			
            <th class="title">
            <a href="#" title="">Tóm tắt</a>
            </th>			
            <th class="title">
            <a href="#" title="">Số Chương</a>
            </th>			
            <th class="title">
            <a href="#" title="">Hiển Thị</a>
            </th>
			<th class="title">
            <a href="#" title="">Hot</a>
            </th>	
			<th class="title">
            <a href="#" title="">hiện QC</a>
            </th>			
            <th class="title">
            <a href="#" title="">Tác Giả</a>
            </th>				
            <th class="title">
            <a href="#" title="">Thể loại</a>
            </th>
            <th class="title">
            <a href="#" title="">Image</a>
            </th>
            <th class="title">
            <a href="#" title="">Clip</a>
            </th>			
			<th class="title" width="10">
            <a href="#" title="">Sửa</a>
            </th>
            <th class="title" width="10">
            <a href="#" title="">Xóa</a>
            </th>
            <th class="title" width="10">
            <a href="#" title="">Xóa Chương</a>
            </th>			
        </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="15">

		<del class="container"><div class="pagination">
			<a href="index.php?a=story&page=0">First </a>
			<a href="index.php?a=story&page=<?php echo ($nPage - 1);?>">&nbsp;<&nbsp;</a>
			<?php 
				for ($i=0; $i<2 && $nPage + $i >= 1; $i++)
					echo '<a href="index.php?a=story&page='.($nPage - 2 + $i).'">'.($nPage + $i - 1).'</a>&nbsp';
			?>
			<strong><?php echo ($nPage + 1)?></strong>&nbsp;
			<?php 
				for ($i=$nPage+1; $i<$nPage+4 && $i<$nPageTotal + 1; $i++)
					echo '<a href="index.php?a=story&page='.$i.'">'.($i+1).'</a>&nbsp';
			?>
			<a href="index.php?a=story&page=<?php echo ($nPage + 1);?>">&nbsp;>&nbsp;</a>
			<a href="index.php?a=story&page=<?php echo $nPageTotal;?>">Last</a>
		</div></del>				

	</td>
    </tr>
    </tfoot>
    
    <tbody>
		<?php
			$i = 0;
			foreach ($storyList as $k) {
				++$i;
				$szColor = "row0";
				if ($i % 2 == 0)
					$szColor = "row1";
				echo '<tr class="'.$szColor.'" height="70px">';
				echo '<td>'.$i.'</td>';
				echo '<td align="center">
					 <input id="cb5" name="cid[]" value="5" onclick="" type="checkbox">
					 </td>';
				
				$szFilmName = myTruncate($k->story_title, 64);
				echo '<td>'.$szFilmName.'</td>';
				
				echo '<td width="100px" align="center">
					<a href="index.php?a=story&top=' . $k->story_id  . '" title="Up Top">Up</a>  
					<a href="index.php?a=story&top=' . $k->story_id  . '&down=1" title="Up Down">Down</a>
					</td>';
				
				$szDesc = myTruncate($k->story_desc, 20);
				echo '<td>'.$szDesc.'</td>';				

				echo '<td style="text-align:center"> <a href="index.php?chapt=' . $k->story_id . '"> ' . $k->story_chapt_total . ' tập (thêm) </a> </td>';
				if ($k->story_visible == 0)
					$szImgSrc = '<a href="index.php?a=story&visible=' . $k->story_id . '&page=' . $nPage . '"> <img src="images/publish_r.png"/> </a>';
				else if ($k->story_visible == 1)
					$szImgSrc = '<a href="index.php?a=story&visible=' . $k->story_id . '&page='  .$nPage . '"> <img src="images/publish_g.png"/> </a>';
				else 
					$szImgSrc = '<a href=""> Chờ duyệt </a>';
				echo '<td width="20px">'.$szImgSrc.'</td>';
				
				if ($k->story_hot == 0)
					$szImgSrc = '<a href="index.php?a=story&hot=' . $k->story_id . '&page=' . $nPage . '"> <img src="images/publish_r.png"/> </a>';
				else if ($k->story_hot == 1)
					$szImgSrc = '<a href="index.php?a=story&hot=' . $k->story_id . '&page='  .$nPage . '"> <img src="images/publish_g.png"/> </a>';
				echo '<td width="20px">'.$szImgSrc.'</td>';
					
				if ($k->story_ads == 0)
					$szImgSrc = '<a href="index.php?a=story&ads=' . $k->story_id . '&page=' . $nPage . '"> <img src="images/publish_r.png"/> </a>';
				else if ($k->story_ads == 1)
					$szImgSrc = '<a href="index.php?a=story&ads=' . $k->story_id . '&page='  .$nPage . '"> <img src="images/publish_g.png"/> </a>';						
				echo '<td width="20px">'.$szImgSrc.'</td>';				
				
				echo '<td>'. $k->story_author_name . '</td>';
				echo '<td>'. $k->story_cat_name . '</td>';
				
				$defaultRootFolder = "../images/story/";
				if ($k->story_image == "" || !is_file($defaultRootFolder . $k->story_image))
					$szBuffer = 'Upload Hình';
				else
					$szBuffer = '<img title="Click vào để Up hình mới" src="../images/story/' . $k->story_image . '" width="50px" height="70px"/>';
				echo '<td width="50px" style="text-align:center"><a target="_blank" href="index.php?a=story&edit=' . $k->story_id  . '">' .$szBuffer. '</a></td>';
				
				echo '<td>'. $k->story_clip . '</td>';
				echo '<td align="center">
					<a href="index.php?a=story&edit=' . $k->story_id  . '" title="Sửa">Sửa
					</a>
					</td>
					<td align="center">
						<a href="javascript:void(0);" onclick="confirmDelete(\'index.php?a=story&del='. $k->story_id  .'\');" title="Xóa">Xóa</a>
					</td>';	
				echo '<td align="center">
						<a href="javascript:void(0);" onclick="confirmDelete(\'index.php?a=story&delchapt='. $k->story_id  .'\');" title="Xóa">Xóa Chương</a>
					</td>';						
				echo '</tr>';				
				echo '</tr>';
			}
		?>	    
    	</tbody>
    </table>
            

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
			Cảnh báo! JavaScript phải được bật trong trình duyệt web (Internet Explorer/ Fire Fox ...)		</noscript>

		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>
</div>