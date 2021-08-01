<head>
    <!-- Basic --> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   

    <title>
        <?php echo $template['title']; ?>
    </title>
    <meta name="keyword" content="<?php echo $meta_keywords; ?>">
    <meta name="description" content="<?php echo $meta_descriptions; ?>">

    <meta name="author" content="Nittin">

    <!-- Favicon -->
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light%7CPlayfair+Display:400&display=swap" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <?php echo vendor('css', 'bootstrap/css/bootstrap.min.css'); ?>
    <?php echo vendor('css', 'font-awesome/css/fontawesome-all.min.css'); ?>
    <?php echo vendor('css', 'animate/animate.compat.css'); ?>
    <?php // echo vendor('css', 'animate/animate.min.css'); ?>
    <?php echo vendor('css', 'simple-line-icons/css/simple-line-icons.min.css'); ?>
    <?php echo vendor('css', 'owl.carousel/assets/owl.carousel.min.css'); ?>
    <?php echo vendor('css', 'owl.carousel/assets/owl.theme.default.min.css'); ?>
    <?php echo vendor('css', 'magnific-popup/magnific-popup.min.css'); ?>
    <?php echo vendor('css', 'bootstrap-star-rating/css/star-rating.min.css'); ?>
    <?php echo vendor('css', 'bootstrap-star-rating/themes/krajee-fas/theme.min.css'); ?>

    <?php //echo vendor('css', 'summernote/summernote.css'); ?>
    <!-- Theme CSS -->
    <?php echo css('theme.css'); ?>
    <?php echo css('theme-elements.css'); ?>
    <?php echo css('theme-blog.css'); ?>
    <?php echo css('theme-shop.css'); ?>
    <!-- Current Page CSS -->
    <?php echo vendor('css', 'rs-plugin/css/settings.css'); ?>
    <?php echo vendor('css', 'rs-plugin/css/layers.css'); ?>
    <?php echo vendor('css', 'rs-plugin/css/navigation.css'); ?>

    <!-- Skin CSS -->
    <?php echo css('skins/skin-corporate-3.css'); ?>

    <!-- Theme Custom CSS -->
    <?php echo css('custom.css'); ?>

    <!-- Head Libs -->
    <?php echo vendor('js', 'modernizr/modernizr.min.js'); ?>

     <?php echo css('demos/demo-landing.css'); ?>
     <?php echo css('demos/skins/skin-landing.css'); ?>

    <script>
        var site_url = '<?php echo base_url(); ?>';

    </script>

    <?php echo vendor('js', 'node_modules/jquery/dist/jquery.min.js'); ?>
    <?php echo $template['metadata']; ?>
    <?php apply_hook('head'); ?>
</head>






