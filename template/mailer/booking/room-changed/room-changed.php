<?php include_once(__DIR__ . '/../../header.php'); ?>
	<p>
		Das Zimmer für deine Anmeldung zum BRG Meetup wurde geändert.
	</p>

	<p>
		<b>Neues Zimmer:</b><br />
		Name: <?php echo htmlentities($booking->room->name); ?><br />
		Bettenanzahl: <?php echo $booking->room->bed_count; ?><br />
		Zimmerart: <?php echo htmlentities($booking->room->roomType->name); ?><br />
		Preis: <?php echo htmlentities($booking->room->price); ?>&nbsp;€<br />
	</p>

	<?php if ($booking->couple_code !== '') : ?>
		<p>
			<?php
				echo sprintf(
					'%s: <b>%s</b>',
					'Du hast jetzt ein Pärchenzimmer gebucht und kannst deinem Partner/in diesen Pärchencode schicken, damit diese/r sich für das gleiche Zimmer anmelden kann',
					$booking->couple_code
				);
			?>
		</p>
	<?php endif; ?>

	<p>
		<b>Grund der Änderung:</b><br />
		<?php echo htmlentities($reason); ?>
	</p>
<?php include_once(__DIR__ . '/../../footer.php'); ?>
