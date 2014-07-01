<script type="text/javascript">
    $(document).ready(function () {
        $('#content_editor').redactor({
            minHeight: 200,
            imageUpload: 'http://labs.gocartdv.com/gc2test/admin/wysiwyg/upload_image',
            fileUpload: 'http://labs.gocartdv.com/gc2test/admin/wysiwyg/upload_file',
            imageGetJson: 'http://labs.gocartdv.com/gc2test/admin/wysiwyg/get_images',
            imageUploadErrorCallback: function (json) {
                alert(json.error);
            },
            fileUploadErrorCallback: function (json) {
                alert(json.error);
            }
        });
    });
</script>
<div class="row">
    <div class="span12">
        <div class="page-header">
            <h1>Chi tiết góp ý</h1>
        </div>
        <div class="row">
            <div class="span2">
                <h3>Tên</h3>
                Mã góp ý <br/>
                Thời gian <br/>
                Email <br/>
                Tiêu đề <br/>
                Nội dung <br/>
            </div>
            <div class="span8">
                <h3><?php echo $guestbook->name; ?></h3>
                <?php echo $guestbook->guestbook_id; ?> <br/>
                <?php echo $guestbook->datetime; ?> <br/>
                <?php echo $guestbook->email; ?> <br/>
                <?php echo $guestbook->title; ?> <br/>
                <?php echo $guestbook->content; ?> <br/>
            </div>
        </div>
    </div>
</div>

<div id="notification_form" class="row">
    <div class="span12">
        <div class="page-header">
        </div>
        <?php echo form_open($this->config->item('admin_folder') . '/guestbook/send_response/' . $guestbook->guestbook_id); ?>
        <fieldset>
            <label>Người nhận</label>
            <input type="text" name="recipient_show" size="40" id="recipient_name_show" class="span12"
                   value="<?php echo $guestbook->name . ' (' . $guestbook->email . ')'; ?>" readonly/>
            <input type="hidden" name="recipient" size="40" id="recipient_name" class="span12"
                   value="<?php echo $guestbook->email; ?>"/>

            <label>Tiêu đề</label>
            <input type="text" name="subject" size="40" id="msg_subject" class="span12"/>

            <label>Nội dung</label>
            <textarea id="content_editor" name="content"></textarea>

            <div class="form-actions">
                <input type="submit" class="btn btn-primary" value="Gửi phản hồi"/>
            </div>
        </fieldset>
        </form>
    </div>
</div>