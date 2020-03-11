<?php
/** Define ABSPATH as this file's directory */
require_once( './wp-includes/pluggable.php' );
require_once( './wp-load.php' );
$user = wp_get_current_user();
echo $user->exists();
?>