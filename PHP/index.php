<?php 
	require "header.php";
?>
<main>
	<div>
		<section>
			<?php if (isset($_SESSION['idUsuario'])) {
					echo "<p>Logueado</p>";
			 } 
			 else { 
			 		echo "<p>Desconectado</p>";	
			}?>
					
		</section>		
	</div>
</main>
<?php
	require "footer.php";
?>