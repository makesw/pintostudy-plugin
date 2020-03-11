<?php
define( 'path_img_log_univ', 'https://pintostudy.com/wp-content/uploads/university-logos/');
session_start();
require_once(ptplg_path . 'conexion.php');
require_once(ptplg_path . 'lng/lang_en.php');
$program = mysqli_fetch_array($connect->query("SELECT p.*, u.columna_34 logo_universidad, u.columna_24 costo_vida, u.columna_25 app_fee,
u.columna_23 tuition_fee,u.columna_30 about_university, u.columna_33 link_video_uni, u.columna_7 type_uni, u.columna_8 type_prog_uni, 
u.columna_9 found_year_uni, u.columna_14 cant_est_uni, u.columna_18 facult_uni, u.columna_23 averg_cost_uni,u.columna_24 
averg_costliv_uni,u.columna_24 app_fee_uni FROM program p JOIN university u WHERE p.columna_2 = u.columna_2 AND 
p.columna_7='" . $_GET['prog'] . "' AND p.columna_3 = u.columna_4"));

$university;
if( isset($_GET['university'])){
    $university = $_GET['university'];
}
$selectFilter='';
if(isset($_GET['selectFilter'])){
    $selectFilter = '?selectFilter=On';
}
?>
<!-- material-design-iconic-font stylesheet -->
<link
	href="<?=ptplg_url?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css"
	rel="stylesheet">
<!-- /material-design-iconic-font stylesheet -->

<!-- theme-indigo stylesheet -->
<link href="<?=ptplg_url?>css/theme-indigo.min.css" rel="stylesheet">
<!-- /theme-indigo stylesheet -->
<!-- theme-indigo stylesheet -->
<link rel="stylesheet" type="text/css"
	href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap.min.css">
<!-- /theme-indigo stylesheet -->
<!-- Bootstrap stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-bootstrap.css" rel="stylesheet">
<!-- /bootstrap stylesheet -->
<!-- Mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">

<style type="text/css">::-webkit-scrollbar
    {
        width: 0px;
    }
    ::-webkit-scrollbar-track-piece
    {
        background-color: transparent;
        -webkit-border-radius: 6px;
    }
</style>
<div class="gx-main-content-detail">
<div class="row mb-md-4 text-left row-detail" style="margin-right: 0px;">
 	<div class="col-sm-4" style="margin: auto;">			
		<h1 class="font-weight-bold">
			<?= $program['columna_2'] ?><small> /  <?= $program['columna_7'].' / '.$program['columna_6'] ;?>
			</small>
		</h1>
	</div>	
	<div class="col-sm-4 text-right" style="margin: auto;">		
		<h3 class="card-title">Application Fee: <?php echo is_numeric($program['app_fee']) ?  '$ '.number_format($program['app_fee'],0).$USD : $program['app_fee']; ?></h3>
		<h3 class="card-title">Tuition Fee: <?php echo is_numeric($program['tuition_fee']) ? '$ '.number_format($program['tuition_fee'],0).' - $'.number_format(( ($program['tuition_fee']*0.1)+$program['tuition_fee']),0).$USD : $program['tuition_fee']; ?></h3>
	</div>
	
	<div class="col-sm-4 text-right" style="margin: auto;">		
		<img style="max-width: 40%;" src="<?=path_img_log_univ.$program['logo_universidad'].'.png';?>" class="img-fluid">
	</div>
</div>

<div class="animated slideInUpTiny animation-duration-3">
	
    <div id="accordion">
    	<div class="card">
    		<div class="card-header" id="headingOne">
    			<h5 class="mb-0">
    				<button id="btn-collapseOne" class="dropdown-toggle btnDown" data-toggle="collapse"
    					data-target="#collapseOne" aria-expanded="true"
    					aria-controls="collapseOne"><?=$DESCRIPTION?></button>
    			</h5>
    		</div>
    
    		<div id="collapseOne" class="collapse show"
    			aria-labelledby="headingOne" data-parent="#accordion">
    			<div class="card-body word-break: break-all">
    				<div class="row mb-md-4">
    					<div class="col-xl-4 col-sm-6 col-12">
    						<h3 class="font-weight-bold">City: <small> <?= $program['columna_3'].', '.$program['columna_1'] ?></small></h3>
    						<h3 class="font-weight-bold">Faculty: <small> <?= $program['columna_4'] ?></small></h3>
    						<h3 class="font-weight-bold">Interships / Coop: <small> <?= $program['columna_11'] ?></small></h3>    						
    					</div>
    					<div class="col-xl-4 col-sm-6 col-12">    						    							
							<h3 class="font-weight-bold">Campus: <small> <?= $program['columna_8'] ?></small></h3>
    						<h3 class="font-weight-bold">Lenght: <small> <?= $program['columna_10'] ?></small></h3>
    						<h3 class="font-weight-bold">Starts: <small> <?= $program['columna_12'] ?></small></h3>     							
    					</div>
    				</div><br />
    				<h3 class="font-weight-bold">
    					<div>About the Program:</div>
    				</h3><br/>
    				<p>
    				<?php echo str_replace("\n", "<br>", $program['columna_16']);?>
    				</p>
    	</div>
    		</div>
    	</div>
    	<div class="card">
    		<div class="card-header" id="headingTwo">
    			<h5 class="mb-0">
    				<button id="btn-collapseTwo" class="dropdown-toggle btnDown" data-toggle="collapse"
    					data-target="#collapseTwo" aria-expanded="false" 
    					aria-controls="collapseTwo">Requirments</button>
    			</h5>
    		</div>
    		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
    			data-parent="#accordion">
    			<div class="card-body">
    				<h3 class="font-weight-bold">Admission Requirments:</h3><br/>
    	<p><?php echo str_replace("\n", "<br>", $program['columna_17']);?><p/>
    				
    				<h3 class="font-weight-bold">Language Requirments:</h3><br/>
    	<p><?php echo str_replace("\n", "<br>", $program['columna_19']);?><p/>
    </div>
    		</div>
    	</div>
    	<div class="card">
    		<div class="card-header" id="headingThree">
    			<h5 class="mb-0">
    				<button class="dropdown-toggle btnDown" data-toggle="collapse"
    					data-target="#collapseThree" aria-expanded="false" id="btn-collapseThree"
    					aria-controls="collapseThree">University Info</button>
    			</h5>
    		</div>
    		<div id="collapseThree" class="collapse"
            			aria-labelledby="headingThree" data-parent="#accordion">
            			<div class="card-body word-break: break-all">
					<div class="row mb-md-4">
						<div class="col-xl-6 col-sm-6 col-12">
							<?php echo str_replace("\n", "<br>", $program['about_university']);?><br/><br />
							<h3 class="font-weight-bold">Type of University: <small> <?php echo $program['type_uni'];?></small></h3>
                            <h3 class="font-weight-bold">Type of Programs: <small> <?php echo $program['type_prog_uni'];?></small></h3>
                            <h3 class="font-weight-bold">Fundation Year: <small> <?php echo $program['found_year_uni'];?></small></h3>
                            <h3 class="font-weight-bold">Number of Students: <small> <?php echo is_numeric($program['cant_est_uni']) ? number_format($program['cant_est_uni'],0): ''; ?></small></h3>
                            
                            <h3 class="font-weight-bold">Average Cost of Tuition: <small> <?php echo is_numeric($program['averg_cost_uni']) ? '$ '.number_format($program['averg_cost_uni'],0).$USD: ''; ?></small></h3>
                            <h3 class="font-weight-bold">Average Cost Living / Year: <small> <?php echo is_numeric($program['averg_costliv_uni']) ? '$ '.number_format($program['averg_costliv_uni'],0).$USD: ''; ?></small></h3>
                            <h3 class="font-weight-bold">Aplication Fee: <small> <?php echo is_numeric($program['app_fee_uni']) ? '$ '.number_format($program['app_fee_uni'],0).$USD: ''; ?></small></h3>
                            <h3 class="font-weight-bold">Faculties: <small> <?php echo $program['facult_uni'];?></small></h3>
                            
						</div>
						<div class="col-xl-6 col-sm-6 col-12 text-center"">
							<iframe width="560" height="315"
            						src="<?php echo str_replace("watch?v=","embed/",$program['link_video_uni']);?>" frameborder="0"
            						allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            						allowfullscreen></iframe>
						</div>
					</div>
				</div>
    		</div>
    	</div>
    </div>
</div>
<div class="btn-group dropleft no-border">
    <a href="<?php echo empty($university) ? '../listPrograms/'.$selectFilter: '../universities/universityDetail.php?name='.$university ;  ?>"
    	class="gx-btn-light-green btnDetail dropdown-toggle btnBack">
    	<?=$BTN_BACK?>
    </a>
</div>
<div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h2 class="modal-title" id="exampleModalLongTitle"><?=$LOGIN_HEAD_MESSAGE?></h2>
                <a href="javascript:close_modal();" class="close" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
                <p><?=$LOGIN_TEXT_MESSAGE?></p>
            </div>
            <div class="modal-footer border-0">
                <a href="javascript:continue_login_register();" class="btn text-primary card-link btn-round"><?=$BTN_CONTINUE?></a>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript"
	src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript"
	src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
var idClose;
var array;
var myWindow;
jQuery(function($){
$("button").click(function(event){
  var idElement = this.id;
  if(this.id !=null && this.id != 'btn-collapseOne'){
	  event.preventDefault();	
	  jQuery.ajax({url: "../../validateSesionLogin.php", success: function(result){		  
		  if( result !=1 ){
			  	if(myWindow != null){
					myWindow.close();
				}
			  	$('.collapse').collapse('toggle');
				//si no existe sesión cerramos la acordeon y mostramos el modal para registro o inicio de sesión:
				array = idElement.split("-");	
				idClose = '#'+array[1];
				jQuery(function($){
					$( "#exampleModalCenter4" ).modal('show');
				});
				
			}			
	  }});
  }
});
});

function continue_login_register(){
	jQuery(function($){
		$( "#exampleModalCenter4" ).modal('toggle');
		myWindow = window.open("https://pintostudy.com/login/", "_blank");
	});	
}
function close_modal(){
	jQuery(function($){
		$( "#exampleModalCenter4" ).modal('toggle');
	});
}
</script>