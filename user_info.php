<?php
require_once ("models/config.php");

require_once ("models/header.php");
$tratanteId = $_GET ['id'];
$infoTratante = fetchUserDetails ( NULL, NULL, $tratanteId );
$userUbicacion = fetchAllTratanteUbicacion($tratanteId);

?>


<body>
	<div class='container' id='wrapper'>
<?php
require_once ("navigation.php");
?>
<div id='top'>
<?php
echo resultBlock ( $errors, $successes );
?>
<body>
				<div class='container' id='wrapper'>
<?php
require_once ("navigation.php");
?>
<div id='top'></div>
					<div id='content'>
						<h1><?php echo $websiteName; ?></h1>
						<h2>Ficha de <?php echo $infoTratante['user_name']." ".$infoTratante['lastname']?></h2>
						<div id='main'></div>
						<div class="row">
							<div class="col-md-2">Fecha de registro:</div>
							<div class="col-md-4">
								<?php setlocale(LC_TIME,"es_CL.UTF8", "es_ES.UTF8","spanish"); echo strftime ("%e-%b-%Y", $infoTratante['sign_up_stamp'])?>
							</div>
						
						
						
						</div>
						<div class='row'>
							<h3>Áreas de Trabajo</h3>
						</div>
						<div class='row'>
							<h3>Especialidades</h3>
						</div>
					<?php
						// Links for logged in user
						if (isUserLoggedIn ()) {
					?>
						<div class='row'>
							<h3>Ubicación de consultas</h3>
							<table class="table table-striped table-hover">
							<tr>
						<th>Nombre Ubicacion</th>
						<th>Dirección</th>
						<th>Oficina</th>
						<th>Telefono</th>
						<th>Comuna</th>
						<th>Ciudad</th>

					</tr>
					<?php					
					foreach ( $userUbicacion as $ubicacion ) {
						?>
						<tr>
							<td>
								<?php echo $ubicacion['nombre']?>
							</td>
							<td>
								<?php echo $ubicacion['direccion']?>
							</td>
							<td>
								<?php echo $ubicacion['oficina']?>
							</td>
							<td>
								<?php echo $ubicacion['telefono']?>
							</td>
							<td>
								<?php echo $ubicacion['comuna']?>
							</td>
							<td>
								<?php echo $ubicacion['ciudad']?>
							</td>
						</tr>
					<?php 
					}
					?>
							</table>
						</div>
					<?php 
						}
					?>
					</div>
				</div>
		
		</div>
		<div id='bottom'></div>

</body>
</html>