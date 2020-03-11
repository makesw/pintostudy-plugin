<?php
/*
Plugin Name: PintoStudy
Plugin URI: http://pintostudy.com/
Description: Is a digital native company, born with the experience in International Higher Education of three important companies in Latin America.
Version: 1.0.0
Author: makesw
Author URI: http://makesw.com/
Text Domain: pintostudy-plugin
*/

defined( 'ABSPATH' ) || exit;

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$plugin_data = get_plugin_data( __FILE__ );

define( 'ptplg_url', plugin_dir_url( __FILE__ ) );
define( 'ptplg_path', plugin_dir_path( __FILE__ ) );

add_shortcode( 'include-home-programs', 'includeHomePrograms' );
function includeHomePrograms( ) {
    include 'programs/index.php';
}
add_shortcode( 'include-search-programs', 'includeSearchPrograms' );
function includeSearchPrograms( ) {
    include 'programs/listPrograms.php';
}
add_shortcode( 'include-program-detail', 'includeProgramdetail' );
function includeProgramdetail( ) {
    include 'programs/programDetail.php';
}
add_shortcode( 'include-home-universities', 'includeHomeUniversities' );
function includeHomeUniversities( ) {
    include 'universities/index.php';
}
add_shortcode( 'include-university-detail', 'includeUniversityDetail' );
function includeUniversityDetail( ) {
    include 'universities/universityDetail.php';
}
add_shortcode( 'include-database-loadfile', 'includeDatabaseLoadFile' );
function includeDatabaseLoadFile( ) {
    include 'loadDatabaseFile.php';
}
add_shortcode( 'include-search-text-box', 'includeTexSearchtBox' );
function includeTexSearchtBox( ) {
    include 'programs/searchProgramText.php';
}
?>
