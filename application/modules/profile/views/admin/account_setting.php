<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="m-portlet m-portlet--full-height  ">
            <div class="m-portlet__body">
                <div class="m-card-profile">
                    <div class="m-card-profile__title m--hide">
                        Your Profile
                    </div>
                    <div class="m-card-profile__pic">
                        <div class="m-card-profile__pic-wrapper">
                            <img src="<?php echo base_url(); ?>assets/app/media/img/users/user4.jpg" alt="" />
                        </div>
                    </div>
                    <div class="m-card-profile__details">
                        <span class="m-card-profile__name"><?php echo $user['first_name'].' '.$user['last_name']; ?></span>
                        <a href="" class="m-card-profile__email m-link"><?php echo $user['email']; ?></a>
                    </div>
                </div>
                <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                    <li class="m-nav__separator m-nav__separator--fit"></li>
                    <li class="m-nav__section m--hide">
                        <span class="m-nav__section-text">Section</span>
                    </li>
                    <li class="m-nav__item">
                        <a href="<?php echo site_url('admin/profile'); ?>" class="m-nav__link">
                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                            <span class="m-nav__link-title">
														<span class="m-nav__link-wrap">
															<span class="m-nav__link-text">My Profile</span>

														</span>
													</span>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a href="<?php echo site_url('admin/profile/account_setting'); ?>" class="m-nav__link">
                            <i class="m-nav__link-icon flaticon-share"></i>
                            <span class="m-nav__link-text">Account Setting</span>
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Username
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Email
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Password
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="m_user_profile_tab_1">
                    <form class="m-form m-form--fit m-form--label-align-right" method="post" action="<?php echo site_url('admin/auth/edit_user/'.$user['id']); ?>">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 <?php echo $this->session->flashdata('error')?'':'m--hide'; ?> ">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">Username</label>
                                <div class="col-7">
                                    <input class="form-control m-input" name="username" type="text" value="<?php echo $user['username']; ?>">
                                </div>
                            </div>

                            <input type="hidden" name="redirect" value="<?php echo current_url(); ?>">


                        </div>

                        <?php echo form_hidden('id', $user['id']);?>
                        <?php echo form_hidden($csrf); ?>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="m_user_profile_tab_2">
                    <form class="m-form m-form--fit m-form--label-align-right" method="post" action="<?php echo site_url('auth/edit_user/'.$user['id']); ?>">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 <?php echo $this->session->flashdata('error')?'':'m--hide'; ?> ">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">Email Address</label>
                                <div class="col-7">
                                    <input class="form-control m-input" name="email" type="email" value="<?php echo $user['email']; ?>">
                                </div>
                            </div>

                            <input type="hidden" name="redirect" value="<?php echo current_url(); ?>">



                        </div>

                        <?php echo form_hidden('id', $user['id']);?>
                        <?php echo form_hidden($csrf); ?>


                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="m_user_profile_tab_3">
                    <form class="m-form m-form--fit m-form--label-align-right" method="post" action="<?php echo site_url('auth/edit_user/'.$user['id']); ?>">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 <?php echo $this->session->flashdata('error')?'':'m--hide'; ?> ">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">New Password</label>
                                <div class="col-7">
                                    <input class="form-control m-input" name="password" type="password" value="">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">Retype Password</label>
                                <div class="col-7">
                                    <input class="form-control m-input" name="password_confirm" type="password" value="">
                                </div>
                            </div>
                            <input type="hidden" name="redirect" value="<?php echo current_url(); ?>">





                        </div>

                        <?php echo form_hidden('id', $user['id']);?>
                        <?php echo form_hidden($csrf); ?>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>