<?php
/*
 * UserCake Version: 2.0.2 http://usercake.com
 */
require_once ("models/config.php");
if (! securePage ( $_SERVER ['PHP_SELF'] )) {
	die ();
}

$userCitas = fetchAllUserCitas ( $loggedInUser->user_id );

require_once ("models/header.php");

?>
<body>
	<div class='container' id='wrapper'>
<?php
require_once ("navigation.php");
?>
<div id='top'></div>
		<div id='content'>
			<h1><?php echo $websiteName; ?></h1>
			<h2>Información de <?php echo $loggedInUser->username ." ".$loggedInUser->lastname?></h2>
			<div id='main'>
			<div class="row">
			<div class="col-md-2">Ultimo ingreso: </div>
			<div class="col-md-4"><?php setlocale(LC_TIME,"es_CL.UTF8", "es_ES.UTF8","spanish"); echo strftime ("%e-%b-%Y", $loggedInUser->lastLoginTimeStamp()) ?>
			</div>
			</div>
			<div class="row">
			<div class="col-md-2">Fecha de registro: </div>
			<div class="col-md-4"><?php setlocale(LC_TIME,"es_CL.UTF8", "es_ES.UTF8","spanish"); echo strftime ("%e-%b-%Y", $loggedInUser->signupTimeStamp()) ?>
			</div>
			</div>

</div>
			<div id="citas">
			<h3>Citas reservadas</h3>
			<?php 
			if(count($userCitas)>0){

			?>
				<table class='admin table table-hover '>
					<tr>
						<th>Nombre tratante</th>
						<th>Dia cita</th>
						<th>Hora cita</th>

					</tr>
					<?php
					
					
					foreach ( $userCitas as $cita ) {
						?>
						<tr>
						<td>
						<a href ='user_info.php?id=<?php echo $cita['idTratante'] ?>'><?php echo $cita ['user_name'] . " " . $cita ['lastname'] ?></a>
						</td>
						<td>
						<?php setlocale(LC_TIME,"es_CL.UTF8", "es_ES.UTF8","spanish"); echo strftime ("%e-%b-%Y", strtotime($cita ['dia_cita'])) ?>
						</td>
						<td>
						<?php setlocale(LC_TIME,"es_CL.UTF8", "es_ES.UTF8","spanish"); echo strftime ("%H:%M", strtotime($cita ['horario_cita'])) ?>
						</td>
						</tr>
					<?php 
					}
					?>
					</table>
					<?php 
					}
					else{
						echo "Sin citas reservadas";
						}
					?>
			</div>

		</div>

	</div>
	<div id='bottom'></div>
</body>
</html>