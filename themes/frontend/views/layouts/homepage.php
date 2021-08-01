<!DOCTYPE html>
<html>
     <?php include('partials/head.php'); ?>
    <body class="alternative-font-4 loading-overlay-showing <?php echo $class ? $class : ''; ?>" data-plugin-page-transition data-loading-overlay data-plugin-options="{'hideDelay': 100}">
        <div class="loading-overlay">
            <div class="bounce-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        
        <div class="body <?php echo $class ? $class : ''; ?>">
            <?php echo $this->template->load_view("layouts/partials/header.php"); ?>

            <div role="main" class="main">

                 <?php apply_hook('home-banner'); ?>

                <?php echo $template['body']; ?>

            </div>
            <?php include('partials/footer.php'); ?>
        </div>

        <?php include "partials/footer-script.php"; ?>

    </body>
</html>