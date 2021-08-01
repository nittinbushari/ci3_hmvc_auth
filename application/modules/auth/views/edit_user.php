<div class="block-header">
    <h2><?php echo $template['title'];?></h2>
</div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="infoMessage"><?php echo $message;?></div>

        <div class="card">
            <?php echo form_open(uri_string());?>
            <div class="header bg-blue-grey">
                        <h2>
                            <?php echo $template['title'];?>
                            <small>Please Enter the user information below:</small>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li>
                                <button class="btn bg-pink waves-effect savebtn" type="submit" name="submit" value="Save User">
                                    <i class="material-icons">save</i>
                                    <span>Save User</span>
                                </button>
                            </li>
                        </ul>

            </div>
            <div class="body">

                <div class="form-group form-float">
                    <div class="form-line">
                        <div class="form-label"><?php echo lang('edit_user_fname_label', 'first_name');?></div>
                        <?php echo form_input($first_name);?>
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <label for="last_name" class="form-label"><?php echo lang('edit_user_lname_label', 'last_name');?></label>
                        <?php echo form_input($last_name);?>
                    </div>

                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <div class="form-label"><?php echo lang('edit_user_alias_label', 'Alias');?></div>
                        <?php echo form_input($alias);?>
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <label for="company" class="form-label"><?php echo lang('edit_user_company_label', 'company');?></label>
                        <?php echo form_input($company);?>
                    </div>

                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <label for="phone" class="form-label"><?php echo lang('edit_user_phone_label', 'phone');?></label>
                        <?php echo form_input($phone);?>
                    </div>

                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <label for="password" class="form-label"><?php echo lang('edit_user_password_label', 'password');?></label>
                        <?php echo form_input($password);?>
                    </div>

                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <label for="password_confirm" class="form-label"><?php echo lang('edit_user_password_confirm_label', 'password_confirm');?></label>
                        <?php echo form_input($password_confirm);?>
                    </div>

                </div>

                <?php if ($this->ion_auth->is_admin()): ?>

                    <label><?php echo lang('edit_user_groups_heading');?></label>
                    <?php foreach ($groups as $group):?>
                        <label class="checkbox">
                            <?php
                            $gID=$group['id'];
                            $checked = null;
                            $item = null;
                            foreach($currentGroups as $grp) {
                                if ($gID == $grp->id) {
                                    $checked= ' checked="checked"';
                                    break;
                                }
                            }
                            ?>
                            <input class="filled-in chk-col-blue-grey" type="checkbox" name="groups[]" id="<?php echo $group['id'];?>" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                            <label for="<?php echo $group['id'];?>"><?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?></label>
                        </label>
                    <?php endforeach?>

                <?php endif ?>

                <?php echo form_hidden('id', $user->id);?>
                <?php echo form_hidden($csrf); ?>

            </div>
            <?php echo form_close();?>

        </div>
    </div>
</div>


