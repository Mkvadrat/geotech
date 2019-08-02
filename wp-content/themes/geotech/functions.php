<?php
/*
Theme Name: Geotech
Theme URI: http://geotechru.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта http://geotechru.com/
Version: 1.0
*/

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
****************************************************************************НАСТРОЙКИ ТЕМЫ*****************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function mk_scripts(){
	wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap-css' );
	
	wp_register_style( 'reset-css', get_template_directory_uri() . '/css/reset.css');
	wp_enqueue_style( 'reset-css' );
	
	wp_register_style( 'fonts-css', get_template_directory_uri() . '/css/fonts.css');
	wp_enqueue_style( 'fonts-css' );
	
	wp_register_style( 'awesome-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false, '4.4.0' );
	wp_enqueue_style( 'awesome-css' );
	
	wp_register_style( 'styles-css', get_template_directory_uri() . '/css/styles.css');
	wp_enqueue_style( 'styles-css' );
	
	wp_register_style( 'media-css', get_template_directory_uri() . '/css/media.css');
	wp_enqueue_style( 'media-css' );
	
	wp_register_style( 'carousel-css', get_template_directory_uri() . '/css/owl.carousel.min.css');
	wp_enqueue_style( 'carousel-css' );
	
	wp_register_style( 'theme-css', get_template_directory_uri() . '/css/owl.theme.default.css');
	wp_enqueue_style( 'theme-css' );
	
	wp_register_style( 'fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', false, '3.5.7' );
	wp_enqueue_style( 'fancybox-css' );
		
	if (!is_admin()) {
		wp_enqueue_script( 'jquery-min', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js', '', '', false );
		wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/js/bootstrap.min.js', '', '', false );
		wp_enqueue_script( 'carousel-min', get_template_directory_uri() . '/js/owl.carousel.min.js', '', '', false );
		wp_enqueue_script( 'fancybox-min', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', '', '', true );
		wp_enqueue_script( 'common-min', get_template_directory_uri() . '/js/common.js', '', '', true );
	}
}
add_action( 'wp_enqueue_scripts', 'mk_scripts' );

//Регистрируем название сайта
function geotech_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'ug' ), max( $paged, $page ) );
	}

	if ( is_404() ) {
        $title = '404';
    }

	return $title;
}
add_filter( 'wp_title', 'geotech_wp_title', 10, 2 );

//Регистрируем меню
if(function_exists('register_nav_menus')){
	register_nav_menus(
		array(
		  'primary_menu' => 'Главное меню',
		  'middle_menu'  => 'Среднее меню',
		  'footer_menu_one'  => 'Меню в подвале сайта (Блок 1)',
		  'footer_menu_two'  => 'Меню в подвале сайта (Блок 2)',
		  'product_menu'     => 'Меню продуктов',
		  'videocatalogue'   => 'Видеокаталог',
		)
	);
}

//Изображение в шапке сайта
$args = array(
  'width'         => 250,
  'height'        => 45,
  'default-image' => get_template_directory_uri() . '/images/logo.jpg',
  'uploads'       => true,
);
add_theme_support( 'custom-header', $args );

//Добавление в тему миниатюры записи и страницы
if ( function_exists( 'add_theme_support' ) ) {
     add_theme_support( 'post-thumbnails' );
}

//Отключить редактор
add_filter('use_block_editor_for_post', '__return_false');

//Удаляем пунткы меню
function remove_menu_items() {
    remove_menu_page('edit-comments.php'); // Удаляем пункт "Комментарии"
}
add_action( 'admin_menu', 'remove_menu_items' );

//Вывод id категории
function getCurrentCatID(){
	global $wp_query;
	if(is_category()){
		$cat_ID = get_query_var('cat');
	}
	return $cat_ID;
}

//Редирект на страницу поиска
function SearchFilter($query) {
   // If 's' request variable is set but empty
   if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
      $query->is_search = true;
      $query->is_home = false;
   }
   return $query;
}
add_filter('pre_get_posts','SearchFilter');

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
****************************************************************************МЕНЮ САЙТА*********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
// Добавляем свой класс для пунктов меню:
class primary_menu extends Walker_Nav_Menu {

