<?php
/*
Theme Name: Geotech
Theme URI: http://geotechru.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта http://geotechru.com/
Version: 1.0
*/
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo geotech_wp_title('','', true, 'right'); ?></title>
    <base href="#">
	
	<!-- FAVICONS -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="194x194" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/favicon-194x194.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/android-chrome-192x192.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/manifest.json">
	<link rel="mask-icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">
		
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- HTML5 for IE -->
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
	<?php wp_head(); ?>
</head>
<body>

    <!-- START HEADER -->

    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="logo">
						<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo-1.png" alt="logotype" />
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo-half-2.png" alt="">
						</a>

                        <a class="logo-mobile" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo-mobile.png" alt="">
                        </a>
                    </div>
                    <div class="header-phone">
                        <a href="tel: <?php echo getMeta('phone_header_main_page'); ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo getMeta('phone_header_main_page'); ?></a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="labg-search">
                        <div class="lang"><a href="http://geotech.ru/"><i class="fa fa-globe" aria-hidden="true"></i></a></div>
                        <div class="search"><a href="<?php echo get_page_link('646') ?>"><i class="fa fa-search" aria-hidden="true"></i></a></div>
                    </div>
                    <nav>
                        <button type="button" class="menu-button"><i class="fa fa-bars"></i></button>
						<?php
							if (has_nav_menu('primary_menu')){
								wp_nav_menu( array(
									'theme_location'  => 'primary_menu',
									'menu'            => '',
									'container'       => false,
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => '',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul class="first-lavel-menu">%3$s</ul>',
									'depth'           => 3,
									'walker'          => new primary_menu(),
								) );
							}
						?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <!-- END HEADER -->
