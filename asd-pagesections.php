<?php
/**
 *
 * This is the root file of the ASD PageSections WordPress plugin
 *
 * @package        WordPress
 * @subpackage     ASD_PageSections
 *
 * Plugin Name:    ASD PageSections
 * Plugin URI:     https://artisansitedesigns.com/pagesection/asd-pagesections/
 * Description:    Defines an "ASD PageSection" Custom Post Type for use in containerizing, modularizing, and organizing large or complex HTML pages or other DOM components.
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey/
 * Text Domain:    asd_pagesections
 * License:        GPL3
 * Version:        1.201812042
 *
 * ASD PageSections is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * ASD PageSections is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ASD PageSections. If not, see
 * https://www.gnu.org/licenses/gpl.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

$asd_pagesections_file_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );
$asd_pagesections_version   = $asd_pagesections_file_data['Version'];

if ( ! defined( 'ASD_PAGESECTIONS_DIR' ) ) {
	define( 'ASD_PAGESECTIONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'ASD_PAGESECTIONS_URL' ) ) {
	define( 'ASD_PAGESECTIONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once 'includes/asd-admin-menu/asd-admin-menu.php';
require_once 'includes/class-asd-custom-post/class-asd-custom-post.php';
require_once 'includes/class-asd-addcustomposts/class-asd-addcustomposts.php';
require_once 'includes/class-asd-pagesections.php';
require_once 'includes/class-asd-pagesectionsshortcode.php';
require_once 'includes/class-asd-addpagesections.php';


/* include components */
if ( ! class_exists( 'Gizburdt\Cuztom\Cuztom' ) ) {
	include 'components/cuztom/cuztom.php';
}



/** ----------------------------------------------------------------------------
 *   Function asd_pagesection_admin_submenu()
 *   Adds two submenu pages to the admn menu with the asd_settings slug.
 *   This admin top menu is loaded in includes/asd-admin-menu.php .
 *  --------------------------------------------------------------------------*/
function asd_pagesection_admin_submenu() {
	global $asd_cpt_dashboard_display_options;
	if ( get_option( 'asd_pagesection_display' ) !== $asd_cpt_dashboard_display_options[1] ) {
		add_submenu_page(
			'asd_settings',
			'PageSections',
			'PageSections',
			'manage_options',
			'edit.php?post_type=pagesections',
			''
		);
	}
	if ( 'false' !== get_option( 'asd_pagesectiongroups_display' ) ) {
		add_submenu_page(
			'asd_settings',
			'PageSection Groups',
			'PageSection Groups',
			'manage_options',
			'edit-tags.php?taxonomy=pagesectiongroups',
			''
		);
	}
}
if ( is_admin() ) {
		add_action( 'admin_menu', 'asd_pagesection_admin_submenu', 15 );
}


/** ----------------------------------------------------------------------------
 *   function instantiate_asd_pagesection_class_object()
 *   create a single ASD_Pagersections instance
 *   Hooks into the init action
 *  --------------------------------------------------------------------------*/
function instantiate_asd_pagesection_class_object() {
	$asd_pagesection_type = new ASD_Pagesections();
}
add_action( 'init', 'instantiate_asd_pagesection_class_object' );


/** ----------------------------------------------------------------------------
 *   function instantiate_asd_pagesection_shortcode_object()
 *   create a single ASD_PageSectionsShortcode instance
 *   Hooks into the plugins_loaded action
 *  --------------------------------------------------------------------------*/
function instantiate_asd_pagesection_shortcode_object() {
	new ASD_PagesectionsShortcode();
}
add_action( 'plugins_loaded', 'instantiate_asd_pagesection_shortcode_object' );



/** ----------------------------------------------------------------------------
 *   function asdpagesection_rewrite_flush()
 *   This rewrites the permalinks but ONLY when the plugin is activated
 *  --------------------------------------------------------------------------*/
function asdpagesection_rewrite_flush() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'asdpagesection_rewrite_flush' );



/** ----------------------------------------------------------------------------
 *   function asd_register_settings_asd_pagesection()
 *  --------------------------------------------------------------------------*/
