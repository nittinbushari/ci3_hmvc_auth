    <?php //$this->ion_auth_model->trigger_events('user_management'); ?>

    <aside class="sidebar">
        <form method="POST" action="<?php echo site_url('blog'); ?>">
                    <div class="input-group input-group-4">
            <input class="form-control" placeholder="Search..." name="q" id="s" type="text">
            <span class="input-group-append">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-search"></i></button>
            </span>
            </div>
        </form>
        <hr>
        <h4 class="heading-primary">Blog Categories</h4>
        <ul class="nav nav-list flex-column mb-5">
            <?php if ($this->template->categories_list) : ?>
                <?php foreach ($this->template->categories_list as $category) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo category_url($category['slug']); ?>"> <?php echo $category['name']; ?> (<?php echo $category['posts_count']; ?>)</a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </aside>

