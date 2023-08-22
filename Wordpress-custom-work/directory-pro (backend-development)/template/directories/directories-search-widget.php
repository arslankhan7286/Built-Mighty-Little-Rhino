<?php
$current_post_type=get_option('_iv_directory_url');
if($current_post_type==""){$directory_url='directories';}

wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
$form_action='action='.get_post_type_archive_link($current_post_type).'';
include(wp_iv_directories_template.'directories/archive-top-search.php');
?>