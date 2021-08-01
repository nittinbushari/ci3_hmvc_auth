<!DOCTYPE html>
<html>
    <?php echo $this->template->load_view("layouts/partials/head.php"); ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PHHBZB2');</script>
<!-- End Google Tag Manager -->
    <body class="<?php echo $class ? $class : ''; ?>">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PHHBZB2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <div class="body">
            <?php echo $this->template->load_view("layouts/partials/header.php"); ?>

            <div role="main" class="main">
                <section class="page-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <ul class="breadcrumb">
                                    <li><a href="#">Home</a></li>
                                    <li class="active">
                                        <?php echo $template['title']; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h1>
                                    <?php echo $template['title']; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo $template['body']; ?>
                        </div>
                    </div>
                </div>

            </div>

            <?php echo $this->template->load_view("layouts/partials/footer.php"); ?>
        </div>

        <?php echo $this->template->load_view("layouts/partials/footer-script.php"); ?>

    </body>

</html>
