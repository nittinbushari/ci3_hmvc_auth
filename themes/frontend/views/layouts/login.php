<!DOCTYPE html>
<html>
     <?php echo $this->template->load_view("layouts/partials/head.php"); ?>
    <body class="alternative-font-4">
 
        <div class="body">
            <div class="notice-top-bar bg-primary" data-sticky-start-at="180">
                <button class="hamburguer-btn hamburguer-btn-light notice-top-bar-close m-0 active" data-set-active="false">
                    <span class="close">
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <div class="container">
                    <div class="row justify-content-center py-2">
                        <div class="col-9 col-md-12 text-center">
                            <p class="text-color-light font-weight-semibold mb-0">Get Up to <strong>40% OFF</strong> New-Season Styles <a href="#" class="btn btn-primary-scale-2 btn-modern btn-px-2 btn-py-1 ml-2">MEN</a> <a href="#" class="btn btn-primary-scale-2 btn-modern btn-px-2 btn-py-1 ml-1 mr-2">WOMAN</a> <span class="opacity-6 text-1">* Limited time only.</span></p>
                        </div>
                    </div>
                </div>
            </div>
             <?php echo $this->template->load_view("layouts/partials/login-header.php"); ?>

            <div role="main" class="main shop py-4">
                <div class="container py-4">
                    <div class="row justify-content-center">
                        <?php echo $template['body']; ?>
                    </div>
                </div>
            </div>
            <?php echo $this->template->load_view("layouts/partials/footer.php"); ?>
        </div>
            <?php echo $this->template->load_view("layouts/partials/footer-script.php"); ?>

    </body>
</html>