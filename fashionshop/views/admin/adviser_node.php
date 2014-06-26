<div class="row">
    <div class="span12">
        <div class="page-header">
            <h1>Quản Trị Nút</h1>
        </div>
        <div style="text-align:right">
            <a class="btn btn-primary"
               href="<?php echo site_url($this->config->item('admin_folder') . '/adviser_node/form'); ?>"><i
                    class="icon-plus-sign"></i> Thêm Nút</a>
        </div>
        <?php echo form_open($this->config->item('admin_folder') . '/adviser_node/bulk_delete', array('id' => 'delete_form', 'onsubmit' => 'return submit_form();', 'class="form-inline"')); ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="white-space:nowrap"><input type="checkbox" id="gc_check_all"/>
                    <button type="submit" class="btn btn-small btn-danger"
                        <?php echo (count($nodes) < 1) ? 'disabled="disabled"' : '' ?>>
                        <i class="icon-trash icon-white"></i></button>
                </th>
                <th style="white-space:nowrap">Nút</th>
                <th style="white-space:nowrap">Nội Dung</th>
                <th style="white-space:nowrap">Nút Của Câu Hỏi</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php echo (count($nodes) < 1) ? '<tr><td style="text-align:center;" colspan="8">Chưa có nút nào!</td></tr>' : '' ?>
            <?php foreach ($nodes as $entry): ?>
                <tr>
                    <td><input name="order[]" type="checkbox" value="<?php echo $entry->nodesNode; ?>"
                               class="gc_check"/></td>
                    <td style="white-space:nowrap"><?php echo $entry->nodesNode; ?></td>
                    <td style=""><?php echo $entry->nodesContent; ?></td>
                    <td style="white-space:nowrap"><?php echo $entry->questionNode; ?></td>
                    <td>

                        <?php
                        if ($entry->questionNode == ''):
                            ?>
                            <a class="btn btn-small" style="float:right;"
                               href="<?php echo site_url($this->config->item('admin_folder') . '/adviser_node/form/' . $entry->nodesNode); ?>"><i
                                    class="icon-pencil"></i> <?php echo lang('form_view') ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#gc_check_all').click(function () {
            if (this.checked) {
                $('.gc_check').prop('checked', 'checked');
            }
            else {
                $(".gc_check").removeProp("checked");
            }
        });

        // set the datepickers individually to specify the alt fields
        $('#start_top').datepicker({dateFormat: 'mm-dd-yy', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
        $('#start_bottom').datepicker({dateFormat: 'mm-dd-yy', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
        $('#end_top').datepicker({dateFormat: 'mm-dd-yy', altField: '#end_top_alt', altFormat: 'yy-mm-dd'});
        $('#end_bottom').datepicker({dateFormat: 'mm-dd-yy', altField: '#end_bottom_alt', altFormat: 'yy-mm-dd'});
    });

    function submit_form() {
        if ($(".gc_check:checked").length > 0) {
            return confirm('Bạn có chắc chắn muốn xóa những câu hỏi này?');
        }
        else {
            alert('Bạn chưa chọn câu hỏi nào cả!');
            return false;
        }
    }

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