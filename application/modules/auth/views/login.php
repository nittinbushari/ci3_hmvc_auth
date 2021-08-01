
                        <div class="col-md-6 col-lg-5 mb-5 mb-lg-0">
                            <h2 class="font-weight-bold text-5 mb-0">Login</h2>
                                <?php echo form_open("auth/login/?referrer=admin/dashboard", array('id' => 'sign_in', 'class' => 'm-login__form m-form')); ?>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="text-color-dark text-3">Email address <span class="text-color-danger">*</span></label>
                                        <?php echo form_input($identity); ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
                                        <?php echo form_input($password); ?>
                                    </div>
                                </div>
                                <div class="form-row justify-content-between">
                                    <div class="form-group col-md-auto">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberme">
                                            <label class="custom-control-label cur-pointer text-2" for="rememberme">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-auto">
                                        <a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2" href="#">Forgot Password?</a>
                                    </div>
                                </div>

                            <?php echo form_close(); ?>
                            <div class="form-row">
                                    <div class="form-group col">
                                        <button type="submit" id="m_login_signin_submit" class="btn btn-dark btn-modern btn-block text-uppercase rounded-0 font-weight-bold text-3 py-3 m-login__btn m-login__btn--primary" data-loading-text="Loading...">Login</button>
                                        <div class="divider">
                                            <span class="bg-light px-4 position-absolute left-50pct top-50pct transform3dxy-n50">or</span>
                                        </div>
                                        <a href="#" class="btn btn-primary-scale-2 btn-modern btn-block text-transform-none rounded-0 font-weight-bold align-items-center d-inline-flex justify-content-center text-3 py-3" data-loading-text="Loading..."><i class="fab fa-facebook text-5 mr-2"></i> Login With Facebook</a>
                                    </div>
                                </div>

                        </div>
