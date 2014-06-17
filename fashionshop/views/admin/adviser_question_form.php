<?php echo form_open($this->config->item('admin_folder') . '/adviser_question/form/' . $questionNode); ?>
<fieldset>
    <div class="control-group">
        <?php
        if ($questionNode != '') {
            echo '<label class="control-label" for="questionNode">Đang chỉnh sửa cho câu hỏi: <b>' . $questionNode . '</b></label>';
        }
        ?>

        <div class="controls">
            <?php
            $data = array('name' => 'questionNode', 'type' => 'hidden', 'value' => set_value('questionNode', $questionNode), 'required' => '', 'class' => 'span2', 'maxlength' => '20');
            echo form_input($data);
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="name">Nội Dung</label>

        <div class="controls">
            <?php
            $data = array('name' => 'questionContent', 'value' => set_value('questionContent', $questionContent), 'required' => '', 'class' => 'span6');
            echo form_input($data);
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="name">Loại Câu Hỏi</label>

        <div class="controls">
            <?php
            $options = array('CF' => 'CF',
                'YN' => 'YN'
            );
            echo form_dropdown('questionType', $options, set_value('questionType', $questionType));
            ?>
        </div>
    </div>
    <hr>
    <?php
    if (isset($questions)) echo 'Số câu trả lời: ' . count($questions) ?>

    <table class="answers">
        <?php if (isset($questions)) foreach ($questions as $entry): ?>
            <tr>
                <td class="nodeId">
                    <?php
                    $data = array('name' => 'nodesNode[]', 'value' => set_value('questionContent', $entry->nodesNode), 'class' => 'span1', 'placeholder' => 'Nút', 'type' => 'hidden');
                    echo form_input($data);
                    ?></td>
                <td>
                    <?php
                    $data = array('name' => 'nodesContent[]', 'value' => set_value('questionContent', $entry->nodesContent), 'class' => 'span6', 'placeholder' => 'Nội Dung Nút');
                    echo form_input($data);
                    ?></td>
                <td>
                    <button type='button' name='deleteNode' class='btn btn-small btn-danger btnDelete'><i
                            class='icon-trash icon-white'></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a id="addMoreAnswer" class="btn btn-info"><i class="icon-plus-sign"></i> Thêm Câu Trả Lời</a>
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
    $("#addMoreAnswer").click(function () {
        $(".answers").append("<tr><td class='nodeId'><input type='hidden' name='nodesNode[]' value='' class='span1' placeholder='Nút'/></td><td><input type='text' name='nodesContent[]' value='' class='span6' placeholder='Nội Dung Nút'/></td><td><button type='button' name='deleteNode' class='btn btn-small btn-danger btnDelete'><i class='icon-trash icon-white'></i></button></td></tr>");
    });
    $('button[name="deleteNode"]').click(function () {
        if (!confirm('Xóa nút này?')) {
            return;
        }
        show_animation();
        $nearestRow = $(this).closest('tr');
        $value = $nearestRow.children('td.nodeId').find('input').val();
        $nearestRow.hide();
        if ($value) {
            $.post("<?php echo site_url($this->config->item('admin_folder').'/adviser_question/edit_status'); ?>", { nodesID: $value}, function (data) {
                setTimeout('hide_animation()', 500);
            });
        }
    });

    function show_animation() {
        $('#saving_container').css('display', 'block');
        $('#saving').css('opacity', '.8');
    }

    function hide_animation() {
        $('#saving_container').fadeOut();
    }
</script>
<div id="saving_container" style="display:none;">
    <div id="saving"
         style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="saving_animation" src="<?php echo base_url('assets/img/storing_animation.gif'); ?>" alt="saving"
         style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>

    <div id="saving_text"
         style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001"><?php echo lang('saving'); ?></div>
</div>