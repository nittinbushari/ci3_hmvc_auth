

<?php

if (!$this->session->userdata('user_id')) {
    /*
     * user not logged in
     */

    ?>




    <?php


} else {
    /**
     * user logged in
     */

    ?>



    <?php


}

?>

<?php apply_hook('before_sidebars'); ?>
<?php apply_hook('sidebars'); ?>
<?php apply_hook('after_sidebars'); ?>

</aside>
