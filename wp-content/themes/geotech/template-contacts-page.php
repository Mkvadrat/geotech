<?php
/*
Template name: Contacts page
Theme Name: Geotech
Theme URI: http://geotechru.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта http://geotechru.com/
Version: 1.0
*/

get_header(); 
?>

    <main class="main-contacts">

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
                <div class="col-md-12">
                    <p class="title-uppercase"><?php the_title(); ?></p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="border-block">
                        <p class="small-title-bold">Moscow</p>
                        <p><strong>Phone/fax:</strong> <a href="tel:<?php echo getMeta('phone_fax_ru_contact_page'); ?>"><?php echo getMeta('phone_fax_ru_contact_page'); ?></a></p>
                        <p><strong>E-mail: </strong> <a href="email:<?php echo getMeta('email_ru_contact_page'); ?>"><?php echo getMeta('email_ru_contact_page'); ?></a></p>
                        <address><p><strong>Address:</strong><?php echo getMeta('address_ru_contact_page'); ?></p></address>
                        <p><strong>Map:</strong><span id="maps" style="width:452px; height:227px" class="map-block">
                        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&load=package.full" type="text/javascript"></script>
                        <script type="text/javascript">
                            var myMap;
                            ymaps.ready(init);
                            function init(){
                                ymaps.geocode('<?php echo getMeta('address_for_map_ru_contact_page'); ?>', {
                                        results: 1
                                }).then(
                                    function (res){
                                        var firstGeoObject = res.geoObjects.get(0),
                                        myMap = new ymaps.Map
                                        ("maps",{
                                            center: firstGeoObject.geometry.getCoordinates(),
                                            zoom: 15,
                                            controls: ["zoomControl", "fullscreenControl"]
                                            }
                                        );
                                        var myPlacemark = new ymaps.Placemark(
                                                firstGeoObject.geometry.getCoordinates(), {
                                                        iconContent: ''
                                                }, {
                                                        preset: 'twirl#blueStretchyIcon'
                                                }
                                        );
                                        myMap.geoObjects.add(myPlacemark);
                                        myMap.controls.add('typeSelector');
                                        myMap.behaviors.disable('scrollZoom');
                                    },
                                    function (err){
                                        alert(err.message);
                                    }
                                );
                            }
                        </script>
                        </span></p>
                    </div>
                </div>
                <div class="col-md-6 desctop-sidebar">
                    <div class="form">
                        <?php
                            $forms_a = getMeta('callback_contact_page');
                            if($forms_a){
                                echo do_shortcode('[contact-form-7 id=" ' . $forms_a . ' "]'); 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="title-uppercase">REGIONAL DEALERS, AGENTS AND REPRESENTATIVES</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="border-block regional-dillers">
                        <p class="small-title-bold">CHINA</p>
                        <p class="ltd"><?php echo getMeta('company_partner_cn_contact_page'); ?></p>
                        <address><p><strong>Office Add:</strong><span><?php echo getMeta('address_cn_contact_page'); ?></span></p></address>
                        <p><strong>Tel: </strong> <a href="tel:<?php echo getMeta('phone_cn_contact_page'); ?>"><?php echo getMeta('phone_cn_contact_page'); ?></a></p>
                        <p><strong>Fax: </strong> <a href="tel:<?php echo getMeta('fax_cn_contact_page'); ?>"><?php echo getMeta('fax_cn_contact_page'); ?></a></p>
                        <p><strong>Mobile: </strong> <a href="<?php echo getMeta('mobile_cn_contact_page'); ?>"><?php echo getMeta('mobile_cn_contact_page'); ?></a></p>
                        <p><strong>E-mail: </strong> <a href="<?php echo getMeta('email_cn_contact_page'); ?>"><?php echo getMeta('email_cn_contact_page'); ?> </a></p>
                        <p><strong>Website: </strong> <a href="<?php echo getMeta('website_cn_contact_page'); ?>"><?php echo getMeta('website_cn_contact_page'); ?></a></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border-block regional-dillers">
                        <p class="small-title-bold">ARGENTINA</p>
                        <p class="ltd"><?php echo getMeta('company_partner_ag_contact_page'); ?></p>
                        <address><p><strong>Office Add:</strong><span><?php echo getMeta('address_ag_contact_page'); ?></span></p></address>
                        <p><strong>Tel: </strong> <a href="tel:<?php echo getMeta('phone_ag_contact_page'); ?>"><?php echo getMeta('phone_ag_contact_page'); ?></a></p>
                        <p><strong>Fax: </strong> <a href="tel:<?php echo getMeta('fax_ag_contact_page'); ?>"><?php echo getMeta('fax_ag_contact_page'); ?></a></p>
                        <p><strong>Mobile: </strong> <a href="tel:<?php echo getMeta('mobile_ag_contact_page'); ?>"><?php echo getMeta('mobile_ag_contact_page'); ?></a></p>
                        <p><strong>E-mail: </strong> <a href="<?php echo getMeta('email_ag_contact_page'); ?>"><?php echo getMeta('email_ag_contact_page'); ?></a>, <a href="<?php echo getMeta('email__two_ag_contact_page'); ?>"><?php echo getMeta('email__two_ag_contact_page'); ?></a></p>
                        <p><strong>Website: </strong> <a href="<?php echo getMeta('website_ag_contact_page'); ?>"><?php echo getMeta('website_ag_contact_page'); ?></a></p>
                    </div>
                </div>

                <div class="col-md-6 mobile-sidebar">
                    <div class="form">
                        <?php
                            $forms_b = getMeta('callback_contact_page');
                            if($forms_b){
                                echo do_shortcode('[contact-form-7 id=" ' . $forms_a . ' "]'); 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>