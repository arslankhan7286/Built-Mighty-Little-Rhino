<?php
/**
 * Plugin Name: Our Office
 * Plugin URI: http://woothemes.com/
 * Description: Hi, I'm your office profile management plugin for WordPress. Show off what your office members using our shortcode, widget or template tag.
 * Author: WooThemes
 * Version: 1.3.0
 * Author URI: http://woothemes.com/
 *
 * @package WordPress
 * @subpackage Woothemes_Our_Office
 * @author Matty
 * @since 1.0.0
 */

require_once( 'classes/class-woothemes-our-office.php' );
require_once( 'classes/class-woothemes-our-office-taxonomy.php' );
require_once( 'woothemes-our-office-template.php' );
//require_once( 'classes/class-woothemes-widget-our-office.php' );



global $woothemes_our_office;
$woothemes_our_office = new Woothemes_Our_Office( __FILE__ );

$woothemes_our_office->version = '1.3.0';