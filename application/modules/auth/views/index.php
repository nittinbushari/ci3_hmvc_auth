    <div id="infoMessage"><?php echo $message; ?></div>
    
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><?php echo lang('index_subheading'); ?></h3>
                </div>
            </div>
            <div class="m-portlet__head-tools"></div>
        </div>
        <div class="m-portlet__body">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer" id="m_table_1_wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <table cellpadding=0 cellspacing=10 class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed">
                            <tr>
                                <th><?php echo lang('index_fname_th'); ?></th>
                                <th><?php echo lang('index_lname_th'); ?></th>
                                <th><?php echo lang('index_email_th'); ?></th>
                                <th><?php echo lang('index_groups_th'); ?></th>
                                <th><?php echo lang('index_status_th'); ?></th>
                                <th><?php echo lang('index_action_th'); ?></th>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php foreach ($user->groups as $group): ?>
                                            <?php echo anchor("admin/auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br />
                                        <?php endforeach ?>
                                    </td>
                                    <td><?php echo ($user->active) ? anchor("admin/auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?></td>
                                    <td><?php echo anchor("admin/profile/index/" . $user->id, 'Edit'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!--    <div class="row clearfix">-->
<!--        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">-->
<!--            <div class="card">-->
<!--                <div class="header bg-blue-grey">-->
<!--                    <h2></h2>-->
<!--                </div>-->
<!--                <div class="body">-->
<!--                    <div class="table-responsive">-->
<!---->
<!---->
<!--                        <table cellpadding=0 cellspacing=10 class="table table-hover dashboard-task-infos">-->
<!--                            <tr>-->
<!--                                <th>--><?php //echo lang('index_fname_th'); ?><!--</th>-->
<!--                                <th>--><?php //echo lang('index_lname_th'); ?><!--</th>-->
<!--                                <th>--><?php //echo lang('index_email_th'); ?><!--</th>-->
<!--                                <th>--><?php //echo lang('index_groups_th'); ?><!--</th>-->
<!--                                <th>--><?php //echo lang('index_status_th'); ?><!--</th>-->
<!--                                <th>--><?php //echo lang('index_action_th'); ?><!--</th>-->
<!--                            </tr>-->
<!--                            --><?php //foreach ($users as $user): ?>
<!--                                <tr>-->
<!--                                    <td>--><?php //echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?><!--</td>-->
<!--                                    <td>--><?php //echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?><!--</td>-->
<!--                                    <td>--><?php //echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?><!--</td>-->
<!--                                    <td>-->
<!--                                        --><?php //foreach ($user->groups as $group): ?>
<!--                                            --><?php //echo anchor("auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><!--<br />-->
<!--                                        --><?php //endforeach ?>
<!--                                    </td>-->
<!--                                    <td>--><?php //echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?><!--</td>-->
<!--                                    <td>--><?php //echo anchor("auth/edit_user/" . $user->id, 'Edit'); ?><!--</td>-->
<!--                                </tr>-->
<!--                            --><?php //endforeach; ?>
<!--                        </table>-->
<!--                    </div>-->
<!--                    <p>--><?php //echo anchor('auth/create_user', lang('index_create_user_link')) ?><!-- | --><?php //echo anchor('auth/create_group', lang('index_create_group_link')) ?><!--</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->





