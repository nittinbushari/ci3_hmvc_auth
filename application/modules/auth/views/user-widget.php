<aside class="widget">
    <?php if ($this->ion_auth->logged_in()) :
        $user = $this->ion_auth_model->user()->row();
    ?>
    <!-- <h4 class="heading-primary">Profile</h4>
    <div class="row">
        <div class="col profile_avatar" style="margin-bottom: -20px;">
            <img src="<?php // echo $user->avatar ? $user->avatar : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'; ?>">
        </div>
        <div class="col profile_info" style="margin-bottom: -20px;">
            <p>
                <?php // $this->ion_auth_model->trigger_events('badge'); ?> &nbsp;Hi,
                <?php // echo $user->first_name . ' ' . $user->last_name; ?>
            </p>

            <ul>
                <li><a href="<?php //echo site_url('profile'); ?>"> <i class="fa fa-user"></i> Profile</a></li>
                <li><a href="<?php // echo site_url('auth/logout'); ?>"> <i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </div> -->
    <?php else : ?>
    <h4 class="heading-primary">
        Login
    </h4>
    <a href="<?php echo site_url('login'); ?>"><i class="icon-login icons"></i> Login</a> &nbsp;&nbsp; <a href="<?php echo site_url('register'); ?>"><i
            class="icon-user icons"></i> Signup</a>
    <?php endif; ?>
</aside>

<hr>