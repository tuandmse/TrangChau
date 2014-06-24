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
                    $photo = '<img src="' . base_url('uploads/images/medium/' . $arr[2]).'.jpg" alt="' . $product->seo_title . '"/>';

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
        endif;
        ?>

        <?php
        if ($postedInfor == false && $postedStyle == false):
        ?>
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active" id="li_infor"><a href="#infor" data-toggle="tab">Thông tin trang phục</a>
                        </li>
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
                                    <div class="control-group">
                                        <label for="<?php
                                            echo $yn->questionNode;
                                        ?>">
                                        <?php
                                            echo $yn->questionContent;
                                        ?>
                                        </label>

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
                        <?php
                        endforeach;
                        ?>
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
                        <?php // echo form_open('adviser', 'class="form-horizontal"');
                        ?>
                        <?php
                        foreach ($cF_node_view as $node_entry):
                            ?>
                                    <div class="control-group">
                                        <label for="<?php
                                        echo $node_entry->nodesNode;
                                        ?>">
                                            <?php
                                            echo $node_entry->nodesContent;
                                            ?>
                                        </label>
                                        <div>


                                            <?php
                                            foreach ($Adviser_cf as $adviserCfs):
                                                ?>


                                                        <input type="radio" name="<?php echo $node_entry->nodesNode;?>" value="<?php echo $adviserCfs->cfValue;?>"> <?php echo $adviserCfs->cfContent;?>






                                            <?php
                                            endforeach;
                                            ?>




                                        </div>
                                    </div>

                        <?php
                        endforeach;
                        ?>
                            <div class="span8">
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="button" value="Back" class="btn btn-danger" onclick="back_page()"/>
                                        <input type="submit" value="Submit" name="submitInfor" class="btn btn-primary"/>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

        <?php endif; ?>
    </div>
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