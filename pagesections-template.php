<?php
/**
 * A template for inserting asd-pagesection post types with the shorcode.
 *
 * @package        WordPress
 * @subpackage     ASD_PageSections
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

global $post;
echo '<div class="asd-pagesections clearfix">' . "\r\n";
the_content();
echo '</div>' . "\r\n";
