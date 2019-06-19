<?php
/*
Template name: Main page
Theme Name: Geotech
Theme URI: http://geotechru.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта http://geotechru.com/
Version: 1.0
*/

get_header(); 
?>

	<?php
		foreach (get_field ('slider_main_page') as $nextgen_gallery_id){
			echo nggShowGallery( $nextgen_gallery_id['ngg_id'], "slider-main-page", 4 );
		}
	?>
	
	<?php $array_menu = wp_get_nav_menu_items( 24 ); ?>
	<?php if($array_menu) {?>
    <main class="main-index">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme our-direction-slider">
						<?php foreach($array_menu as $menu) {?>
                        <div>
                            <a href="<?php echo $menu->url; ?>">
                                <?php echo $menu->title; ?>
                            </a>
                        </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
	<?php } ?>
	
	<div class="container about-guarantee">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <p class="title-uppercase">About company</p>
				<?php
					$args = array(
						'numberposts' => 5,
						'post_type'   => 'about-us',
						'orderby'     => 'date',
						'order'       => 'DESC',
					);
		
					$list_about_us = get_posts( $args );
					
					if($list_about_us){
				?>
                <div class="owl-carousel owl-theme about-slider">
					<?php
					foreach($list_about_us as $list){
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($list->ID), 'full');
						$descr = wpautop(stripcslashes( wp_trim_words( $list->post_content, 30, '...' ) ), $br = false);
						$link = get_permalink($list->ID);
					?>
                    <div>
						<?php if(!empty($image_url)){ ?>
							<img src="<?php echo $image_url[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($list->ID), '_wp_attachment_image_alt', true ); ?>">
						<?php }else{ ?>
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/about-slide-1.jpg">
						<?php } ?>
                        <div class="description-slide">
                            <p class="small-title-bold"><?php echo $list->post_title; ?></p>
                            <?php echo $descr; ?>
							<p><a class="more" href="<?php echo $link; ?>">Learn More</a></p>
                        </div>
                    </div>
					<?php } ?>
                </div>
				<?php } ?>
				
            </div>
            <div class="col-md-12 col-lg-4">
                <p class="title-uppercase">Geophysical Survey</p>
                <div class="guarantee-description">
					
				<?php echo wpautop(getMeta('guarantee_main_page')); ?>
                </div>
            </div>
        </div>
    </div>
	
	<!-- START NEWS-BLOCK -->
	<?php
		$args = array(
			'numberposts' => 4,
			'post_type'   => 'news',
			'orderby'     => 'date',
			'order'       => 'DESC',
		);

		$list_news = get_posts( $args );
		
		if($list_news){
	?>
    <div class="container-fluid news-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="title-uppercase">company's news</p>
                </div>
				<?php foreach($list_news as $news){ ?>
				<?php
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($news->ID), 'full');
				$descr = wpautop(stripcslashes( wp_trim_words( $news->post_content, 30, '...' ) ), $br = false);
				$link = get_permalink($news->ID);
				?>
                <div class="col-md-3">
                    <div class="news">
						<?php if(!empty($image_url)){ ?>
							<img src="<?php echo $image_url[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($news->ID), '_wp_attachment_image_alt', true ); ?>">
						<?php }else{ ?>
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/news-1.jpg">
						<?php } ?>
						
                        <p class="small-title"><?php echo $news->post_title; ?></p>
						<?php echo $descr; ?>
					    <a class="more" href="<?php echo $link; ?>">Learn More</a>
                    </div>
                </div>
				<?php } ?>
				
            </div>
        </div>
    </div>
	<?php } ?>
    <!-- END NEWS-BLOCK -->
	
	<!-- START UNDER-NEWS-BLOCK -->
    <div class="container-fluid under-news-block">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/training.png" alt="">
                    <p class="small-title">Training</p>
                    <p>Our company provides implementation, warranty and post-warranty service support of manufacturing range of geophysical equipment.</p>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/service.png" alt="">
                    <p class="small-title">Service</p>
                    <p>The reputation of “LogisGeotech” has been built on responsibilities to the clients for support and service maintenance of sold equipment.</p>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/devepopment.png" alt="">
                    <p class="small-title">Development / Manufacturing</p>
                    <p>We is the leader of “OKO”-type GPR production, as well as seismic-acoustic and electro-investigating equipment in Russian Federation. </p>
                </div>
            </div>
        </div>
    </div>
    <!-- END UNDER-NEWS-BLOCK -->
	
	<!-- START GALERY -->
	<?php
		foreach (get_field ('gallery_object_main_page') as $nextgen_gallery_id){
			echo nggShowGallery( $nextgen_gallery_id['ngg_id'], "gallery-main-page");
		}
	?>
    <!-- END GALERY -->
	
<?php get_footer(); ?>