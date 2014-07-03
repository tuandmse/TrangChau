<div class="row" style="margin-top:20px;">

    <div class="span12">
        <div class="page-header">
            <h1>
                Hệ Tư Vấn Trang Phục
            </h1>
        </div>
        <?php
        if ($postedInfor == true): ?>
            <h2>Kết quả tư vấn của bạn: </h2>
            <div class="comment_user" style="font-size: 15px">
                <?php
                echo $advice;
                ?>


            </div>
            <?php
            foreach ($products_image as $product):

                $photo = theme_img('no_picture.png', lang('no_image_available'));

                if (!empty($product->images[0])) {
                    $arr = preg_split('#(:|,|[\{]|[\}]|"|[\|]{2})#', $product->images);
                    $photo = '<img src="' . base_url('uploads/images/medium/' . $arr[2]) . '.jpg" alt="' . $product->seo_title . '"/>';

                }
                ?>
                <div class="product-image" style="margin-top: 20px">
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
            echo form_open('adviser_eval', 'class="form-horizontal"');
            ?>
            <br/>
            <h2>Hãy gửi đánh giá của bạn cho chúng tôi. Cám ơn ! </h2>
            <div class="control-group eval-group">
                <ul style="list-style-type: none;">
                        <li>
                            <label class="input-control radio" onclick="">
                                <input type="radio" name="eval" value="1">
                                <span class="answer-quiz">Rất Chính Xác</span>
                            </label>
                        </li>
                </ul>
                <ul style="list-style-type: none;">
                    <li>
                        <label class="input-control radio" onclick="">
                            <input type="radio" name="eval" value="0.8">
                            <span class="answer-quiz">Chính Xác</span>
                        </label>
                    </li>
                </ul>
                <ul style="list-style-type: none;">
                    <li>
                        <label class="input-control radio" onclick="">
                            <input type="radio" name="eval" value="0.6">
                            <span class="answer-quiz">Bình Thường</span>
                        </label>
                    </li>
                </ul>
                <ul style="list-style-type: none;">
                    <li>
                        <label class="input-control radio" onclick="">
                            <input type="radio" name="eval" value="0.4">
                            <span class="answer-quiz">Không Chính Xác</span>
                        </label>
                    </li>
                </ul>
                <ul style="list-style-type: none;">
                    <li>
                        <label class="input-control radio" onclick="">
                            <input type="radio" name="eval" value="0.2">
                            <span class="answer-quiz">Rất Không Chính Xác</span>
                        </label>
                    </li>
                </ul>
                <ul style="list-style-type: none;">
                    <li>
                        <label class="input-control radio" onclick="">
                            <input type="radio" name="eval" value="0">
                            <span class="answer-quiz">Rất Tệ</span>
                        </label>
                    </li>
                </ul>
                <input type="hidden" name="selected"
                       value="<?php echo htmlspecialchars("$evaluationSelected", ENT_QUOTES); ?>">
                <input type="hidden" name="conclusion"
                       value="<?php echo htmlspecialchars("$evaluationConclusion", ENT_QUOTES); ?>">
            </div>
            <div class="span8">
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" value="Submit" name="submitEval" class="btn btn-primary"/>
                    </div>

                </div>
            </div>
            </form>
        <?php endif; ?>
        <?php echo form_open('adviser', 'class="form-horizontal"');
            if ($postedInfor == false && $postedStyle == false): ?>
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active" id="li_infor"><a href="#infor" class="infor-style" data-toggle="tab">Thông tin trang phục</a></li>
                    <li class="" id="li_style"><a href="#style" class="infor-style" data-toggle="tab">Chọn kiểu trang phục</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="infor">
                    <?php foreach ($question_view as $yn): ?>
                        <div class="control-group question-group">
                            <h3 style="margin-bottom:10px"><?php echo $yn->questionContent; ?></h3>
                            <ul style="list-style-type: none;">
                                <?php foreach ($node_view as $a):
                                    if ($yn->questionNode == $a->questionNode): ?>
                                        <li>
                                            <label class="input-control radio" onclick="">
                                                <input type="radio" name="<?php echo $a->questionNode; ?>" value="<?php echo $a->nodesNode; ?>">
                                                <span class="answer-quiz"><?php echo $a->nodesContent; ?></span>
                                            </label>
                                        </li>
                                    <?php endif;
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                    <div class="span8">
                        <div class="control-group">
                            <label class="control-label" for=""></label>
                            <div class="controls">
                                <input type="button" value="Next" class="btn btn-danger" onclick="next_page()"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="style">
                    <?php foreach ($cF_node_view as $node_entry): ?>
                        <div class="control-group question-group">
                            <h3 style="margin-bottom:10px"><?php echo $node_entry->nodesContent; ?></h3>
                            <ul style="list-style-type: none;">
                                <?php foreach ($Adviser_cf as $adviserCfs): ?>
                                        <li>
                                            <label class="input-control radio" onclick="">
                                                <input type="radio" name="<?php echo $node_entry->nodesNode; ?>" value="<?php echo $adviserCfs->cfValue; ?>">
                                                <span class="answer-quiz"><?php echo $adviserCfs->cfContent; ?></span>
                                            </label>
                                        </li>
                                 <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                    <div class="span8">
                        <div class="control-group">
                            <div class="controls">
                                <input type="button" value="Back" class="btn btn-danger" onclick="back_page()"/>
                                <input type="submit" value="Submit" name="submitInfor" class="btn btn-primary"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
    </form>
</div>
<script type="text/javascript">
    function next_page() {
        document.getElementById("style").className = "tab-pane active";
        document.getElementById("li_style").className = "active";
        document.getElementById("infor").className = "tab-pane";
        document.getElementById("li_infor").className = " ";

    }
    function back_page() {
        document.getElementById("style").className = "tab-pane";
        document.getElementById("li_style").className = " ";
        document.getElementById("infor").className = "tab-pane active";
        document.getElementById("li_infor").className = "active";

    }
</script>