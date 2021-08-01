<div class="block-header projectView">
    <h2><?php echo lang('deactivate_heading'); ?></h2>
</div>
<div class="clearfix"></div>
<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>User Deactivation</h2>
            </div>
            <div class="body">
                <p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></p>
                <?php echo form_open("auth/deactivate/" . $user->id); ?>
                <p>
                    
                    <input type="radio" class="with-gap" name="confirm" value="yes" id="yes" checked="checked" />
                    <label for="yes">Yes</label>
                    
                    <input type="radio" class="with-gap" id="no" name="confirm" value="no" />
                    <label for="no">No</label>
                </p>

                <?php echo form_hidden($csrf); ?>
                <?php echo form_hidden(array('id' => $user->id)); ?>

                <p><?php echo form_submit('submit', lang('deactivate_submit_btn')); ?></p>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>


