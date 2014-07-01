<div class="row">
    <?php foreach ($banners as $banner): ?>
        <div class="span3">
            <div class="cate-container" style="position: relative">
                <?php

                $box_image = '<img class="responsiveImage" src="' . base_url('uploads/' . $banner->image) . '" />';
                if ($banner->link != '') {
                    $target = false;
                    if ($banner->new_window) {
                        $target = 'target="_blank"';
                    }
                    echo '<a href="' . $banner->link . '" ' . $target . ' >' . $box_image . '</a>';
                } else {
                    echo $box_image;
                }
                ?>

                <?php if ($banner->name): ?>
                    <!--            <div class="box-caption">-->
                    <!--                <h4>--><?php //echo $banner->name ?><!--</h4>-->
                    <!--            </div>-->
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>