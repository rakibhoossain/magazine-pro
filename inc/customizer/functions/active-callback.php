<?php
/**
 * Active Callback functions for this theme
 *
 * @package Magazine_Pro
 */

/*
 *	Active Callback For When Ticker News Is Enabled
 */
if( ! function_exists( 'magazine_pro_is_ticker_news_enabled' ) ) {

	function magazine_pro_is_ticker_news_enabled( $control ) {
		
		if( $control->manager->get_setting( 'magazine_pro_enable_ticker_news' )->value() == true ) {
			return true;
		} else {
			return false;
		}
	}
}

/*
 *	Active Callback For When Banner/Slider Is Enabled
 */
if( ! function_exists( 'magazine_pro_is_banner_active' ) ) {

	function magazine_pro_is_banner_active( $control ) {
		
		if( $control->manager->get_setting( 'magazine_pro_enable_banner' )->value() == true ) {
			return true;
		} else {
			return false;
		}
	}
}

/*
 * Active callback function for when header layout one is active	
 */
if( ! function_exists( 'magazine_pro_is_header_one_active' ) ) {

	function magazine_pro_is_header_one_active( $control ) {
		
		if( $control->manager->get_setting( 'magazine_pro_select_header_layout' )->value() == 'header_1' ) {
			return true;
		} else {
			return false;
		}
	}
}


/*
 * Active callback function for when header layout two is active	
 */
if( ! function_exists( 'magazine_pro_is_header_two_active' ) ) {

	function magazine_pro_is_header_two_active( $control ) {
		
		if( $control->manager->get_setting( 'magazine_pro_select_header_layout' )->value() == 'header_2' ) {
			return true;
		} else {
			return false;
		}
	}
}


/*
 *	Active Callback For When Related Section Is Active
 */
if( ! function_exists( 'magazine_pro_is_related_section_active' ) ) {

	function magazine_pro_is_related_section_active( $control ) {
		
		if( $control->manager->get_setting( 'magazine_pro_enable_related_section' )->value() == true ) {
			return true;
		} else {
			return false;
		}
	}
}
