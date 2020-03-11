<?php 
define( 'ptplg_url', '../' );
?>

<link href="<?=ptplg_url?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css" rel="stylesheet">
<link href="<?=ptplg_url?>css/mouldifi-bootstrap.css" rel="stylesheet">
<link href="<?=ptplg_url?>css/theme-indigo.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=ptplg_url?>css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">
<form class="form-horizontal" method="post" action="https://pintostudy.com/listPrograms">
	<div class="form-group">
        <div class="input-group">
            <input type="text" id="searchText" name="searchText" class="form-control search-tex-box" 
            placeholder="Example: Canada Business" required>
            <div class="input-group-append">
                <button class="btn-search btn-primary">
                <i class="zmdi zmdi-search"></i></button>
            </div>
        </div>
    </div>
</form>
