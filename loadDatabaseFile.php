<?php
session_start();
require_once(ptplg_path . '/conexion.php');
require_once(ptplg_path . '/lng/lang_en.php');
?>
<!-- material-design-iconic-font stylesheet -->
<link href="<?=ptplg_url?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css" rel="stylesheet">
<!-- /material-design-iconic-font stylesheet -->
<!-- theme-indigo stylesheet -->
<link href="<?=ptplg_url?>css/theme-indigo.min.css" rel="stylesheet">
<!-- /theme-indigo stylesheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">
<!-- Bootstrap stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-bootstrap.css" rel="stylesheet">
<!-- /bootstrap stylesheet -->
<!-- Main Content -->
<!-- Dropzone stylesheet -->
<link href="<?=ptplg_url?>node_modules/dropzone/dist/dropzone.css" rel="stylesheet">
<!-- /dropzone stylesheet -->
<!-- Color-Theme stylesheet -->
<link id="override-css-id" href="<?=ptplg_url?>css/theme-indigo.min.css" rel="stylesheet">
<!-- Color-Theme stylesheet -->
<div class="loader-backdrop">
    <!-- Loader -->
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>
    <!-- /loader-->
</div>
<div class="gx-main-content full-screen text-center">
	
    <form id="fupForm"  enctype="multipart/form-data" class="text-center"><br/><br/>
    	<input type="file" id="file" name="file" required accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /><br/><br/>
    	<div class="form-group text-center">
    		<div class="custom-control custom-checkbox custom-control-inline">
                <input class="form-check-input" type="radio" name="radio" id="radioProgram" value="programs">
                <label for="radioProgram"> Only Programs</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input class="form-check-input" type="radio" name="radio" id="radioUniversity" value="universities">
                <label for="radioUniversity"> Only Universities</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input class="form-check-input" type="radio" name="radio" id="radioUniversity" value="both">
                <label for="radioUniversity"> Both</label>
            </div>
    	</div>
    	<input type="submit" name="submit" id="btnSubmit" class="gx-btn gx-btn-light-green btn-round" value="<?= $BTN_UPLOAD ?>"/>
    </form>
    <br/><br/>
    <div id="successAlert" class="alert alert-success fade show border" role="alert">
        OK: Procces load file to database Finish
    </div>
    <div id = "unSuccessAlert" class="alert alert-secondary fade show border" role="alert">
       	FAIL: Procces load file to database Finish Whit Fails
    </div>
</div>
<!-- Menu Backdrop -->
<div class="menu-backdrop fade"></div>
<!-- /menu backdrop -->
<!--Load JQuery-->
<script src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<!--Bootstrap JQuery-->
<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--Perfect Scrollbar JQuery-->
<script src="<?=ptplg_url?>node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<!--Big Slide JQuery-->
<script src="<?=ptplg_url?>node_modules/bigslide/dist/bigSlide.min.js"></script>
<!--Dropzone JQuery-->
<script src="<?=ptplg_url?>node_modules/dropzone/dist/dropzone.js"></script>
<!--Custom JQuery-->
<script src="<?=ptplg_url?>js/functions.js"></script>
<script>
jQuery(function($){

    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#fupForm").on('submit', function(e){
        	 $('#successAlert').hide();
        	 $('#unSuccessAlert').hide();
            jQuery.ajax({
                url: "<?=ptplg_url?>/proccessFile.php",
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#btnSubmit').attr("disabled","disabled");
                    $('#fupForm').css("opacity",".5");
                }, 
                success: function(data){
                	//console.log( data );
                	$('#fupForm').css("opacity","");
                    $("#btnSubmit").removeAttr("disabled");
                    $("#file").val('');
                	var obj = JSON.parse(data);     	
                	if( obj.status == 1){
                		$("#successAlert" ).text(data);                		
                		$('#successAlert').show();
                	}else{
                		$("#unSuccessAlert" ).text(data);
                		$('#unSuccessAlert').show();
                	}              		
              	}});
            e.preventDefault();	  
        });
    });

    $('#successAlert').hide();
    $('#unSuccessAlert').hide();
    
});
</script>
<?php $connect->close(); ?>