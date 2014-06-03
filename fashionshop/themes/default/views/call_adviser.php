

<?php include('header.php');?>
    <div class="row" style="margin-top:20px;">
        <div class="span10 offset2">
            <div class="page-header">
			<h1>
			Hệ Tư Vấn Trang Phục
			</h1>
            </div>
            <?php if( $postedInfor == true ): ?>
                <h3> Infor Results !</h3>
            <?php endif; ?>
			<?php if( $postedStyle == true ): ?>
                <h3>Style Results!</h3>
            <?php endif; ?>
            <?php if( $postedInfor == false && $postedStyle == false ): ?>
			
				<div class="row">
					<div class="span8">
						<div class="tabbable">
						<ul class="nav nav-tabs">
						<li class="active" id="li_infor"><a href="#infor" data-toggle="tab">Thông tin trang phục</a></li>
						<li class="" id="li_style"><a href="#style" data-toggle="tab">Chọn kiểu trang phục</a></li>
						</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="infor">
								<?php echo form_open('adviser', 'class="form-horizontal"'); ?>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="gender">Bạn thuộc giới tính nào ?</label>
											<div>
												<input type="radio" name="gender" value="male" checked> Nam
												<input type="radio" name="gender" value="female"> Nữ                   
											</div>
											
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="age">Bạn thuộc nhóm tuổi nào ?</label>
											<div>
												<input type="radio" name="age" value="treem" checked> Trẻ em
												<input type="radio" name="age" value="thanhnien"> Thanh niên
												<input type="radio" name="age" value="trungnien"> Trung niên
											</div>
											
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label for="height">Chiều cao</label>
											<div>
												<input type="radio" name="height" value="cao" checked> Cao
												<input type="radio" name="height" value="thap"> Thấp
												<input type="radio" name="height" value="candoi"> Cân Đối
												
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label for="weight">Cân nặng</label>
											<div>
												<input type="radio" name="weight" value="map" checked> Mập
												<input type="radio" name="weight" value="gay"> Gầy
												<input type="radio" name="weight" value="candoi"> Cân Đối
												
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="skin">Bạn có nước da trắng hay ngăm đen ?</label>
											<div>
												<input type="radio" name="skin" value="white" checked> Trắng
												<input type="radio" name="skin" value="black"> Ngăm Đen
												
											</div>
											
										</div>
									</div>
								</div>
				
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label class="control-label" for=""></label>
											<div class="controls">
												<input type="button" value="Next" class="btn btn-danger" onclick="next_page()" />
											</div>
										</div>
									</div>
								</div>
							</form>
							</div>
							<div class="tab-pane" id="style">
							<?php echo form_open('adviser', 'class="form-horizontal"'); ?>
								 <?php foreach($entries as $entry): ?>
									
									<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="<?php echo $entry->nodesNode; ?>"><?php echo $entry->nodesContent; ?></label>
											<div>
												<input type="radio" name="<?php echo $entry->nodesNode; ?>" value="no" checked> Không
												<input type="radio" name="<?php echo $entry->nodesNode; ?>" value="little"> Chút ít
												<input type="radio" name="<?php echo $entry->nodesNode; ?>" value="like"> Thích
												<input type="radio" name="<?php echo $entry->nodesNode; ?>" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								
								<?php endforeach; ?>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<div class="controls">
												<input type="button" value="Back" class="btn btn-danger" onclick="back_page()"/>
												<input type="submit" value="Submit" name="submitInfor" class="btn btn-primary"/>
											</div>
											
										</div>
									</div>
								</div>
							</form>
							</div>
						</div>
			
					</div>
				</div>
				
		</div>
			<?php endif; ?>
    </div>
	<script type="text/javascript">
  
    function next_page()
    {
	   document.getElementById("style").className ="tab-pane active";
	   document.getElementById("li_style").className ="active";
		document.getElementById("infor").className ="tab-pane";
	 	document.getElementById("li_infor").className =" ";

    }
	 function back_page()
    {
	   document.getElementById("style").className ="tab-pane";
	   document.getElementById("li_style").className =" ";
		document.getElementById("infor").className ="tab-pane active";
	 	document.getElementById("li_infor").className ="active";

    }
	

</script>
	
<?php include('footer.php');?>