<div class="container">
    <div class="row">
        <div class="col">
            <hr class="tall mb-4">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="featured-boxes">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="featured-box featured-box-primary text-left mt-5">
                            <div class="box-content">
                                <h4 class="heading-primary text-uppercase mb-3">User Registration</h4>

                                <?php if($message){ echo $message; } ?>
                                <?php if($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                                <?php endif; ?>

                                <?php if($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                                <?php endif; ?>

                                <?php echo form_open("auth/register", array('id' => 'sign_in','class'=>'m-login__form m-form')); ?>
                                <div class="form-group m-form__group row">
                                    <div class="col-md-6">
                                        <label for="first_name">First Name*</label>
                                        <?php echo form_input($first_name);?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="first_name">Last Name*</label>
                                        <?php echo form_input($last_name);?>
                                    </div>
                                    
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="alias">Alias*</label>
                                    <?php echo form_input($alias);?>
                                    
                                </div>
                                
                                <div class="form-group m-form__group">
                                    <label for="email">Email*</label>
                                    <?php echo form_input($email);?>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="password">Password*</label>
                                    <?php echo form_input($password);?>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="confirm_password">Confirm Password*</label>
                                    <?php echo form_input($password_confirm);?>
                                </div>
                                <div class="form-group m-form__group">
                                    <?php echo $this->my_recaptcha->create(); ?>
                                </div>

                                <div class="m-login__action">
                                    <button type="submit" id="m_login_signup_submit" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign Up</button>
                                </div>
                                <?php echo form_close(); ?>

                                <!--begin::Divider-->
                                <div class="m-login__form-divider">
                                    <div class="m-divider">
                                        <span></span>
                                        <span>OR</span>
                                        <span></span>
                                    </div>
                                </div>

                                <!--end::Divider-->
                                <br>

                                <!--begin::Options-->
                                <div class="m-login__options">
                                    <a href="<?php echo site_url('sociallogin/facebookLogin'); ?>" class="btn btn-primary m-btn m-btn--pill  m-btn  m-btn m-btn--icon">
									<span>
										<i class="fab fa-facebook-f"></i>
										<span>Facebook</span>
									</span>
                                    </a>
                                    
                                    <a href="<?php echo site_url('sociallogin/googleLogin'); ?>" class="btn btn-danger m-btn m-btn--pill  m-btn  m-btn m-btn--icon">
									<span>
										<i class="fab fa-google"></i>
										<span>Google</span>
									</span>
                                    </a>

                                    <div class="pull-right">
                                        Already a member? <a href="<?php echo site_url('login') ?>" class="btn btn-dark">Login</a>
                                    </div>

                                </div>

                                <!--end::Options-->


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                       <!--  <div class="col-md-6 col-lg-5">
                            <h2 class="font-weight-bold text-5 mb-0">Register</h2>
                            <form action="/" id="frmSignUp" method="post">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="text-color-dark text-3">Username or email address <span class="text-color-danger">*</span></label>
                                        <input type="text" value="" class="form-control form-control-lg text-4" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
                                        <input type="password" value="" class="form-control form-control-lg text-4" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <p class="text-2 mb-2">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#" class="text-decoration-none">privacy policy.</a></p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <button type="submit" class="btn btn-dark btn-modern btn-block text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading...">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div> -->

