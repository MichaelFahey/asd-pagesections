<?php
/**
 *  Defines the ASD_PageSectionsShortcode class.
 *
 *  @package         WordPress
 *  @subpackage      ASD_PageSections
 *  Author:          Michael H Fahey
 *  Author URI:      https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ----------------------------------------------------------------------------
 *   class ASD_PageSectionsShortcode
 *   used to create a shortcode for asdpagesection post types and instantiate the
 *   ASD_AddPageSections class to return template-formatted post data.
 *  --------------------------------------------------------------------------*/
class ASD_PagesectionsShortcode {

	/** ----------------------------------------------------------------------------
	 *   constructor
	 *   Defines a new shortcode for inserting asdpagesection custom post types.
	 *   Shortcode is [asd_insert_pagesections]
	 *  --------------------------------------------------------------------------*/
	public function __construct() {
		add_shortcode( 'asd_insert_pagesections', array( &$this, 'asd_insert_pagesections' ) );
	}

	/** ----------------------------------------------------------------------------
	 *   function asd_insert_pagesections( $shortcode_params )
	 *   This function is a callback set in add_shortcode in the class constructor.
	 *   This function instantiates a new ASD_AddPageSections class object and
	 *   passes parameter data from the shortcode to the new object.
	 *  ----------------------------------------------------------------------------
	 *
	 *   @param Array $shortcode_params - data from the shortcode.
	 */
	public function asd_insert_pagesections( $shortcode_params ) {
		$posts = new ASD_AddPageSections( $shortcode_params );

		ob_start();
		echo wp_kses_post( $posts->output_customposts() );
		return ob_get_clean();
	}

}
