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
											Die Veranstaltung findet in Thüringen, im kleinen Örtchen "Hohenstein" im Ortsteil "Schiedungen" statt.
										</p>

										<p>
											Selbstbeschreibung des Besitzers der Räumlichkeiten:
										</p>

										<blockquote>
											Auf unserem liebevoll renovierten und individuell eingerichteten Vierseitenhof im Südharz haben Sie die Möglichkeit ein Familienfest, ein Geburtstag oder eine Gruppenfahrt mit bis zu 30 Personen zu veranstalten. Der restaurierte und umgebaute Pferdestall mit Heizung, Geschirr und Buffetablage liefert das passende Ambiente für diese Art von Festlichkeiten.
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
											Ferienhof Baumann<br />
											Platz 8<br />
											99755 Hohenstein<br />
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
											??? Parkplätze ???
										</p>
									</div>

									<div class="col s12 m6">
										<h5>
											Anreise mit der Bahn
										</h5>
										<div class="divider"></div>

										<p>
											Der nächste Bahnhof heißt ???.
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col s12">
										<iframe class="google-maps" src="https://www.google.com/maps/embed/v1/place?q=Platz%208%2099755%20Hohenstein&key=<?php echo $googleMapsApiKey; ?>" allowfullscreen></iframe>
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
