


<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>
    <div class="msg"><p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p></div>

      <div class="input-group">
          <span class="input-group-addon">
              <i class="material-icons">email</i>
          </span>
          <div class="form-line">
              <?php echo form_input($identity,'','class="form-control" placeholder="'.(($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)).'"');?>
          </div>

      </div>

      <p><?php echo form_submit('submit', 'RESET MY PASSWORD','class="btn btn-block btn-lg bg-pink waves-effect"');?></p>
        <div class="row m-t-20 m-b--5 align-center">
            <a href="<?php echo site_url('auth/login');?>">Sign In!</a>
        </div>
<?php echo form_close();?>