function asd_register_settings_asd_pagesection() {

	register_setting( 'asd_dashboard_option_group', 'asd_pagesection_display' );
	register_setting( 'asd_dashboard_option_group2', 'asd_pagesectiongroups_display' );

	/** ----------------------------------------------------------------------------
	 *   add the names of the post types and taxonomies being added
	 *  --------------------------------------------------------------------------*/
	global $asd_cpt_list;
	global $asd_tax_list;
	array_push(
		$asd_cpt_list,
		array(
			'name' => 'PageSections',
			'slug' => 'pagesections',
			'desc' => 'Pieces of content that can be used to contain complex html, re-usable sections, or to break up a really big page into manageable pieces.',
			'link' => '',
		)
	);
	array_push( $asd_tax_list, 'asdpagesectiongroups' );
}
if ( is_admin() ) {
	add_action( 'admin_init', 'asd_register_settings_asd_pagesection' );
}


/** ----------------------------------------------------------------------------
 *   function asd_add_settings_asd_pagesection()
 *  --------------------------------------------------------------------------*/
function asd_add_settings_asd_pagesection() {
	global $asd_cpt_dashboard_display_options;

	add_settings_field(
		'asd_pagesection_display_fld',
		'show PageSections in:',
		'asd_select_option_insert',
		'asd_dashboard_option_group',
		'asd_dashboard_option_section_id',
		array(
			'settingname'   => 'asd_pagesection_display',
			'selectoptions' => $asd_cpt_dashboard_display_options,
		)
	);

}
if ( is_admin() ) {
	add_action( 'asd_dashboard_option_section', 'asd_add_settings_asd_pagesection' );
}


/** ----------------------------------------------------------------------------
 *   function asd_add_settings_asd_pagesectiongroups()
 *  --------------------------------------------------------------------------*/
function asd_add_settings_asd_pagesectiongroups() {
	add_settings_field(
		'asd_pagesectiongroups_display_fld',
		'show Pagesectiongroups in submenu:',
		'asd_truefalse_select_insert',
		'asd_dashboard_option_group2',
		'asd_dashboard_option_section2_id',
		'asd_pagesectiongroups_display'
	);
}
if ( is_admin() ) {
	add_action( 'asd_dashboard_option_section2', 'asd_add_settings_asd_pagesectiongroups' );
}




/** ----------------------------------------------------------------------------
 *   function asd_pagesections_enqueues()
 *   enqueue some CSS for this custom post type
 *  --------------------------------------------------------------------------*/
function asd_pagesections_enqueues() {
	wp_enqueue_style( 'asd_pagesections', ASD_PAGESECTIONS_URL . 'css/asd-pagesections.css', array(), $asd_pagesections_version );
}
add_action( 'wp_enqueue_scripts', 'asd_pagesections_enqueues' );


/** ----------------------------------------------------------------------------
 *   function admin_enqueue_cuztom()
 *   enqueue some CSS for cuztom controls in dashboard, admin_init action
 *  --------------------------------------------------------------------------*/
function admin_enqueue_cuztom() {
	wp_enqueue_style( 'asd-admin-cuztom', ASD_PAGESECTIONS_URL . '/css/asd-admin-cuztom.css', array(), $asd_pagesections_version );
}
add_action( 'admin_init', 'admin_enqueue_cuztom' );




/** ----------------------------------------------------------------------------
 *   Function asd_pagesection_plugin_action_links()
 *   Adds links to the Dashboard Plugin page for this plugin.
 *   Hooks to admin_menu action.
 *  ----------------------------------------------------------------------------
 *
 *   @param Array $actions -  Returned as an array of html links.
 */
function asd_pagesection_plugin_action_links( $actions ) {
	if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
		$actions[0] = '<a target="_blank" href="https://artisansitedesigns.com/plugins/asd-pagesections#support/">Help</a>';
		/* $actions[1] = '<a href="' . admin_url()   . '">' .  'Settings'  . '</a>';  */
	}
		return apply_filters( 'pagesections_actions', $actions );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'asd_pagesection_plugin_action_links' );
