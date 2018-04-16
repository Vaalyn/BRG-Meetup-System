<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="background-pattern">
			<div class="container">

				<div class="row">
					<?php include_once(__DIR__ . '/../sidebar.php'); ?>

					<div class="col s12 l8 pull-l4">
						<div class="card color-3">
							<div class="card-content grey-text text-lighten-2">
								<h3 class="card-title center">Veranstaltungsort</h3>
								<div class="divider"></div>

								<div class="row">
									<div class="col s12 textblock">
										<p>
											Die Veranstaltung findet in Thüringen, im kleinen Örtchen "Seitenroda" statt.
										</p>

										<p>
											Selbstbeschreibung des Besitzers der Räumlichkeiten:
										</p>

										<blockquote>
											In alten Mauern aus Stein, Holz und Lehm - unter uralten Bäumen Übernachten und Träumen - in Zimmern, Kammern und Betten, so, wie's die Gäste gern hätten - oder im Heu, für die, ohne Scheu. Es gäbe noch manches mehr zu sagen von Seminaren, Freizeiten und Räumen zum Tagen
										</blockquote>
									</div>
								</div>

								<div class="row">
									<div class="col s12 textblock">
										<h5>
											Adresse des Veranstaltungsorts
										</h5>
										<div class="divider"></div>

										<p>
											Haus Bethlehem<br />
											Dorfstraße 41<br />
											07768 Seitenroda<br />
										</p>
									</div>
								</div>

								<div class="row textblock">
									<div class="col s12 m6">
										<h5>
											Anreise mit dem PKW
										</h5>
										<div class="divider"></div>

										<p>
											Wer mit dem PKW anreist, hat ausreichend kostenlose Parkplätze zur Verfügung. Diese Parkplätze befinden sich circa 300m vom Veranstaltungsort entfernt.
										</p>
									</div>

									<div class="col s12 m6">
										<h5>
											Anreise mit der Bahn
										</h5>
										<div class="divider"></div>

										<p>
											Der nächste Bahnhof heißt Kahla (Thür).
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col s12">
										<iframe class="google-maps" src="https://www.google.com/maps/embed/v1/place?q=Haus%20Bethlehem%20Dorfstra%C3%9Fe%2041%2007768%20Seitenroda&key=<?php echo $googleMapsApiKey; ?>" allowfullscreen></iframe>
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
