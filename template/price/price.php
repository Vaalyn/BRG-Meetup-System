<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="background-pattern">
			<div class="container">

				<div class="row">
					<?php include_once(__DIR__ . '/../sidebar.php'); ?>

					<div class="col s12 l8 pull-l4">
						<div class="card color-3">
							<div class="card-content grey-text text-lighten-2">
								<h3 class="card-title center">Preis</h3>
								<div class="divider"></div>

								<div class="row">
									<div class="col s12">
										<p>
											<?php
												echo sprintf(
													'Die Teilnahme am BRG Meetup kostet %s€',
													$meetupCost
												);
											?>
										</p>

										<p>
											Im Preis inbegriffen sind:
										</p>

										<ul class="browser-default">
											<li>
												Übernachtung (2 Nächte) in Betten innerhalb der Location
											</li>

											<li>
												Verpflegung (Freitag, warmes Abendessen; Samstag, Frühstück und Grillen am Abend; Sonntag, Frühstück) Je nach Lage versuchen wir auch zwischen Mahlzeiten, also kleinere Snacks, bereitzustellen.
											</li>

											<li>
												Shuttle Service von und zum Bahnhof
											</li>

											<li>
												Teilnahme an allen von uns erstellten Aktivitäten innerhalb der Location
											</li>

											<li>
												Jede Menge Spass
											</li>
										</ul>
									</div>
								</div>

								<div class="row">
									<div class="col s12">
										<h5>Zahlungsmöglichkeiten</h5>

										<p>
											Die Bezahlung kann entweder per PayPal oder Banküberweisung erfolgen, nachfolgend findest du die Zahlungsinformationen.
										</p>

										<p>
											PayPal:<br />
											<?php echo htmlentities($payment['paypal']); ?>
										</p>

										<p>
											Banküberweisung<br />
											Empfänger: <?php echo htmlentities($payment['bankTransfer']['recipient']); ?><br />
											IBAN: <?php echo htmlentities($payment['bankTransfer']['iban']); ?><br />
											BIC: <?php echo htmlentities($payment['bankTransfer']['bic']); ?>
										</p>

										<p>
											Gib als Betreff bei der Überweisung folgendes ein damit wir die Bezahlung deiner Anmeldung zuordnen können:<br />
											<?php
												echo sprintf(
													'<b>Vorname Nachname | Username | BRG Meetup %s</b>',
													htmlentities($user->userInfo->first_name),
													htmlentities($user->userInfo->last_name),
													htmlentities($user->username),
													$meetupYear
												);
											?>
										</p>

										<p>
											Sollte es zu einer Stornierung kommen, so wird die Teilnahmegebühr, sofern bereits gezahlt, (abzgl. 0,10€ Überweisungsgebühr) zurückgebucht. Bei nicht erscheinen zum Meetup, kann keine Rückerstattung mehr erfolgen. Die Stornierung ist bis zwei Tage vor Meetupbeginn (29.08.) möglich. Danach ist eine Stornierung aus Organisatorischen Gründen nicht mehr möglich.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
