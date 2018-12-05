<?php
/**
 * Defines the ASD_AddPageSections class
 *
 * @package        WordPress
 * @subpackage     ASD_PageSections
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ----------------------------------------------------------------------------
 *   class ASD_AddPageSections
 *   instantiated by an instance of the ASD_PageSectionsShortscode class,
 *   which also passes along the shortcode parameters.
 *  --------------------------------------------------------------------------*/
class ASD_AddPageSections extends ASD_AddCustomPosts_1_201811241 {


	/** ----------------------------------------------------------------------------
	 *   contsructor
	 *   calls two functions, to set default shortcode parameters,
	 *   and another to parse parameters from the shortcode
	 *  ----------------------------------------------------------------------------
	 *
	 *   @param Array $atts - Parameters passed from the shortcode through
	 *   the ASD_PagesectionsShortscode instance.
	 */
	public function __construct( $atts ) {
		parent::__construct( $atts, ASD_PAGESECTIONS_DIR, 'pagesections-template.php', 'pagesections' );
	}

}

