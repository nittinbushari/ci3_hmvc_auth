<style>

    /* Show load indicator when image is being loaded */
.cropit-preview.cropit-image-loading .spinner {
  opacity: 1;
}

/* Show move cursor when image has been loaded */
.cropit-preview.cropit-image-loaded .cropit-preview-image-container {
  cursor: move;
}

/* Gray out zoom slider when the image cannot be zoomed */
.cropit-image-zoom-input[disabled] {
  opacity: .2;
}

/* Hide default file input button if you want to use a custom button */
input.cropit-image-input {
  visibility: hidden;
}

/* The following styles are only relevant to when background image is enabled */

/* Translucent background image */
.cropit-preview-background {
  opacity: .2;
}

/*
 * If the slider or anything else is covered by the background image,
 * use non-static position on it
 */
input.cropit-image-zoom-input {
  position: relative;
}

/* Limit the background image by adding overflow: hidden */
#image-cropper {
  overflow: hidden;
}

    .image-editor{
        overflow: hidden;
    }
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 5px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 250px;
        height: 250px;
        margin-left:auto;
        margin-right: auto;
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      .cropit-preview-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      .export {
        /* Use relative position to prevent from being covered by image background */
        position: relative;
        z-index: 10;
        display: block;
      }

      .image-editor img{
          max-width:none;
      }

    </style>

<div class="row">

    <!-- Profile -->
    <div class="col-lg-6 col-md-12">
        <form action="<?php echo site_url('admin/auth/edit_user/' . $user['id']); ?>" method="post" enctype="multipart/form-data">
        <div class="dashboard-list-box margin-top-0">
            <h4 class="gray">Profile Details</h4>
            <div class="dashboard-list-box-static">

                <!-- Avatar -->
                <div class="edit-profile-photo">
                    <?php echo $user['avatar']?external_image($user['avatar']):img('user-avatar.jpg');?>
                    <div class="change-photo-btn">
                        <div class="photoUpload">
                            <span><i class="fa fa-upload"></i> Upload Photo</span>
                            <input type="file" class="upload" />
                            <input type="hidden" name="avatar" id="avatar" value="<?php echo $user['avatar']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="my-profile">

                    <label>First Name</label>
                    <input value="<?php echo $user['first_name']; ?>" name="first_name" type="text">

                    <label>Last Name</label>
                    <input value="<?php echo $user['last_name']; ?>" name="last_name" type="text">

                    <label>Alias</label>
                    <input value="<?php echo $user['alias']; ?>" name="alias" type="text">

                    <label>Phone</label>
                    <input value="<?php echo $user['phone']; ?>" name="phone" type="text">

                    <label>Email</label>
                    <input value="<?php echo $user['email']; ?>" name="email" type="text">

                </div>
                <?php echo form_hidden('id', $user['id']); ?>
                <?php echo form_hidden($csrf); ?>

                <button type="submit" name="submit" class="button margin-top-15">Save Changes</button>

            </div>
        </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="col-lg-6 col-md-12">
        <form action="<?php echo site_url('admin/auth/change_password'); ?>" method="post">
        <div class="dashboard-list-box margin-top-0">
            <h4 class="gray">Change Password</h4>
            <div class="dashboard-list-box-static">

                <!-- Change Password -->
                <div class="my-profile">
                    <label class="margin-top-0">Current Password</label>
                    <input name="old" value="" type="password">

                    <label>New Password</label>
                    <input name="new" value="" type="password">

                    <label>Confirm New Password</label>
                    <input name="new_confirm" value="" type="password">

                    <button type="submit" name="submit" class="button margin-top-15">Change Password</button>
                </div>

            </div>
        </div>
        </form>
    </div>

</div>


<!-- Sign In Popup -->
            <div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

                <div class="small-dialog-header">
                    <h3>Position and Size Your Photo</h3>
                </div>

                <!--Tabs -->
                <div class="sign-in-form style-1">

                    

                    <div class="tabs-container alt">

                        <!-- Login -->
                        <div class="tab-content" id="tab1">
                            <form method="post" action="#" class="">
                                <div class="form-row">
                                    <div class="image-editor">
                                        <div class="cropit-preview"></div>
                                        <div class="controls-wrapper">
                                            <div class="slider-wrapper">
                                                <span class="icon icon-image small-image"></span>
                                                <input type="range" class="cropit-image-zoom-input custom" min="0" max="1" step="0.01">
                                                <span class="icon icon-image large-image"></span>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="image-data" class="hidden-image-data" />
                                        
                                    </div>
                                </div>
                                

                                <div class="form-row">
                                    <button type="button" id="submit" class="button border margin-top-5" name="submit" value="Apply" >Apply</button>
                                    
                                </div>

                            </form>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Sign In Popup / End -->

<?php echo js('jquery.cropit.js'); ?>

<a href="#sign-in-dialog" class="profilePicUpload" style="visibility:hidden;">start</a>
<script>
    $(document).ready(function(){
        $('.change-photo-btn').find('input[type=file]').on('change',function(){
            $('.profilePicUpload').click();
        });


        $('.image-editor').cropit({ imageBackground: true,$fileInput: $('.photoUpload').find('input.upload'),smallImage:'stretch' });

        $('#sign-in-dialog').find('button').click(function() {
          // Move cropped image data to hidden input
          var imageData = $('.image-editor').cropit('export');
          //console.log(imageData);
          $('#avatar').val(imageData);
          $('.edit-profile-photo').find('img').attr('src',imageData);

          // Prevent the form from actually submitting
          var magnificPopup = $.magnificPopup.instance; 
            // save instance in magnificPopup variable
            magnificPopup.close(); 
            // Close popup that is currently opened
          return false;
        });
    });
</script>


