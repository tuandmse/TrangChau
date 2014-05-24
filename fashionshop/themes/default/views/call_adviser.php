

<?php include('header.php');?>
    <div class="row" style="margin-top:20px;">
        <div class="span10 offset2">
            <div class="page-header">
			<h1>
			Hệ Tư Vấn Trang Phục
			</h1>
            </div>
            <?php if( $postedInfor == true ): ?>
                <h3>Cảm ơn sự phản hồi của bạn đến website của chúng tôi  Infor!</h3>
            <?php endif; ?>
			<?php if( $postedStyle == true ): ?>
                <h3>Cảm ơn sự phản hồi của bạn đến website của chúng tôi  Style!</h3>
            <?php endif; ?>
            <?php if( $postedInfor == false && $postedStyle == false ): ?>
			
				<div class="row">
					<div class="span8">
						<div class="tabbable">
						<ul class="nav nav-tabs">
						<li class="active"><a href="#infor" data-toggle="tab">Thông tin trang phục</a></li>
						<li><a href="#style" data-toggle="tab">Chọn kiểu trang phục</a></li>
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
											<label class="" for="height">Chiều cao</label>
											<div>
												<input type="radio" name="weight" value="cao"> Cao
												<input type="radio" name="weight" value="thap"> Thấp
												<input type="radio" name="weight" value="candoi"> Cân Đối
												
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label for="weight">Cân nặng</label>
											<div>
												<input type="radio" name="weight" value="map"> Mập
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
												<input type="submit" value="Submit" name="submitInfor" class="btn btn-primary"/>
											</div>
										</div>
									</div>
								</div>
								
							</form>
				
							</div>
			
							<div class="tab-pane" id="style">
							<?php echo form_open('adviser', 'class="form-horizontal"'); ?>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="congviec">Bạn muốn thể hiện sự nghiêm túc của mình trong công việc ?</label>
											<div>
												<input type="radio" name="congviec" value="no" checked> Không
												<input type="radio" name="congviec" value="little"> Chút ít
												<input type="radio" name="congviec" value="like"> Thích
												<input type="radio" name="congviec" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								
								
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="thanhlich">Bạn muốn diện những bộ đồ thanh lịch ?</label>
											<div>
												<input type="radio" name="thanhlich" value="no" checked> Không
												<input type="radio" name="thanhlich" value="little"> Chút ít
												<input type="radio" name="thanhlich" value="like"> Thích
												<input type="radio" name="thanhlich" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="quyenru">Bạn muốn gây vẻ quyến rũ của mình tới mọi người ?</label>
											<div>
												<input type="radio" name="quyenru" value="no" checked> Không
												<input type="radio" name="quyenru" value="little"> Chút ít
												<input type="radio" name="quyenru" value="like"> Thích
												<input type="radio" name="quyenru" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="catinh">Bạn muốn thể hiện cá tính của mình ?</label>
											<div>
												<input type="radio" name="catinh" value="no" checked> Không
												<input type="radio" name="catinh" value="little"> Chút ít
												<input type="radio" name="catinh" value="like"> Thích
												<input type="radio" name="catinh" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="nhenhang">Bạn muốn diện bộ đồ mang tính nhẹ nhàng ?</label>
											<div>
												<input type="radio" name="nhenhang" value="no" checked> Không
												<input type="radio" name="nhenhang" value="little"> Chút ít
												<input type="radio" name="nhenhang" value="like"> Thích
												<input type="radio" name="nhenhang" value="verylike">Rất thích                   
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="tretrung">Bạn muốn mình trở nên trẻ trung hơn trong bộ đồ ?</label>
											<div>
												<input type="radio" name="tretrung" value="no" checked> Không
												<input type="radio" name="tretrung" value="little"> Chút ít
												<input type="radio" name="tretrung" value="like"> Thích
												<input type="radio" name="tretrung" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="sanhdieu">Bạn muốn thể hiện mình là người sành điệu?</label>
											<div>
												<input type="radio" name="sanhdieu" value="no" checked> Không
												<input type="radio" name="sanhdieu" value="little"> Chút ít
												<input type="radio" name="sanhdieu" value="like"> Thích
												<input type="radio" name="sanhdieu" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="hoatdong">Bạn muốn diện bộ đồ có thể dễ dàng tham gia các hoạt động ?</label>
											<div>
												<input type="radio" name="hoatdong" value="no" checked> Không
												<input type="radio" name="hoatdong" value="little"> Chút ít
												<input type="radio" name="hoatdong" value="like"> Thích
												<input type="radio" name="hoatdong" value="verylike">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="span8">
										<div class="control-group">
											<label class="control-label" for=""></label>
											<div class="controls">
												<input type="submit" value="Submit" name="submitStyle" class="btn btn-primary"/>
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
<?php include('footer.php');?>