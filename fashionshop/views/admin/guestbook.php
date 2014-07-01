<?php

function sort_url($lang, $by, $sort, $sorder, $admin_folder)
{
    if ($sort == $by) {
        if ($sorder == 'asc') {
            $sort = 'desc';
            $icon = ' <i class="icon-chevron-up"></i>';
        } else {
            $sort = 'asc';
            $icon = ' <i class="icon-chevron-down"></i>';
        }
    } else {
        $sort = 'asc';
        $icon = '';
    }
    $return = site_url($admin_folder . '/guestbook/index/' . $by . '/' . $sort);
    echo '<a href="' . $return . '">' . $lang . $icon . '</a>';
}
?>
<div class="row">
    <div class="span12">
        <div class="page-header">
            <h1>Góp ý</h1>
        </div>
        <div class="span4">
            <?php echo $this->pagination->create_links(); ?>    &nbsp;
        </div>
        <?php echo form_open($this->config->item('admin_folder') . '/guestbook/bulk_delete', array('id' => 'delete_form', 'onsubmit' => 'return submit_form();', 'class="form-inline"')); ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><input type="checkbox" id="gc_check_all"/>
                    <button type="submit" class="btn btn-small btn-danger"
                        <?php echo (count($entries) < 1) ? 'disabled="disabled"' : '' ?>>
                        <i class="icon-trash icon-white"></i></button>
                </th>

                <th style="white-space:nowrap"><?php echo sort_url('Name', 'name', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th style="white-space:nowrap"><?php echo sort_url('Email', 'email', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th style="white-space:nowrap"><?php echo sort_url('Title', 'title', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th style="white-space:nowrap"><?php echo sort_url('Date Time', 'datetime', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php echo (count($entries) < 1) ? '<tr><td style="text-align:center;" colspan="8">Chưa có góp ý nào!</td></tr>' : '' ?>
            <?php foreach ($entries as $entry): ?>
                <tr>
                    <td><input name="order[]" type="checkbox" value="<?php echo $entry->guestbook_id; ?>"
                               class="gc_check"/></td>
                    <td style="white-space:nowrap"><?php echo $entry->name; ?></td>
                    <td style="white-space:nowrap"><?php echo $entry->email; ?></td>
                    <td style="white-space:nowrap"><?php echo $entry->title; ?></td>
                    <td style="white-space:nowrap"><?php echo date('m/d/y h:i a', strtotime($entry->datetime)); ?></td>
                    <td>
                        <a class="btn btn-small" style="float:right;"
                           href="<?php echo site_url($this->config->item('admin_folder') . '/guestbook/viewdetails/' . $entry->guestbook_id); ?>"><i
                                class="icon-search"></i> <?php echo lang('form_view') ?></a>
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
            return confirm('Bạn có chắc chắn muốn xóa những góp ý này?');
        }
        else {
            alert('Bạn chưa chọn góp ý nào cả!');
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