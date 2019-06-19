<?php
/*
Theme Name: Geotech
Theme URI: http://geotechru.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта http://geotechru.com/
Version: 1.0
*/

get_header();
?>

    <!-- START MAIN-ABOUT -->

    <main class="main-about">

        <!-- start bread-crumbs -->

        <div class="container-fluid bread-crumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                       <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- end bread-crumbs -->
				
        <div class="container">
            <div class="row">
                <div class="col-md-3 desctop-sidebar">
					<?php
						$args = array(
							'numberposts' => 5,
							'post_type'   => 'about-us',
							'orderby'     => 'date',
							'order'       => 'DESC',
						);
			
						$list_about_us = get_posts( $args );
						
						$id = get_the_ID();
						
						if($list_about_us){
					?>
                    <aside class="sidebar">
                        <div id='cssmenu'>
                            <ul class="first-lavel">
							<?php foreach($list_about_us as $list){ ?>
							<?php //if($id ==  $list->ID){ ?>
                                <!--<li class='has-sub'><a class="active-about" href="<?php echo get_permalink($list->ID)?>"><span><?php echo $list->post_title; ?></span></a></li>-->
							<?php //}else{ ?>
								<li class='has-sub'><a href="<?php echo get_permalink($list->ID)?>"><span><?php echo $list->post_title; ?></span></a></li>
							<?php //} ?>
							<?php } ?>
                            </ul>
                        </div>
                    </aside>
					<?php } ?>
                </div>

				<?php
                    $term = get_queried_object();
                    $cat_id = $term->term_id;
                    $cat_title = get_term_meta($cat_id, 'title_for_categories_about_us_page');
                    $cat_descr = get_term_meta($cat_id, 'text_for_categories_about_us_page');
				?>
				
                <div class="col-md-9">
                    <p class="title-uppercase"><?php echo $cat_title[0]; ?></p>

					<?php echo wpautop(stripcslashes( $cat_descr[0] ), $br = false); ?>
                </div>

                <div class="col-md-3 mobile-sidebar">
                    <?php
                        $args = array(
                            'numberposts' => 5,
                            'post_type'   => 'about-us',
                            'orderby'     => 'date',
                            'order'       => 'DESC',
                        );
            
                        $list_about_us = get_posts( $args );
                        
                        $id = get_the_ID();
                        
                        if($list_about_us){
                    ?>
                    <aside class="sidebar">
                        <div id='cssmenu'>
                            <ul class="first-lavel">
                            <?php foreach($list_about_us as $list){ ?>
                            <?php //if($id ==  $list->ID){ ?>
                                <!--<li class='has-sub'><a class="active-about" href="<?php echo get_permalink($list->ID)?>"><span><?php echo $list->post_title; ?></span></a></li>-->
                            <?php //}else{ ?>
                                <li class='has-sub'><a href="<?php echo get_permalink($list->ID)?>"><span><?php echo $list->post_title; ?></span></a></li>
                            <?php //} ?>
                            <?php } ?>
                            </ul>
                        </div>
                    </aside>
                    <?php } ?>
                </div>
            </div>
        </div>

    </main>

    <!-- END MAIN-ABOUT -->

<?php get_footer(); ?>
