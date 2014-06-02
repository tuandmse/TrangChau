<?php include('header.php'); ?>
    <div class="row" style="margin-top:20px;">
        <div class="span10 offset2">
            <div class="page-header">
                <h1>Góp ý</h1>
            </div>
            <?php if ($posted == true): ?>
                <h3>Cảm ơn sự phản hồi của bạn đến website của chúng tôi!</h3>
            <?php endif; ?>
            <?php if ($posted == false): ?>
                <?php echo form_open('guestbook', 'class="form-horizontal"'); ?>
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="name">Name</label>

                        <div class="controls">
                            <input type="text" name="name" class="span6" autocomplete="off" required=""/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email"><?php echo lang('email'); ?></label>

                        <div class="controls">
                            <input type="email" name="email" class="span6" autocomplete="off" required=""/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">Tiêu đề</label>

                        <div class="controls">
                            <input type="text" name="title" class="span6" autocomplete="off" required=""/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="content">Lời nhắn</label>

                        <div class="controls">
                            <textarea name="content" class="span6" autocomplete="off" required="" rows="7"
                                      style="resize: none;"> </textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="password"></label>

                        <div class="controls">
                            <input type="submit" value="Submit" name="submit" class="btn btn-primary"/>
                        </div>
                    </div>
                </fieldset>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php include('footer.php'); ?>