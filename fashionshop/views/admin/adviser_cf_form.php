<?php echo form_open($this->config->item('admin_folder') . '/adviser_cf/form/' . $cfId); ?>
<fieldset>
    <div class="control-group">

        <?php
        if ($cfId != '') {
            echo '<label class=\"control-label\" for=\"name\">Đang chỉnh sửa cho chỉ số: <b>' . $cfId . '</b></label>';
        }
        ?>
        <div class="controls">
            <?php
            $data = array('name' => 'cfId', 'type' => 'hidden', 'value' => set_value('cfId', $cfId), 'required' => '', 'class' => 'span2', 'maxlength' => '10');
            if ($cfId != '') {
                $data['readonly'] = 'readonly';
            }
            echo form_input($data);
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="name">Nội Dung Chỉ Số</label>

        <div class="controls">
            <!--            --><?php
            //            $data = array('name' => 'nodesContent', 'value' => set_value('nodesContent', $nodesContent), 'required' => '', 'class' => 'span6');
            //            echo form_input($data);
            //
            ?>
            <?php
            $data = array('name' => 'cfContent', 'class' => 'span4', 'value' => set_value('cfContent', $cfContent), 'required' => '');
            echo form_input($data);
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="name">Giá Trị Chỉ Số</label>

        <div class="controls">
            <?php
            $data = array('name' => 'cfValue', 'class' => 'span4', 'value' => set_value('cfValue', $cfValue), 'required' => '');
            echo form_input($data);
            ?>
        </div>
    </div>

    <!--    <div class="control-group">-->
    <!--        <label class="control-label" for="name">Gán Nút Vào Câu Hỏi</label>-->
    <!---->
    <!--        <div class="controls">-->
    <!--            --><?php
    //            $options = array('CF' => 'CF',
    //                'YN' => 'YN'
    //            );
    //            echo form_dropdown('questionType', $options, set_value('questionType', $questionType));
    //
    ?>
    <!--        </div>-->
    <!--    </div>-->

    <hr>
    <div class="control-group">
        <label class="control-label" for="password"></label>

        <div class="controls">
            <input type="submit" value="Submit" name="submit" class="btn btn-primary"/>
        </div>
    </div>
</fieldset>
</form>
<script type="text/javascript">
    $('form').submit(function () {
        $('.btn').attr('disabled', true).addClass('disabled');
    });
</script>