<?php include_once(__DIR__ . '/../../header.php'); ?>
	<p>
		Deine Anmeldung für das BRG Meetup wurde storniert.
	</p>

	<?php if ($reason !== null) : ?>
		<p>
			<b>Grund der Stornierung:</b><br />
			<?php echo htmlentities($reason); ?>
		</p>
	<?php endif; ?>
<?php include_once(__DIR__ . '/../../footer.php'); ?>
