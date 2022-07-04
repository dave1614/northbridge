<!DOCTYPE html>
<html lang="en">
   

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php if(isset($page_title)){ ?>
    <title><?php echo $page_title; ?></title>
    <?php }{ ?>
    <title>Northbridge Fire Engineering</title>
    <?php } ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Northbridge fire engineering is one of the leading Fire Fighting distributor in Africa" />
    <meta name="keywords" content="Northbridge, Northbridge Fire, Northbridge Fire Engineering, Fire Extinguishers, Fire Hydrants, Firefighting Equipment, Fire Protection Systems, Fire Alarms, Fire Protection Valves, Fire Pumps, Passive Fire Protection, Fire Trucks" />
    <meta name="author" content="northbridge-fire.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/northbridge-3d-w.png') ?>" />
    <!-- Font -->
    <!-- <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arimo:300,400,700,400italic,700italic' /> -->
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href='<?php echo base_url('assets/css/font-awesome.min.css') ?>' rel='stylesheet' type='text/css' />
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("assets/css/bootstrap.min.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/hover-dropdown-menu.css") ?>" rel="stylesheet" />
    <!-- Icomoon Icons -->
    <link href="<?php echo base_url("assets/css/icons.css") ?>" rel="stylesheet" />
    <!-- Revolution Slider -->
    <link href="<?php echo base_url("assets/css/revolution-slider.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/rs-plugin/css/settings.css") ?>" rel="stylesheet" />
    <!-- Animations -->
    <link href="<?php echo base_url("assets/css/animate.min.css") ?>" rel="stylesheet" />
    <!-- Owl Carousel Slider -->
    <link href="<?php echo base_url("assets/css/owl/owl.carousel.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/owl/owl.theme.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/owl/owl.transitions.css") ?>" rel="stylesheet" />
    <!-- PrettyPhoto Popup -->
    <link href="<?php echo base_url("assets/css/prettyPhoto.css") ?>" rel="stylesheet" />
    <!-- Custom Style -->
    <link href="<?php echo base_url("assets/css/style.css") ?>?v=1.5" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/responsive.css") ?>" rel="stylesheet" />
    <!-- Color Scheme -->
    <link href="<?php echo base_url("assets/css/color.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/darkbox.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/jssocials.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/jssocials-theme-flat.css") ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/customf9e3.css?v=1.6") ?>" rel="stylesheet" />
    
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.min.js") ?>"></script> 

   </head>
   <body class="footer-hidden">
    <div id="page">
    <!-- Page Loader -->
    <div id="pageloader">
     <div class="loader-item fa fa-spin text-color"></div>
    </div>
    <!-- Page Loader -->
    <!-- Top Bar -->
    <!-- Top Bar -->
    <header id="sticker" class="sticky-navigation">
     <!-- Sticky Menu -->
     <div class="sticky-menu relative">
      <!-- navbar -->
      <div class="navbar navbar-default navbar-bg-light" role="navigation">
         <div class="container">
          <div class="row">
           <div class="col-md-12">
            <div class="navbar-header">
               <!-- Button For Responsive toggle -->
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span></button>
               <!-- Logo -->
               <a class="navbar-brand" href="<?php echo site_url('northbridge/') ?>">
               <!-- <img class="site_logo" alt="Site Logo" src="<?php echo base_url("assets/images/northbridge-3d-w.png") ?>" /> -->
                <h4 style="margin-top: 10px; font-size: 30px; font-weight: bold; color: #ff0000; letter-spacing: 0.5px;">NORTHBRIDGE</h4>
               </a>
            </div>
            <!-- Navbar Collapse -->
            
            <div class="navbar-collapse collapse">
               <!-- nav -->
               <ul class="nav navbar-nav">
                <li class="<?php if($addition == ''){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/') ?>">
                  <!-- <i class="fa fa-users"></i> -->
                  HOME
                 </a>
                </li>
                <li class="<?php if($addition == 'about_us'){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/about_us'); ?>">
                  <!-- <i class="fa fa-users"></i> -->
                  ABOUT
                 </a>
                </li>
                <li class="mega-menu <?php if($addition == 'products'){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/products'); ?>">PRODUCTS / SOLUTIONS</a>
                 <ul class="dropdown-menu">
                  <li>
                     <!-- Home Mage Menu grids Begins -->
                     <div class="row">
                      <!-- Home Variation 1 Block -->
                      <div class="col-sm-12 text-center">
                       <!-- Title -->
                       <!-- Links -->
                       
                       <a href="<?php echo site_url('northbridge/index/products/fire_pumps') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/download (7).jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/download (7).jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE <br/>  PUMPS</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_hydrants') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/download (6).jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/download (6).jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE <br/>  HYDRANTS</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_fighting_equipment') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/2-5-Red-Fire-Hose-with-Aluminous-Coupling.jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/2-5-Red-Fire-Hose-with-Aluminous-Coupling.jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIREFIGHTING <br/> EQUIPMENT</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_valves') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/imgbin-control-valves-flow-control-valve-fire-protection-fire-hydrant-fire-hydrant-usage-Wn6HDRyfk3UeNqHySKXzuYqxK.jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/imgbin-control-valves-flow-control-valve-fire-protection-fire-hydrant-fire-hydrant-usage-Wn6HDRyfk3UeNqHySKXzuYqxK.jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE PROTECTION<br/>  VALVES</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_protection_systems') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/download (3).jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/download (3).jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE PROTECTION <br/>  SYSTEMS</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/passive_fire_protection') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/download (8).jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/download (8).jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">PASSIVE FIRE <br/> PROTECTION</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_extinguishers') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/Aqua-Spray-Extinguisher.jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/Aqua-Spray-Extinguisher.jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE <br/>  EXTINGUISHERS</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_alarms') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/download (5).jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/download (5).jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE DETECTION & <br> ALARM SYSTEMS</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/access_control_systems') ?>" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/images/download (9).jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/images/download (9).jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">ACCESS <br> CONTROL SYSTEMS</span>
                        </div>
                       </a>
                       <a href="<?php echo site_url('northbridge/index/products/fire_trucks') ?>" target="_blank" class="icons-hover">
                        <div class="mega-meue-bristol-icons">
                           <img src="<?php echo base_url("assets/img/productsimages/vmd/ft27.jpg"); ?>" class="grey-icons">
                           <img src="<?php echo base_url("assets/img/productsimages/vmd/ft27.jpg"); ?>" class="red-icons">
                           <span class="mega-menu-icon-title">FIRE <br/>  TRUCKS</span>
                        </div>
                       </a>
                      </div>
                     </div>
                     <!-- Ends Home Mage Menu Block -->
                  </li>
                 </ul>
                </li>
                <li class="<?php if($addition == 'projects'){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/projects') ?>">PROJECTS</a>
                </li>
                <li class="<?php if($addition == 'clients'){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/clients') ?>">CLIENTS</a>
                </li>
                <!-- <li class="<?php if($addition == 'careers'){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/careers') ?>">CAREERS</a>
                </li> -->
                <li class="<?php if($addition == 'contact'){ echo 'active'; } ?>">
                 <a href="<?php echo site_url('northbridge/contact') ?>">CONTACT</a>
                </li>
                <!-- Ends Search Box Block -->
               </ul>
               <!-- Right nav -->
            </div>
            <!-- /.navbar-collapse -->
           </div>
           <!-- /.col-md-12 -->
          </div>
          <!-- /.row -->
         </div>
         <!-- /.container -->
      </div>
      <!-- navbar -->
     </div>
     <!-- Sticky Menu -->
    </header>
    