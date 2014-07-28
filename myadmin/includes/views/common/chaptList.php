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

<td class="button" id="toolbar-new">
<a href="index.php?chapt=<?php echo $nStoryId; ?>&auto=1" onclick="" class="toolbar">
<span class="icon-32-new" title="Thêm mới">
</span>
Thêm Tự Động
</a>

<a href="index.php?chapt=<?php echo $nStoryId; ?>&watt=1" onclick="" class="toolbar">
<span class="icon-32-new" title="Thêm mới">
</span>
Thêm Từ Wattpad
</a>

</td>
<td class="button" id="toolbar-new">
<a href="index.php?chapt=<?php echo $nStoryId; ?>&create=1" onclick="" class="toolbar">
<span class="icon-32-new" title="Thêm mới">
</span>
Thêm mới
</a>

</td>

</tr></tbody></table>
</div>
				<div class="header icon-48-article">
Danh sách Chương: <small><small> [ <?php echo $storyData[0]->story_title ?> ]</small></small>
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
            <a href="#" title="">Tiêu Đề</a>
            </th>
            <th class="title">
            <a href="#" title="">Nội Dung</a>
            </th>	
			<th class="title" width="10">
            <a href="#" title="">Sửa</a>
            </th>
            <th class="title" width="10">
            <a href="#" title="">Xóa</a>
            </th>
            <th class="title" width="10">
            <a href="#" title="">Xóa Up</a>
            </th>			
        </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="15">

		<del class="container"><div class="pagination">
			<a href="index.php?chapt=<?php echo $nStoryId;?>&page=0">First </a>
			<a href="index.php?chapt=<?php echo $nStoryId;?>&page=<?php echo ($nPage - 1);?>">&nbsp;<&nbsp;</a>
			<?php 
				for ($i=0; $i<2 && $nPage + $i >= 1; $i++)
					echo '<a href="index.php?chapt=' . $nStoryId . '&page='.($nPage - 2 + $i).'">'.($nPage + $i - 1).'</a>&nbsp';
			?>
			<strong><?php echo ($nPage + 1)?></strong>&nbsp;
			<?php 
				for ($i=$nPage+1; $i<$nPage+4 && $i<$nPageTotal + 1; $i++)
					echo '<a href="index.php?chapt=' . $nStoryId . '&page='.$i.'">'.($i+1).'</a>&nbsp';
			?>
			<a href="index.php?chapt=<?php echo $nStoryId;?>&page=<?php echo ($nPage + 1);?>">&nbsp;>&nbsp;</a>
			<a href="index.php?chapt=<?php echo $nStoryId;?>&page=<?php echo $nPageTotal;?>">Last</a>
		</div></del>				

	</td>
    </tr>
    </tfoot>
    
    <tbody>
		<?php
			$i = 0;
			foreach ($chaptList as $k) {
				++$i;
				$szColor = "row0";
				if ($i % 2 == 0)
					$szColor = "row1";
				echo '<tr class="'.$szColor.'">';
				echo '<td>'.$i.'</td>';
				echo '<td align="center">
					 <input id="cb5" name="cid[]" value="5" onclick="" type="checkbox">
					 </td>';
				
				$szFilmName = myTruncate($k->chapt_title, 64);
				echo '<td>'.$szFilmName.'</td>';
				
				$szDesc = myTruncate($k->chapt_content, 120);
				echo '<td style="max-width:800px;overflow:hidden">'.$szDesc.'</td>';				
				
				echo '<td align="center">
					<a href="index.php?chapt=' . $nStoryId . '&edit=' . $k->chapt_id  . '" title="Sửa">Sửa
					</a>
					</td>
					<td align="center">
						<a href="javascript:void(0);" onclick="confirmDelete(\'index.php?chapt=' . $nStoryId . '&del='. $k->chapt_id  .'\');" title="Xóa">Xóa</a>
					</td>	
					<td align="center">
						<a href="javascript:void(0);" onclick="confirmDelete(\'index.php?chapt=' . $nStoryId . '&delup='. $k->chapt_id  .'\');" title="Xóa">Xóa Up</a>
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