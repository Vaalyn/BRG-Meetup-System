<?php include_once(__DIR__ . '/../../header.php'); ?>
	<p>Vielen Dank für deine Anmeldung zum Brony Radio Germany Meetup.</p>

	<?php if ($isCoupleBooking) : ?>
		<p>
			<?php
				echo sprintf(
					'%s: <b>%s</b>',
					'Du hast ein Pärchenzimmer gebucht und kannst deinem Partner/in diesen Pärchencode schicken, damit diese/r sich für das gleiche Zimmer anmelden kann',
					$coupleCode
				);
			?>
		</p>
	<?php endif; ?>

	<p>
		<?php
			echo sprintf(
				'%s: <a href="%s">Buchungsdetails</a>',
				'Details zu deiner Anmeldung kannst du auf folgender Seite einsehen',
				$bookingDetailsUrl
			);
		?>
	</p>

	<p>
		<?php
			echo sprintf(
				'%s: <b>%s €</b>',
				'Die Teilnahmegebühr beträgt',
				$meetupCost
			);
		?>
	</p>

	<p>
		Die Zahlung der Teilnahmegebühr ist innerhalb von <b>14 Tagen</b> nach der Anmeldung zu erfolgen, sollte dies nicht geschehen werden wir die Anmeldung stornieren und den gebuchten Platz wieder freigeben.<br />
		Es ist möglich die Teilnahmegebühr in Raten zu bezahlen. Wenn du diese Möglichkeit nutzen möchtest, melde dich bitte über das Kontaktformular auf der <a href="https://www.bronyradiogermany.com/kontakt">BRG Website</a> bei uns, damit wir das mit dir abklären können.
	</p>

	<p>
		Die Bezahlung kann entweder per PayPal oder Banküberweisung erfolgen, nachfolgend findest du die Zahlungsinformationen.
	</p>

	<p>
		<b>PayPal:</b><br />
		<?php echo htmlentities($payment['paypal']); ?>
	</p>

	<p>
		<b>Banküberweisung:</b><br />
		Empfänger: <?php echo htmlentities($payment['bankTransfer']['recipient']); ?><br />
		IBAN: <?php echo htmlentities($payment['bankTransfer']['iban']); ?><br />
		BIC: <?php echo htmlentities($payment['bankTransfer']['bic']); ?>
	</p>

	<p>
		Gib als Betreff bei der Überweisung folgendes ein damit wir die Bezahlung deiner Anmeldung zuordnen können:<br />
		<?php
			echo sprintf(
				'<b>%s %s, %s, BRG Meetup %s</b>',
				htmlentities($user->userInfo->first_name),
				htmlentities($user->userInfo->last_name),
				htmlentities($user->username),
				$meetupYear
			);
		?>
	</p>

	<p>
		Sollte es zu einer Stornierung kommen, so wird die Teilnahmegebühr, sofern bereits gezahlt, (abzgl. 0,10€ Überweisungsgebühr) zurückgebucht. Bei nicht erscheinen zum Meetup, kann keine Rückerstattung mehr erfolgen. Die Stornierung ist bis zwei Tage vor Meetupbeginn (06.05.) möglich. Danach ist eine Stornierung aus Organisatorischen Gründen nicht mehr möglich.
	</p>
<?php include_once(__DIR__ . '/../../footer.php'); ?>
