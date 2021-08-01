<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="dashboard-list-box margin-top-0">
            <h4>
                <?php echo $template['title']; ?>
                <a href="<?php echo site_url('admin/pages/add'); ?>" class="button pull-right">Add New
                    Page</a>
            </h4>
            <ul>
                <li>
            
                <?php 
                if (count($pages) > 0) {
                    ?>
                    <table class="basic-table">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Slider</th>
                    <th>Sidebar</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                    <?php
                    $i = 0;
                    foreach ($pages as $page) : //print_r($category); ?>
                    <tr>
                        <td><?php echo $page->id; ?></td>
                        <td><?php echo $page->title; ?></td>
                        <td><?php echo $page->slug; ?></td>
                        <td><?php echo $page->slider; ?></td>
                        <td><?php echo $page->sidebar; ?></td>
                        <td><?php $user = user($page->user_id); echo empty($user->alias) ? $user->first_name.' '.$user->last_name : $user->alias; ?></td>
                        <td><?php echo $page->created; ?></td>
                        <td>
                            <a target="_blank" href="<?php echo site_url($page->slug); ?>" class="button gray"><i class="fa fa-arrow-circle-right"></i> Preview</a>
                            <a href="<?php echo site_url('admin/pages/edit/' . $page->id); ?>" class="button gray"><i class="sl sl-icon-note"></i> Edit</a>
                            <a onclick="return confirm('Are you sure?');" href="<?php echo site_url('admin/pages/delete/' . $page->id); ?>" class="button gray"><i class="sl sl-icon-close"></i> Delete</a>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
                </table>
                <?php echo $pagination; ?>
                <?php 
            } else {
                ?>
                <li>
                    <div class="list-box-listing">
                        <h3>No Record Found!</h3>
                    </div>
                </li>
                <?php

            } ?>
                
                </li>
            </ul>
        </div>
    </div>
</div>
