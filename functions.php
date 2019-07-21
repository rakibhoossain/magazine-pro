<?php

$magazine_pro_theme = wp_get_theme( 'magazine-pro' );

define( 'MAGAZINE_PRO_VERSION', $magazine_pro_theme->get( 'Version' ) );

require get_template_directory() . '/inc/class-magazine-pro.php';


function magazine_pro_run() {

	$magazine_pro = new Magazine_Pro();
}

magazine_pro_run();