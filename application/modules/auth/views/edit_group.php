<div id="infoMessage"><?php echo $message;?></div>

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?php echo lang('edit_group_heading');?>
                </h3>
            </div>
        </div>
    </div>

<form method="post" action="<?php echo current_url(); ?>" class="m-form m-form--fit m-form--label-align-right">
    <div class="m-portlet__body">
        <div class="m-form__content">
            <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert">
                <div class="m-alert__icon">
                    <i class="la la-warning"></i>
                </div>
                <div class="m-alert__text"></div>
                <div class="m-alert__close">
                    <button type="button" class="close" data-close="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <div class="form-group m-form__group row">
        <label for="" class="col-form-label col-lg-3 col-sm-12">
            <?php echo lang('edit_group_name_label', 'group_name');?>
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <?php echo form_input($group_name);?>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="" class="col-form-label col-lg-3 col-sm-12">
            <?php echo lang('edit_group_desc_label', 'description');?>
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <?php echo form_input($group_description);?>
        </div>
    </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions">
            <div class="row">
                <div class="col-lg-9 ml-lg-auto">
                    <button type="submit" class="btn btn-success"><?php echo lang('edit_group_submit_btn'); ?></button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</form>
</div>