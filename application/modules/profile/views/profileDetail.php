<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="m-portlet m-portlet--full-height  ">
            <div class="m-portlet__body">
                <div class="m-card-profile">

                    <div class="m-card-profile__pic">
                        <div class="m-card-profile__pic-wrapper">
                            <img src="<?php echo $user['avatar']; ?>" alt="">
                        </div>
                    </div>
                    <div class="m-card-profile__details">
                        <div class="m-card-profile__name">
                            <!-- name -->
                            <span class="m-card-profile__name"><?php echo $user['first_name'].' '.$user['last_name']; ?></span>
                            <a href="" class="m-card-profile__email m-link"><?php echo $user['email']; ?></a>
                        </div>
                    </div>
                </div>
                <hr>


                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item active">
                            <a href="" class="nav-link m-tabs__link">
                                Details
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="profile">
                    <form action="" class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 m--hide"></div>
                            <div class="form-group m-form__group row">
                                <div class="col-10 ml-auto">
                                    <h3 class="m-form__section">1. Personal Details</h3>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="" class="col-2 col-form-label">Full Name</label>
                                <div class="col-7">
                                    <p class="form-control m-input"><?php echo $user['first_name'].' '.$user['last_name']; ?></p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="" class="col-2 col-form-label">Email</label>
                                <div class="col-7">
                                    <p class="form-control m-input"><?php echo $user['email']; ?></p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="" class="col-2 col-form-label">Phone</label>
                                <div class="col-7">
                                    <p class="form-control m-input"><?php echo $user['phone']; ?></p>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>