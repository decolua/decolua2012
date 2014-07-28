<script>
function confirmDelete(url) {
	Sexy.confirm("<h1>Xác nhận</h1><p>Bạn có chắc chắn muốn xoá vĩnh viễn dữ liệu?</p>", { onComplete: 
		function(returnvalue) {
			if(returnvalue){
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
				<div class="m">
					<div class="toolbar" id="toolbar">
						<table class="toolbar">
							<tbody>
								<tr>
									<td class="button" id="toolbar-delete">
										<a href="#" onclick="" class="toolbar">
											<span class="icon-32-delete" title="Xóa">
											</span>
											Xóa
										</a>
									</td>

									<td class="button" id="toolbar-new">
										<a href="index.php?nav=<?php echo $this->_szAlias; ?>&action=create" onclick="" class="toolbar">
											<span class="icon-32-new" title="Thêm mới">
											</span>
											Thêm mới
										</a>
									</td>

								</tr>
							</tbody>
						</table>
					</div>
					<div class="header icon-48-article">
					Danh sách <?php echo $this->_szTitle; ?>: <small><small> [ Quản lý ]</small></small>
					</div>

					<div class="clr"></div>
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
							<tbody>
								<tr>
								<td width="100%">
									Tiêu đề:
									<input name="a" value="story" type="text" style="visibility:hidden;width:0px"/>
									<input name="search" id="search" class="text_area" onchange="document.adminForm.submit();" title="" type="text">
									<button onclick="">Tìm kiếm</button>
								</td>
								<td nowrap="nowrap"></td>
								</tr>
							</tbody>
						</table>

						<table class="adminlist" cellspacing="1">
							<thead>
								<tr>
									<th width="5">#</th>
									<th width="5">
										<input name="toggle" value="" onclick="" type="checkbox">
									</th>
									<?php
									for ($i=0; $i<count($lsTitle);$i++){
										echo $lsTitle[$i];				
									}
									?>
								</tr>
							</thead>
							
							<!-- Footer -->
							<tfoot>
								<tr>
									<td colspan="15">
										<del class="container">
											<div class="pagination">
												<a href="index.php?nav=<?php echo $this->_szAlias; ?>&page=0">First </a>
												<a href="index.php?nav=<?php echo $this->_szAlias; ?>&page=<?php echo ($nPage - 1);?>">&nbsp;<&nbsp;</a>
												<?php 
													for ($i=0; $i<2 && $nPage + $i >= 1; $i++)
														echo '<a href="index.php?nav=' . $this->_szAlias . '&page='.($nPage - 2 + $i).'">'.($nPage + $i - 1).'</a>&nbsp';
												?>
												<strong><?php echo ($nPage + 1)?></strong>&nbsp;
												<?php 
													for ($i=$nPage+1; $i<$nPage+4 && $i<$nPageTotal + 1; $i++)
														echo '<a href="index.php?nav=' . $this->_szAlias . '&page='.$i.'">'.($i+1).'</a>&nbsp';
												?>
												<a href="index.php?nav=<?php echo $this->_szAlias; ?>&page=<?php echo ($nPage + 1);?>">&nbsp;>&nbsp;</a>
												<a href="index.php?nav=<?php echo $this->_szAlias; ?>&page=<?php echo $nPageTotal;?>">Last</a>
											</div>
										</del>				
									</td>
								</tr>
							</tfoot>
    
							<tbody>   
							<?php
								if (isset($lsData)){
									for ($i=0; $i<count($lsData); $i++){
										$szColor = "row0";
										if ($i % 2 == 1)
											$szColor = "row1";
										echo '<tr class="'.$szColor.'">';	
										for ($j=0; $j<count($lsData[$i]); $j++){
											echo $lsData[$i][$j];	
										}
										echo '</tr>';
									}
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
			<noscript>	Cảnh báo! JavaScript phải được bật trong trình duyệt web (Internet Explorer/ Fire Fox ...)	</noscript>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
</div>