<div class="row" style="margin-top:50px;">
    <div class="span6 offset3">
        <div class="page-header">
            <h1><?php echo lang('login'); ?></h1>
        </div>
        <?php echo form_open('secure/login', 'class="form-horizontal"'); ?>
        <fieldset>

            <div class="control-group">
                <label class="control-label" for="email"><?php echo lang('email'); ?></label>

                <div class="controls">
                    <input type="text" name="email" class="span3"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="password"><?php echo lang('password'); ?></label>

                <div class="controls">
                    <input type="password" name="password" class="span3" autocomplete="off"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <label class="checkbox">
                        <input name="remember" value="true" type="checkbox"/>
                        <?php echo lang('keep_me_logged_in'); ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"></label>

                <div class="controls">
                    <input type="submit" value="<?php echo lang('form_login'); ?>" name="submit"
                           class="btn btn-primary"/>
                </div>
            </div>
        </fieldset>

        <input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
        <input type="hidden" value="submitted" name="submitted"/>

        </form>

        <div style="text-align:center;">
            <a href="<?php echo site_url('secure/forgot_password'); ?>"><?php echo lang('forgot_password') ?></a> | <a
                href="<?php echo site_url('secure/register'); ?>"><?php echo lang('register'); ?></a>
        </div>

        <div class="page-header">
            <h1><?php echo lang('login'); ?> Facebook</h1>
        </div>
        <?php echo form_open('secure/login', 'class="form-horizontal"'); ?>
        <?php if (@$user_profile): // call var_dump($user_profile) to view all data ?>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img class="img-thumbnail" data-src="holder.js/140x140" alt="140x140"
                         src="https://graph.facebook.com/<?= $user_profile['id'] ?>/picture?type=large"
                         style="width: 140px; height: 140px;">

                    <h2><?= $user_profile['name'] ?></h2>
                    <a href="<?= $user_profile['link'] ?>" class="btn btn-lg btn-default btn-block" role="button">View
                        Profile</a>
                    <a href="<?= $logout_url ?>" class="btn btn-lg btn-primary btn-block" role="button">Logout</a>
                    <button type="submit" class="btn btn-lg btn-primary btn-block" name="facebook_login"
                            value="facebooked" role="button"><?php echo lang('form_login'); ?></button>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= $login_url ?>" role="button">
                <div
                    style="background: url('<?php echo base_url('assets/img/facebook_login.png'); ?>') no-repeat; height: 46px; width: 300px; display:block;"></div>
            </a>
        <?php endif; ?>
        </form>
    </div>
</div>