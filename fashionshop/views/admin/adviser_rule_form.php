<div class="row">
    <?php echo form_open($this->config->item('admin_folder') . '/adviser_rule/form/' . $rulesId); ?>
    <div class="span5">
        <fieldset>
            <div class="alert alert-info">
                Chọn một hoặc nhiều nút vế trái làm giả thuyết
            </div>
            <div class="control-group">
                <label class="control-label" for="name">Nút Vế Trái</label>
            </div>
            <div class="answers">
                <table>
                    <?php if (isset($lefthand)) foreach ($lefthand as $entry): ?>
                        <tr>
                            <td style="vertical-align: text-top;"><input name="leftclause[]" type="checkbox"
                                                                         value="<?php echo $entry->nodesNode; ?>"
                                    <?php
                                    if (in_array($entry->nodesNode, $selectedNodeLeft)) {
                                        echo "checked=\"checked\"";
                                    }
                                    ?>
                                                                         class="gc_check"/></td>
                            <td style=""><?php echo $entry->nodesContent; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (isset($righthand)) foreach ($righthand as $entry): ?>
                        <tr>
                            <td style="vertical-align: text-top;"><input name="leftclause[]" type="checkbox"
                                                                         value="<?php echo $entry->nodesNode; ?>"
                                    <?php
                                    if (in_array($entry->nodesNode, $selectedNodeLeft)) {
                                        echo "checked=\"checked\"";
                                    }
                                    ?>
                                                                         class="gc_check"/></td>
                            <td style=""><?php echo $entry->nodesContent; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </fieldset>
    </div>
    <div class="span4">
        <fieldset>
            <div class="alert alert-info">
                Chọn một nút vế phải làm kết luận
            </div>
            <div class="control-group">
                <label class="control-label" for="name">Nút Vế Phải</label>

            </div>

            <div class="answers">
                <table>
                    <?php if (isset($righthand)) foreach ($righthand as $entry): ?>
                        <tr>
                            <td style="vertical-align: text-top;"><input name="rightclause" type="radio"
                                                                         value="<?php echo $entry->nodesNode; ?>"
                                    <?php
                                    if (in_array($entry->nodesNode, $selectedNodeRight)) {
                                        echo "checked=\"checked\"";
                                    }
                                    ?>
                                                                         class="gc_check"/></td>
                            <td style=""><?php echo $entry->nodesContent; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </fieldset>
    </div>
    <div class="span3">
        <fieldset>
            <div class="control-group">

                <div class="controls">
                    <?php
                    $data = array('name' => 'rulesId', 'type' => 'hidden', 'value' => set_value('rulesId', $rulesId), 'required' => '', 'class' => 'span2', 'maxlength' => '20');
                    if ($rulesId != '') {
                        $data['readonly'] = 'readonly';
                    }
                    echo form_input($data);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="name">Giá Trị CF</label>

                <div class="controls">
                    <?php
                    $data = array('name' => 'rulesCF', 'value' => set_value('rulesCF', $rulesCF), 'required' => '', 'class' => 'span2');
                    echo form_input($data);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="password"></label>

                <div class="controls">
                    <input type="submit" value="Submit" name="submit" class="btn btn-primary"/>
                </div>
            </div>
        </fieldset>
    </div>

    </form>
</div>
<script type="text/javascript">
    $('form').submit(function () {
        $('.btn').attr('disabled', true).addClass('disabled');
    });
    $("#addMoreAnswer").click(function () {
        $(".answers").append("<div class='controls'><input type='text' name='nodesNode[]' value='' class='span1' placeholder='Nút'/>            <input type='text' name='nodesContent[]' value='' class='span6' placeholder='Nội Dung Nút'/></div>");
    });
</script>