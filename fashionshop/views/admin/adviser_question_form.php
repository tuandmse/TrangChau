<?php echo form_open($this->config->item('admin_folder') . '/adviser_question/form/' . $questionNode); ?>
<fieldset>
    <div class="control-group">
        <label class="control-label" for="name">Nút</label>

        <div class="controls">
            <?php
            $data = array('name' => 'questionNode', 'value' => set_value('questionNode', $questionNode), 'required' => '', 'class' => 'span2', 'maxlength' => '20');
            if($questionNode != ''){
                $data['readonly'] = 'readonly';
            }
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
    if(isset($questions)) echo 'Số câu trả lời: '. count($questions) ?>

    <div class="answers">
    <?php if(isset($questions)) foreach($questions as $entry): ?>
        <div class="controls">
            <?php
            $data = array('name' => 'nodesNode[]', 'value' => set_value('questionContent', $entry->nodesNode), 'class' => 'span1', 'placeholder' => 'Nút');
            echo form_input($data);
            ?>
            <?php
            $data = array('name' => 'nodesContent[]', 'value' => set_value('questionContent', $entry->nodesContent), 'class' => 'span6', 'placeholder' => 'Nội Dung Nút');
            echo form_input($data);
            ?>
        </div>
    <?php endforeach; ?>
    </div>
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
    $("#addMoreAnswer").click(function(){
        $(".answers").append("<div class='controls'><input type='text' name='nodesNode[]' value='' class='span1' placeholder='Nút'/>            <input type='text' name='nodesContent[]' value='' class='span6' placeholder='Nội Dung Nút'/></div>");
    });
</script>