<?php
require_once(ptplg_path . 'conexion.php');
require_once(ptplg_path . 'lng/lang_en.php');
define( 'path_img_log_univ', 'https://pintostudy.com/wp-content/uploads/university-logos/');
$university = mysqli_fetch_array($connect->query("select * from university u where u.columna_2 ='" . $_GET['nombre'] . "'"));
$queryPrograms = "SELECT p.*, u.columna_34 logo_universidad, u.columna_24 costo_vida, u.columna_25 app_fee,
u.columna_23 tuition_fee  FROM program p JOIN university u WHERE p.columna_2 = u.columna_2 AND u.columna_2='" . $_GET['nombre'] .
"' AND p.columna_3 = u.columna_4 ";
$listPrograms = $connect->query($queryPrograms);
$selectFilters;
if( isset($_GET['selectFilter'])){
    $selectFilters = $_GET['selectFilter'];
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
</head>
<div class="row mb-md-4 text-center" style="margin-right: 0px;">
 	<div class="col-sm-6" style="margin: auto;">			
		<h1 class="font-weight-bold">
			<?php echo $university['columna_2'];?><small> /  <?php echo $university['columna_4']. ' / '.$university['columna_3']; ?>
			</small>
		</h1>
	</div>	
	<div class="col-sm-6" style="margin: auto;">		
		<img style="max-width: 40%;" src="<?=path_img_log_univ.$university['columna_34'];?>" class="img-fluid">
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
						<div class="col-xl-6 col-sm-6 col-12">
							<?php echo $university['columna_30'];?><br/><br/>
							<h3 class="font-weight-bold">Type of University: <small> <?php echo $university['columna_7'];?></small></h3>
                            <h3 class="font-weight-bold">Type of Programs: <small> <?php echo $university['columna_8'];?></small></h3>
                            <h3 class="font-weight-bold">Fundation Year: <small> <?php echo $university['columna_9'];?></small></h3>
                            <h3 class="font-weight-bold">Number of Students: <small> <?php echo $university['columna_14']!=null ? number_format($university['columna_14'],0): ''; ?></small></h3>
						</div>
						<div class="col-xl-6 col-sm-6 col-12 text-center"">
							<iframe width="560" height="315"
							src="<?php echo str_replace("watch?v=","embed/",$university['columna_33']);?>" frameborder="0"
							allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
							allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingTwo">
				<h5 class="mb-0">
					<button id="btn-collapseTwo" class="dropdown-toggle btnDown" data-toggle="collapse"
						data-target="#collapseTwo" aria-expanded="false"
						aria-controls="collapseTwo"><?=$PROGRAMS_LIST?></button>
				</h5>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
				data-parent="#accordion">
        				<div class="input-group md-form form-sm form-1 pl-0 input-group-search">
        						<div class="input-group-prepend">
                            <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-search text-white"
                                aria-hidden="true"></i></span>
                          </div>
                          <input class="form-control my-0 py-1" type="text" id="mySearchText" placeholder="Search" aria-label="Search">
                        </div>	
						<div class="table-responsive">
							 <table class="table table-striped table-bordered table-hover dataTable-programs">                                            
                                    <thead>
                                    <tr>
                                        <th><?=$_PROGRAMS?></th>
                                    </tr>
                                    </thead>
                                   <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($listPrograms)) {
                                        ?>
                                        <tr
            							class="user-list d-sm-flex">
            							<td scope="col" class="flex-sm-row card"><div class="col-md-2 col-sm-6 col-12 mb-2">
                                                            <img class="img-fluid rounded" src="<?=path_img_log_univ.$row['logo_universidad'];?>" alt="Up unpacked friendly">
                                                        </div>
            								<div class="description pl-sm-3">
            									<h3><?php echo $row['columna_2'].' / '.$row['columna_7']; ?></h3>
            									<h4><?php echo $row['columna_3'].', '.$row['columna_1']; ?></h4>
            									<p>
                                                                        <?php echo substr($row['columna_16'],0,200)."..."; ?>
                                                                    </p>
                                                <p>
                                                	Application Fee: <?php echo $row['app_fee']!=null ? '$ '.number_format($row['app_fee'],0).$USD: ''; ?><br>
                                                	Tuition Fee: <?php echo '$ '.number_format($row['tuition_fee'],0).' - $ '.number_format(( ($row['tuition_fee']*0.1)+$row['tuition_fee']).$USD,0); ?>
                                                </p>                    
            									<ul class="list-inline d-sm-flex flex-sm-row gx-btn-list">
            										<li><a href="<?=ptplg_url?>programs/programDetail.php?prog=<?php echo $row['columna_2'].'&university='. $university['columna_2']; ?>"
            											class="gx-btn gx-btn-light-green btnDetail"><?=$_BTN_DETAILS?></a></li>
            									</ul>
            								</div></td>
            						</tr>
                                    <?php } ?>	                                          
                                    </tbody>
                              </table>
						</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingThree">
				<h5 class="mb-0">
					<button class="dropdown-toggle btnDown" data-toggle="collapse"
						data-target="#collapseThree" aria-expanded="false" id="btn-collapseThree"						
						aria-controls="collapseThree"><?=$INFO_DESTINO?></button>
				</h5>
			</div>
			<div id="collapseThree" class="collapse"
				aria-labelledby="headingThree" data-parent="#accordion">
				<div class="card-body">
				</div>
				</div>
			</div>
		</div>
	</div>
<div class="btn-group dropleft no-border">
    <a href="<?php echo empty($selectFilters) ? '../explore-universities' : '../explore-universities/?selectFilter=On' ;?>"
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

<script type="text/javascript"
	src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript"
	src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=ptplg_url?>node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script
	src="<?=ptplg_url?>node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=ptplg_url?>js/custom/data-tables.js"></script>
<script>
var idClose;
var array;
var myWindow;
jQuery(function($){
$("button").click(function(event){
  var idElement = this.id;
  if(this.id !=null && this.id != 'btn-collapseOne'){
	  event.preventDefault();	
	  jQuery.ajax({url: "../validateSesionLogin.php", success: function(result){		  
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
$(document).ready(function () {
	jQuery(function($){
    	var table = $('.dataTable-programs').DataTable({
    		"searching": true,
    		"ordering": false,
    		"bLengthChange": false,
    		"bInfo": true,
    		"pageLength": 10
    	});  
        $('#mySearchText').on( 'change', function () {
        	table.search($('#mySearchText').val()).draw();
        } );
        $('#DataTables_Table_0_filter').hide();
	});
});
</script>