	// Добавляем классы к вложенным ul
	function start_lvl( &$output, $depth ) {
		// Глубина вложенных ul
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'first-drop-menu',
			( $display_depth % 2  ? 'dropdown' : '' ),
			( $display_depth >=2 ? 'dropdown' : '' ),
			'second-drop-menu'
			);
		$class_names = implode( ' ', $classes );
	
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// Добавляем классы к вложенным li
	function start_el( &$output, $item, $depth, $args ) {
		global $wpdb;
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
	
		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'has-sub' : '' ),
			( $depth >=2 ? '' : '' ),
			( $depth % 2 ? '' : '' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	
		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
	
		$mycurrent = ( $item->current == 1 ) ? ' active' : '';
	
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	
		$output .= $indent . '<li>';
	
		// Добавляем атрибуты и классы к элементу a (ссылки)
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
		$attributes .= ' class="menu-link ' . ( $depth == 0 ? 'parent' : '' ) . ( $depth == 1 ? 'child' : '' ) . ( $depth >= 2 ? 'sub-child' : '' ) . '"';
	
		if($depth == 0){
			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after
			);
		}else if($depth == 1){
			$has_children = $wpdb->get_results( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s AND meta_key = '_menu_item_menu_item_parent'", $item->ID), ARRAY_A);
			
			$link  =  $item->url;
			$title = apply_filters( 'the_title', $item->title, $item->ID );
					
			if(!empty($has_children)){
				$item_output = '<a href="'. $link .'">' . $title .' <i class="fa fa-angle-right" aria-hidden="true"></i></a>';
			}else{
				$item_output = '<a href="'. $link .'">' . $title .'</a>';
			}

		}else if($depth >= 2){
			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after
			);
		}
	
		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*********************************************************************РАБОТА С METAПОЛЯМИ*******************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Вывод данных из произвольных полей для всех страниц сайта
function getMeta($meta_key){
	global $wpdb;
	
	$value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1", $meta_key) );
	
	return $value;
}

function getAttachment($post_id){
	global $wpdb;
	
	$value = $wpdb->get_var( $wpdb->prepare("SELECT guid FROM $wpdb->posts WHERE ID = %s AND post_type = 'attachment'", $post_id) );
	
	return $value;
}

//Вывод связанных данных для single.php
function getProductsMeta($post_id, $meta_key){
	global $wpdb;
	
	$value = array();

	$serialized_object = $wpdb->get_results( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = %s AND meta_key = %s", $post_id, $meta_key) );
	
	$unserialized_object = unserialize($serialized_object[0]->meta_value);
	
	if($unserialized_object){
		foreach($unserialized_object as $post_id){
			$value[] = get_post( $post_id );
		}
	}
	
	return $value;
}

//Вывод * категории
function getRubricByID($id){
	global $wpdb;

	$value = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->terms t JOIN $wpdb->term_relationships tr ON (tr.term_taxonomy_id = t.term_id) AND tr.object_id = %s", $id) );
	
	return $value;
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*******************************************************************SEO PATH FOR IMAGE**********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function getAltImage($meta_key){
	global $wpdb;

	$post_id = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1" , $meta_key));

	$attachment = get_post( $post_id );

	return get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
}

function getTitleImage($meta_key){
	global $wpdb;

	$post_id = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1" , $meta_key));

	$attachment = get_post( $post_id );

	return $attachment->post_title;
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
**********************************************************************"РАЗДЕЛ ВИДЕОКАТАЛОГ"******************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Вывод в админке раздела о компании
function register_post_type_videocatalogue() {
	$labels = array(
	 'name' => 'Videocatalogue',
	 'singular_name' => 'Videocatalogue',
	 'add_new' => 'Добавить статью',
	 'add_new_item' => 'Добавить новую статью',
	 'edit_item' => 'Редактировать статью',
	 'new_item' => 'Новая статью',
	 'all_items' => 'Все статьи',
	 'view_item' => 'Просмотр статей на сайте',
	 'search_items' => 'Искать статью',
	 'not_found' => 'Статья не найден.',
	 'not_found_in_trash' => 'В корзине нет статьи.',
	 'menu_name' => 'Видеокаталог'
	 );
	 $args = array(
		 'labels' => $labels,
		 'public' => true,
		 'exclude_from_search' => false,
		 'show_ui' => true,
		 'has_archive' => false,
		 'menu_icon' => 'dashicons-format-video', // иконка в меню
		 'menu_position' => 20,
		 'supports' =>  array('title','editor', 'thumbnail'),
	 );
 	register_post_type('videocatalogue', $args);
}
add_action( 'init', 'register_post_type_videocatalogue' );

function true_post_type_videocatalogue( $videocatalogue ) {
	global $post, $post_ID;

	$videocatalogue['videocatalogue'] = array(
			0 => '',
			1 => sprintf( 'Статьи обновлены. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
			2 => 'Статья обновлёна.',
			3 => 'Статья удалёна.',
			4 => 'Статья обновлена.',
			5 => isset($_GET['revision']) ? sprintf( 'Статья восстановлена из редакции: %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( 'Статья опубликована на сайте. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
			7 => 'Статья сохранена.',
			8 => sprintf( 'Отправлена на проверку. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( 'Запланирована на публикацию: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Просмотр</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( 'Черновик обновлён. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $videocatalogue;
}
add_filter( 'post_updated_messages', 'true_post_type_videocatalogue' );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
**********************************************************************"РАЗДЕЛ О КОМПАНИИ"******************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Вывод в админке раздела о компании
function register_post_type_about_us() {
	$labels = array(
	 'name' => 'About us',
	 'singular_name' => 'About us',
	 'add_new' => 'Добавить статью',
	 'add_new_item' => 'Добавить новую статью',
	 'edit_item' => 'Редактировать статью',
	 'new_item' => 'Новая статью',
	 'all_items' => 'Все статьи',
	 'view_item' => 'Просмотр статей на сайте',
	 'search_items' => 'Искать статью',
	 'not_found' => 'Статья не найден.',
	 'not_found_in_trash' => 'В корзине нет статьи.',
	 'menu_name' => 'О компании'
	 );
	 $args = array(
		 'labels' => $labels,
		 'public' => true,
		 'exclude_from_search' => false,
		 'show_ui' => true,
		 'has_archive' => false,
		 'menu_icon' => 'dashicons-book', // иконка в меню
		 'menu_position' => 20,
		 'supports' =>  array('title','editor', 'thumbnail'),
	 );
 	register_post_type('about-us', $args);
}
add_action( 'init', 'register_post_type_about_us' );

function true_post_type_about_us( $about_us ) {
	global $post, $post_ID;

	$about_us['about-us'] = array(
			0 => '',
			1 => sprintf( 'Статьи обновлены. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
			2 => 'Статья обновлёна.',
			3 => 'Статья удалёна.',
			4 => 'Статья обновлена.',
			5 => isset($_GET['revision']) ? sprintf( 'Статья восстановлена из редакции: %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( 'Статья опубликована на сайте. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
			7 => 'Статья сохранена.',
			8 => sprintf( 'Отправлена на проверку. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( 'Запланирована на публикацию: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Просмотр</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( 'Черновик обновлён. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $about_us;
}
add_filter( 'post_updated_messages', 'true_post_type_about_us' );
	
//Категории для пользовательских записей "О компании"
function create_taxonomies_about_us()
{
    // Cats Categories
    register_taxonomy('about-us-list',array('about-us'),array(
        'hierarchical' => true,
        'label' => 'Рубрики',
        'singular_name' => 'Рубрика',
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'about-us-list' )
    ));
}
add_action( 'init', 'create_taxonomies_about_us', 0 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
**********************************************************************"РАЗДЕЛ НОВОСТИ"*********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Вывод в админке раздела новости
function register_post_type_news() {
	$labels = array(
	 'name' => 'Новости',
	 'singular_name' => 'Новости',
	 'add_new' => 'Добавить новость',
	 'add_new_item' => 'Добавить новую новость',
	 'edit_item' => 'Редактировать новость',
	 'new_item' => 'Новая новость',
	 'all_items' => 'Все новости',
	 'view_item' => 'Просмотр новостей на сайте',
	 'search_items' => 'Искать новость',
	 'not_found' => 'Новость не найден.',
	 'not_found_in_trash' => 'В корзине нет статьи.',
	 'menu_name' => 'Новости'
	 );
	 $args = array(
		 'labels' => $labels,
		 'public' => true,
		 'exclude_from_search' => false,
		 'show_ui' => true,
		 'has_archive' => false,
		 'menu_icon' => 'dashicons-id-alt', // иконка в меню
		 'menu_position' => 20,
		 'supports' =>  array('title','editor', 'thumbnail'),
	 );
 	register_post_type('news', $args);
}
add_action( 'init', 'register_post_type_news' );

function true_post_type_news( $news ) {
	global $post, $post_ID;

	$news['news'] = array(
			0 => '',
			1 => sprintf( 'Новости обновлены. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
			2 => 'Новость обновлёна.',
			3 => 'Новость удалёна.',
			4 => 'Новость обновлена.',
			5 => isset($_GET['revision']) ? sprintf( 'Статья восстановлена из редакции: %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( 'Новость опубликована на сайте. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
			7 => 'Новость сохранена.',
			8 => sprintf( 'Отправлена на проверку. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( 'Запланирована на публикацию: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Просмотр</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( 'Черновик обновлён. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $news;
}
add_filter( 'post_updated_messages', 'true_post_type_news' );
	
//Категории для пользовательских записей "Новости"
function create_taxonomies_news()
{
    // Cats Categories
    register_taxonomy('news-list',array('news'),array(
        'hierarchical' => true,
        'label' => 'Рубрики',
        'singular_name' => 'Рубрика',
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'news-list' )
    ));
}
add_action( 'init', 'create_taxonomies_news', 0 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*****************************************************************REMOVE CATEGORY_TYPE SLUG*********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Удаление  из url таксономии
function true_remove_slug_from_category_about_us( $url, $term, $taxonomy ){

	$taxonomia_name = 'about-us-list';
	$taxonomia_slug = 'about-us-list';

	if ( strpos($url, $taxonomia_slug) === FALSE || $taxonomy != $taxonomia_name ) return $url;

	$url = str_replace('/' . $taxonomia_slug, '', $url);

	return $url;
}
add_filter( 'term_link', 'true_remove_slug_from_category_about_us', 10, 3 );

//Перенаправление url в случае удаления about-us-list
function parse_request_url_category_about_us( $query ){

	$taxonomia_name = 'about-us-list';

	if( $query['attachment'] ) :
		$condition = true;
		$main_url = $query['attachment'];
	else:
		$condition = false;
		$main_url = $query['name'];
	endif;

	$termin = get_term_by('slug', $main_url, $taxonomia_name);

	if ( isset( $main_url ) && $termin && !is_wp_error( $termin )):

		if( $condition ) {
			unset( $query['attachment'] );
			$parent = $termin->parent;
			while( $parent ) {
				$parent_term = get_term( $parent, $taxonomia_name);
				$main_url = $parent_term->slug . '/' . $main_url;
				$parent = $parent_term->parent;
			}
		} else {
			unset($query['name']);
		}

		switch( $taxonomia_name ):
			case 'category':{
				$query['category_name'] = $main_url;
				break;
			}
			case 'post_tag':{
				$query['tag'] = $main_url;
				break;
			}
			default:{
				$query[$taxonomia_name] = $main_url;
				break;
			}
		endswitch;

	endif;

	return $query;

}
add_filter('request', 'parse_request_url_category_about_us', 1, 1 );

//Удаление  из url таксономии
function true_remove_slug_from_category_news( $url, $term, $taxonomy ){

	$taxonomia_name = 'news-list';
	$taxonomia_slug = 'news-list';

	if ( strpos($url, $taxonomia_slug) === FALSE || $taxonomy != $taxonomia_name ) return $url;

	$url = str_replace('/' . $taxonomia_slug, '', $url);

	return $url;
}
add_filter( 'term_link', 'true_remove_slug_from_category_news', 10, 3 );

//Перенаправление url в случае удаления news-list
function parse_request_url_category_news( $query ){

	$taxonomia_name = 'news-list';

	if( $query['attachment'] ) :
		$condition = true;
		$main_url = $query['attachment'];
	else:
		$condition = false;
		$main_url = $query['name'];
	endif;

	$termin = get_term_by('slug', $main_url, $taxonomia_name);

	if ( isset( $main_url ) && $termin && !is_wp_error( $termin )):

		if( $condition ) {
			unset( $query['attachment'] );
			$parent = $termin->parent;
			while( $parent ) {
				$parent_term = get_term( $parent, $taxonomia_name);
				$main_url = $parent_term->slug . '/' . $main_url;
				$parent = $parent_term->parent;
			}
		} else {
			unset($query['name']);
		}

		switch( $taxonomia_name ):
			case 'category':{
				$query['category_name'] = $main_url;
				break;
			}
			case 'post_tag':{
				$query['tag'] = $main_url;
				break;
			}
			default:{
				$query[$taxonomia_name] = $main_url;
				break;
			}
		endswitch;

	endif;

	return $query;

}
add_filter('request', 'parse_request_url_category_news', 1, 1 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*****************************************************************REMOVE POST_TYPE SLUG*********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Удаление sluga из url таксономии 
function remove_slug_from_post( $post_link, $post, $leavename ) {
	if ( 'videocatalogue' != $post->post_type && 'about-us' != $post->post_type && 'news' != $post->post_type || 'publish' != $post->post_status ) {
		return $post_link;
	}
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
	return $post_link;
}
add_filter( 'post_type_link', 'remove_slug_from_post', 10, 3 );

function parse_request_url_post( $query ) {
	if ( ! $query->is_main_query() )
		return;

	if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
		return;
	}

	if ( ! empty( $query->query['name'] ) ) {
		$query->set( 'post_type', array( 'post', 'about-us', 'news', 'videocatalogue', 'page' ) );
	}
}
add_action( 'pre_get_posts', 'parse_request_url_post' );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
********************************************************************ХЛЕБНЫЕ КРОШКИ*************************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function dimox_breadcrumbs() {
  /* === ОПЦИИ === */
  $text['home'] = 'Главная'; // текст ссылки "Главная"
  $text['category'] = '%s'; // текст для страницы рубрики
  $text['search'] = 'Search results for "%s"'; // текст для страницы с результатами поиска
  $text['tag'] = 'Tagged with "%s"'; // текст для страницы тега
  $text['author'] = 'Authors articles %s'; // текст для страницы автора
  $text['404'] = 'Error 404'; // текст для страницы 404
  $text['page'] = 'Страница %s'; // текст 'Страница N'
  $text['cpage'] = 'Страница комментариев %s'; // текст 'Страница комментариев N'

  $wrap_before = '<ul>'; // открывающий тег обертки
  $wrap_after = '</ul>'; // закрывающий тег обертки
  $sep = '/'; // разделитель между "крошками"
  $sep_before = ''; // тег перед разделителем
  $sep_after = ''; // тег после разделителя
  $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
  $show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
  $show_current = 1; // 1 - показывать название текущей страницы, 0 - не показывать
  $before = '<li><span>'; // тег перед текущей "крошкой"
  $after = '</li></span>'; // тег после текущей "крошки"
  /* === КОНЕЦ ОПЦИЙ === */

  global $post;
  $home_url = home_url('/');
  $link_before = '<span><li>';
  $link_after = '</li></span>';
  $link_attr = '';
  $link_in_before = '';
  $link_in_after = '';
  $link = $link_before . '<li><a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a></li>' . $link_after;
  $frontpage_id = get_option('page_on_front');
  $parent_id = ($post) ? $post->post_parent : '';
  $sep = ' ' . $sep_before . $sep . $sep_after . ' ';
  $home_link = $link_before . '<li><a href="' . $home_url . '"' . $link_attr . '>' . $link_in_before . $text['home'] . $link_in_after . '</a></li>' . $link_after;

  if (is_home() || is_front_page()) {

    if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;

  } else {

    echo $wrap_before;
    if ($show_home_link) echo $home_link;

    if ( is_category() ) {
      $cat = get_category(get_query_var('cat'), false);
      if ($cat->parent != 0) {
        $cats = get_category_parents($cat->parent, TRUE, $sep);
        $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        if ($show_home_link) echo $sep;
        echo $cats;
      }
      if ( get_query_var('paged') ) {
        $cat = $cat->cat_ID;
        echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
      }

    } elseif ( is_search() ) {
      if (have_posts()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
      } else {
        if ($show_home_link) echo $sep;
        echo $before . sprintf($text['search'], get_search_query()) . $after;
      }

    } elseif ( is_day() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
      echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
      if ($show_current) echo $sep . $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
      if ($show_current) echo $sep . $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      //Категории (для single.php)
      if ($show_home_link) echo $sep;
      if ( get_post_type() != 'post' ) {
		if( get_post_type() == 'videocatalogue' ){			
			printf($link, $home_url, $post_type->labels->singular_name);
			
			if ($show_current) echo $before . get_the_title() . $after;
		}else if(get_post_type() == 'about-us' || get_post_type() == 'news'){
			$term = getRubricByID(get_the_ID());
												
			printf($link, $home_url . $term[0]->slug . '/', $term[0]->name);
			if ($show_current) echo $sep . $before . get_the_title() . $after;
		}else{
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			printf($link, $home_url . $slug['slug'] . '/', $post_type->labels->singular_name);
			if ($show_current) echo $sep . $before . get_the_title() . $after;
		}
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $sep);
        if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<li><a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a></li>' . $link_after, $cats);
        echo $cats;
        if ( get_query_var('cpage') ) {
          echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
        } else {
          if ($show_current) echo $before . get_the_title() . $after;
        }
      }

    // custom post type
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
	//Категории (для category.php)
	if(get_post_type() == 'projects'){		
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		
		if ( get_query_var('paged') ) {		
			echo $sep . sprintf($link, get_category_link($term->term_id), $term->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
		} else {
		  if ($show_current) echo $sep . $before . $term->name . $after;
		}
	}else{
		$post_type = get_post_type_object(get_post_type());	  
		if ( get_query_var('paged') ) {
		  echo $sep . sprintf($link, get_page_link( $post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
		} else {
		  if ($show_current) echo $sep . $before . $post_type->label . $after;
		}
	}

    } elseif ( is_attachment() ) {
      if ($show_home_link) echo $sep;
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $sep);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
      if ($show_home_link) echo $sep;
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $sep;
        }
      }
      if ($show_current) echo $sep . $before . get_the_title() . $after;
    } elseif ( is_tag() ) {
      if ( get_query_var('paged') ) {
        $tag_id = get_queried_object_id();
        $tag = get_tag($tag_id);
        echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
      }

    } elseif ( is_author() ) {
      global $author;
      $author = get_userdata($author);
      if ( get_query_var('paged') ) {
        if ($show_home_link) echo $sep;
        echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
      }

    } elseif ( is_404() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . $text['404'] . $after;

    } elseif ( has_post_format() && !is_singular() ) {
      if ($show_home_link) echo $sep;
      echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
} 

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
****************************************************************НАИБОЛЕЕ ПОПУЛЯРНЫЕ НОВОСТИ****************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


function set_popular_news(){

	$args = array(
		'post_type' => 'news',
		'meta_key' => 'wpb_post_views_count',
		'orderby' => 'meta_value',
		'posts_per_page' => 2
		
		
	);
	$query = new WP_Query;
	$my_posts = $query->query($args);
	
	return $my_posts;
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
************************************************************ПЕРЕИМЕНОВАВАНИЕ ЗАПИСЕЙ В ПРОДУКТЫ************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function change_post_menu_label() {
    global $menu, $submenu;
    $menu[5][0] = 'Продукты';
    $submenu['edit.php'][5][0] = 'Продукты';
    $submenu['edit.php'][10][0] = 'Добавить новость';
    $submenu['edit.php'][16][0] = 'Новостные метки';
    echo '';
}
add_action( 'admin_menu', 'change_post_menu_label' );

function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Продукты';
    $labels->singular_name = 'Продукты';
    $labels->add_new = 'Добавить продукт';
    $labels->add_new_item = 'Добавить продукт';
    $labels->edit_item = 'Редактировать продукт';
    $labels->new_item = 'Добавить продукт';
    $labels->view_item = 'Посмотреть продукт';
    $labels->search_items = 'Найти продукт';
    $labels->not_found = 'Не найдено';
    $labels->not_found_in_trash = 'Корзина пуста';
}
add_action( 'init', 'change_post_object_label' );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
**********************************************************************СТРАНИЦА ПОИСКА**********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function fb_filter_query( $query, $error = true ) {

	if ( is_search() ) {
		$query->is_search = false;
		$query->query_vars[s] = false;
		$query->query[s] = false;
		
		// если ошибка
		if ( $error == true )
		$query->is_404 = true;
	}
}
add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', create_function( '$a', "return null;" ) );

function getSearch(){
	global $wpdb;
	
	$data = array();
	
	if(isset($_POST['search'])){
		$search = $_POST['search'];
	
		if ($search == '') {
			unset($search);
		}
	}
	
	if(isset($_POST['sort_by'])){
		$sort_by = $_POST['sort_by'];
		
		if ($sort_by == '') {
			unset($sort_by);
		}
	}

	if(isset($_POST['search'])){
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		if(isset($_POST['search_in_descr'])){
			$search_in_descr = $_POST['search_in_descr'];
		}
		
		if($search_in_descr == 'on'){
			$get_id = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts AS p JOIN $wpdb->postmeta AS pm ON (p.ID = pm.post_id) AND pm.meta_value LIKE '%".$search."%' AND p.post_status = 'publish' AND p.post_type = 'post' AND pm.meta_key = 'description_product_page' ORDER BY post_title ".$sort_by."");
		}else{
			$get_id = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE post_title LIKE '%".$search."%' AND post_status = 'publish' AND post_type = 'post' ORDER BY post_title ".$sort_by."");
		}
			
		if($get_id){
			
			foreach($get_id as $value){
				
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'full');
				
				if(!empty($image_url)){ 
					$img = '<img src="'.$image_url[0].'" alt="'.get_post_meta( get_post_thumbnail_id($value->ID), '_wp_attachment_image_alt', true ).'">';
				}else{ 
					$img = '<img src="'.esc_url( get_template_directory_uri() ).'/images/but.jpg">';
				}
				
				$descr = wp_trim_words( wpautop(get_post_meta( $value->ID, 'short_description_product_page', $single = true )), 30, '...' );
				
				$link = get_permalink($value->ID);
				
				$data[] = array(
					//'all'   => $value,
					'image' => $img,
					'title' => $value->post_title,
					'descr' => $descr,
					'link'  => $link,
				);
			}
	
		}else{
			$data = array(
					'error' => 'Items not found!',
			);
		}
	}else{
		
		if($return_value){		
			$args=array(
				'post_type'  => 'post',
				'orderby'    => 'title',
				'order'      => 'ASC'
			);
			
			$return_value = query_posts($args);
				
			foreach($return_value as $value){
				
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'full');
				
				if(!empty($image_url)){ 
					$img = '<img src="'.$image_url[0].'" alt="'.get_post_meta( get_post_thumbnail_id($value->ID), '_wp_attachment_image_alt', true ).'">';
				}else{ 
					$img = '<img src="'.esc_url( get_template_directory_uri() ).'/images/but.jpg">';
				}
				
				$descr = wp_trim_words( wpautop(get_post_meta( $value->ID, 'short_description_product_page', $single = true )), 30, '...' );
				
				$link = get_permalink($value->ID);
				
				$data[] = array(
						//'all'   => $value,
						'image' => $img,
						'title' => $value->post_title,
						'descr' => $descr,
						'link'  => $link,
				);
			}
		}else{
			$data = array(
					'error' => 'Items not found!',
			);
		}
	}
	
	echo wp_send_json($data);

	wp_die();
}
add_action('wp_ajax_getSearch', 'getSearch');
add_action('wp_ajax_nopriv_getSearch', 'getSearch');