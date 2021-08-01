<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="dashboard-list-box margin-top-0">
            <h4>
                <?php echo $template['title']; ?>
                <a href="<?php echo site_url('admin/pages/category_add'); ?>" class="button pull-right">Add New
                    Category</a>
            </h4>
            <ul>
                <li>
            
                <?php 
                if (count($categories) > 0) {
                    ?>
                    <table class="basic-table">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                    <?php
                    $i=0;
                    foreach ($categories as $category) : //print_r($category); ?>
                    <tr>
                        <td><?php echo ($i+1); ?></td>
                        <td><?php echo $category->name; ?></td>
                        <td><?php echo $category->slug; ?></td>
                        <td><?php echo $category->description; ?></td>
                        <td>
                            <a href="<?php echo site_url('admin/pages/category_edit/'.$category->id); ?>" class="button gray"><i class="sl sl-icon-note"></i> Edit</a>
                            <a onclick="return confirm('Are you sure?');" href="<?php echo site_url('admin/pages/category_delete/' . $category->id); ?>" class="button gray"><i class="sl sl-icon-close"></i> Delete</a>
                        </td>
                    </tr>
                <?php $i++; endforeach; ?>
                </table>
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
