<div class="row widget">
    <div class="col-lg-6">
        <div class="widget_title"><h3>Profile Details</h3></div>
        <form action="<?php echo site_url('auth/edit_user/'.$id);?>" method="POST">
            <div class="form-group">
                <div class="avatar"><img src="<?php echo $avatar?$avatar: 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'; ?>"></div>
                <label for="" id="avatar" class="button"> Change Profile Picture <input type="file" id="File" class="upload" name="avatar" size="" ></label>
                <input type="hidden" class="profile_pic" name="avatar" value="<?php echo $avatar?$avatar:''; ?>">
                
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" value="<?php echo set_value('first_name',$first_name); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="alias">Alias</label>
                <input type="text" name="alias" value="<?php echo set_value('alias', $alias); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" value="<?php echo set_value('phone', $phone); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" value="<?php echo set_value('email', $email); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?php echo set_value('bio',$bio); ?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Save Changes" class="btn btn-primary btn-lg pull-right">
            </div>
            
            <?php echo form_hidden('id', $id); ?>
            <?php echo form_hidden($csrf); ?>

        </form>
    </div>
    <div class="col-lg-6">
        <div class="widget_title"><h3>Change Password</h3></div>
        <form action="<?php echo site_url('auth/change_password');?>" method="POST">
            <div class="form-group">
                <label for="old">Current Password</label>
                <input type="password" name="old" value="<?php echo set_value('old'); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="new">New Password</label>
                <input type="password" name="new" value="<?php echo set_value('new'); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="new_confirm">Confirm New Password</label>
                <input type="password" name="new_confirm" value="<?php echo set_value('new_confirm'); ?>" class="form-control">
            </div>
            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
            <div class="form-group">
                <input type="submit" name="submit" value="Save Changes" class="btn btn-primary btn-lg pull-right">
            </div>
        </form>
    </div>
</div>

<!-- cropit wrapper codes -->

<!-- This wraps the whole cropper -->
<!-- Sign In Popup -->

<div class="modal profilePicUpload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Position and Size Your Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="logoUpdate">
                        <div id="image-cropper">
                            <div class="cropit-preview"></div>
                            <div class="controls-wrapper">
                                <div class="slider-wrapper">
                                    <span class="icon rotate-ccw-btn"><i class="fas fa-undo"></i></span>
                                    <span class="icon rotate-cw-btn"><i class="fas fa-undo"></i></span>
                                    <span class="icon icon-image small-image"><i class="fa fa-file-image"></i></span>
                                    <input type="range" class="cropit-image-zoom-input custom" min="0" max="1" step="0.01">
                                    <span class="icon icon-image large-image"><i class="fa fa-file-image"></i></span>
                                    <span style="margin-left:20px;"><button type="submit" class="btn btn-primary" name="submit" value="Apply" >Apply</button></span>
                                </div>
                            </div>
                            
                            <input type="hidden" name="image-data" class="hidden-image-data" />
                            
                        </div>
                    
                </form>
      </div>
      
    </div>
  </div>
</div>


<!-- end of cropit -->

