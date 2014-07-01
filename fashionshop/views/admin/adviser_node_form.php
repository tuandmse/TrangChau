<?php echo form_open($this->config->item('admin_folder') . '/adviser_node/form/' . $nodesNode); ?>
<fieldset>
    <div class="control-group">

        <?php
        if ($nodesNode != '') {
            echo '<label class=\"control-label\" for=\"name\">Đang chỉnh sửa cho nút: <b>' . $nodesNode . '</b></label>';
        }
        ?>
        <div class="controls">
            <?php
            $data = array('name' => 'nodesNode', 'type' => 'hidden', 'value' => set_value('nodesNode', $nodesNode), 'required' => '', 'class' => 'span2', 'maxlength' => '20');
            if ($nodesNode != '') {
                $data['readonly'] = 'readonly';
            }
            echo form_input($data);
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="name">Nội Dung Nút</label>

        <div class="controls">
            <!--            --><?php
            //            $data = array('name' => 'nodesContent', 'value' => set_value('nodesContent', $nodesContent), 'required' => '', 'class' => 'span6');
            //            echo form_input($data);
            //
            ?>
            <?php
            $data = array('name' => 'nodesContent', 'class' => 'redactor', 'value' => set_value('nodesContent', $nodesContent), 'required' => '');
            echo form_textarea($data);
            ?>
        </div>
    </div>


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