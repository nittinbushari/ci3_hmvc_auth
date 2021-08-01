<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>Notebook | Web Application</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <?php include 'partials/header-script.php';?>
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
  <section class="vbox">
    <?php include "partials/header.php"; ?>
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        <?php include "partials/menu.php";?>
        <!-- /.aside -->
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                 <li><a href="<?php site_url('admin/dashboard');?>"><i class="fa fa-home"></i> Home</a></li>
                  <?php foreach($template['breadcrumbs'] as $breadcrumb){
                        ?>
                        <li><a href="<?php echo $breadcrumb['uri'] ?>"><?php echo $breadcrumb['name']; ?></a></li>
                        <?php
                    } ?>
               
                    <!--<li class="active">Workset</li> -->
              </ul>
              <div class="m-b-md">
                <h3 class="m-b-none"><?php echo $template['title']; ?></h3>
                <small>Welcome back, Noteman</small>
              </div>

                 <?php echo $template['body']; ?>

            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>
  <?php include('partials/footer-script.php'); ?>
  <?php apply_hook('admin_footer'); ?>

</body>
</html>