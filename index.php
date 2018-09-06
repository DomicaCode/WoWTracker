<?php 
	include_once 'header.php';
 ?>

<section class="main-container">
	<div class="main-wrapper">
		<?php
			if (isset($_SESSION['u_id'])) {
				echo '<section class="main-container">
						<div class="main-wrapper">
							<h2>Character Info</h2>
							<form class="submitchar-form" action="includes/charinfo.inc.php" method="POST">
								<input type="text" name="charname" placeholder="Character name">
								<input type="text" name="realmname" placeholder="Realm name">
								<small id="emailHelp" class="form-text text-muted">Realm ime kucaj sa - instead of space Ex. Domica & The-Maelstrom</small>
								<button type="submit" name="submit">Submit</button>
							</form>
						</div>
					</section>';
			}
			else
			{
				echo '<h2>Home</h2>';
			}
		?>
	</div>
</section>

<?php 
	include_once 'footer.php';
 ?>