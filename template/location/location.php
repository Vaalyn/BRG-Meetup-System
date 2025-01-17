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
											Die Veranstaltung findet in Niedersachsen, in der Gemeinde Sibbesse bei Hildesheim statt.
										</p>

										<p>
											Selbstbeschreibung des Besitzers der Räumlichkeiten:
										</p>

										<blockquote>
											Verein zur Förderung von Kunst und Kultur und Gäste-/Seminarhaus inmitten eines malerischen Naturschutzgebietes.
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
											Kulturherberge e.V. <br />
											Wernershöhe 2<br />
											31079 Sibbesse<br />
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
											Der nächste Bahnhof ist in Alfeld (Leine).
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col s12">
										<iframe class="google-maps" src="https://www.google.com/maps/embed/v1/place?q=Wernershöhe%202%2031079%20Sibbesse&key=<?php echo $googleMapsApiKey; ?>" allowfullscreen></iframe>
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
