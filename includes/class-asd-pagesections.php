<?php
/**
 *
 * Defines the custom post type class ASD_Pagesections.
 *
 * @package        WordPress
 * @subpackage     ASD_PageSections
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}


if ( ! class_exists( 'ASD_Pagesections' ) ) {
	/** ----------------------------------------------------------------------------
	 *  class ASD_Pagesections
	 *  exends whatever the latest version of ASD_Custom_Post_ exists
	 *  defines custom post type
	 *  --------------------------------------------------------------------------*/
	class ASD_Pagesections extends ASD_Custom_Post_1_201811241 {

		/** ----------------------------------------------------------------------------
		 *
		 *   @var $customargs holds all the information that will define the
		 *   custom post type
		 *  --------------------------------------------------------------------------*/
		private $customargs = array(
			'label'               => 'Page Sections',
			'description'         => 'Page Sections',
			'labels'              => array(
				'name'               => 'Page Sections',
				'singular_name'      => 'Page Section',
				'menu_name'          => 'Page Sections',
				'parent_item_colon'  => 'Parent Page Section:',
				'all_items'          => 'All Page Sections',
				'view_item'          => 'View Page Section',
				'add_new_item'       => 'Add New Page Section',
				'add_new'            => 'Add New',
				'edit_item'          => 'Edit Page Section',
				'update_item'        => 'Update Page Section',
				'search_items'       => 'Search Page Sections',
				'not_found'          => 'Page Section Not Found',
				'not_found_in_trash' => 'Page Section Not Found In Trash',
			),
			'menu_icon'           => 'dashicons-editor-insertmore',
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies'          => array( 'pagesectiongroups', 'category' ),
			'rewrite'             => array( 'slug' => 'pagesections' ),
			'heirarchical'        => false,
			'public'              => true,
			'has_archive'         => false,
			'capability_type'     => 'page',
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'show_admin_column'   => true,
			'can_export'          => true,
			'menu_position'       => 31,
		);


		/** ----------------------------------------------------------------------------
		 *
		 *   Function __construct is the constructor, makes call to parent class constructor
		 *   to set up the custom post type
		 *  --------------------------------------------------------------------------*/
		public function __construct() {

			/* check the option, and if it's not set don't show this cpt in the dashboard main meny */
			global $asd_cpt_dashboard_display_options;
			if ( get_option( 'asd_pagesection_display' ) === $asd_cpt_dashboard_display_options[2] ) {
				$this->customargs['show_in_menu'] = 0;
			}

			parent::__construct( 'pagesections', $this->customargs );
		}

	}

}


