

<?php
include('header.php');
?>
    <div class="row" style="margin-top:20px;">
        <div class="span10 offset2">
            <div class="page-header">
			<h1>
			Hệ Tư Vấn Trang Phục
			</h1>
            </div>
            <?php
if ($postedInfor == true):
?>
                <h3> Kết Quả Tư Vấn !</h3>
				<h4>
				<?php
    echo $advice;
?>
				</h4>
            	<?php
    foreach ($products_image as $product):
      
	    $photo  = theme_img('no_picture.png', lang('no_image_available'));

		 if(!empty($product->images[0]))
            {
                $arr   = preg_split('#(:|,|[\{]|[\}]|"|[\|]{2})#', $product->images);
        $photo = '<img src="' . base_url('uploads/images/thumbnails/' . $arr[2]) . '.jpg" alt="' . $product->seo_title . '"/>';

			}
?>
					    <div class="product-image">
                            <a class="thumbnail" href="<?php
        echo site_url(implode('/', $base_url) . '/' . $product->slug);
?>">
                                <?php
        echo $photo;
?>
                            </a>
                        </div>
					   <?php
    endforeach;
?>
			<?php
endif;
?>
            <?php
if ($postedInfor == false && $postedStyle == false):
?>
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
								<?php
    echo form_open('adviser', 'class="form-horizontal"');
?>
								 <?php
    foreach ($question_view as $yn):
?>	
									<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="<?php
        echo $yn->questionNode;
?>"><?php
        echo $yn->questionContent;
?></label>
											<div>
											
										<?php
        foreach ($node_view as $a):
?>
                                        <?php
            if ($yn->questionNode == $a->questionNode):
                echo '<input type="radio" name="' . $a->questionNode . '" value="' . $a->nodesNode . '"> ' . $a->nodesContent . '';
                
?>
			                             <?php
            endif;
?>
										<?php
        endforeach;
?>
											</div>
										</div>
									</div>
								</div>
								
								<?php
    endforeach;
?>
								
				
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
							
							</div>
							<div class="tab-pane" id="style">
							<?php // echo form_open('adviser', 'class="form-horizontal"'); 
?>
								 <?php
    foreach ($cF_node_view as $node_entry):
?>					

									<div class="row">
									<div class="span8">
										<div class="control-group">
											<label  for="<?php
        echo $node_entry->nodesNode;
?>"><?php
        echo $node_entry->nodesContent;
?></label>
											<div>
												<input type="radio" name="<?php
        echo $node_entry->nodesNode;
?>" value="0"> Không
												<input type="radio" name="<?php
        echo $node_entry->nodesNode;
?>" value="0.6"> Chút ít
												<input type="radio" name="<?php
        echo $node_entry->nodesNode;
?>" value="0.8"> Thích
												<input type="radio" name="<?php
        echo $node_entry->nodesNode;
?>" value="1">Rất thích                    
											</div>
											
										</div>
									</div>
								</div>
								
								<?php
    endforeach;
?>
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
			<?php
endif;
?>
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
	
<?php
include('footer.php');
?>