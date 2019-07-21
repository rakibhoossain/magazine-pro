<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Magazine_Pro
 */
	
	/**
	* Hook - magazine_pro_doctype.
	*
	* @hooked magazine_pro_doctype_action - 10
	*/
	do_action( 'magazine_pro_doctype' );

	/**
	* Hook - magazine_pro_head.
	*
	* @hooked magazine_pro_head_action - 10
	*/
	do_action( 'magazine_pro_head' );

	/**
	* Hook - magazine_pro_body_before.
	*
	* @hooked magazine_pro_body_before_action - 10
	*/
	do_action( 'magazine_pro_body_before' );

	/**
	* Hook - magazine_pro_page_wrapper_start.
	*
	* @hooked magazine_pro_page_wrapper_start_action - 10
	*/
	do_action( 'magazine_pro_page_wrapper_start' );

	/**
	* Hook - magazine_pro_header_section.
	*
	* @hooked magazine_pro_header_section_action - 10
	*/
	do_action( 'magazine_pro_header_section' );

