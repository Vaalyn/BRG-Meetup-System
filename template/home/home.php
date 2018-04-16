<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="row">
			<div class="col s12 center">
				<script>
					let countdownClockDate = '<?php echo htmlentities($countdownClockDate); ?>';
				</script>
				<div id="countdown-clock">
					<div class="color-1">
						<span class="days color-2"></span>
						<div class="smalltext">Tage</div>
					</div>

					<div class="color-1">
						<span class="hours color-2"></span>
						<div class="smalltext">Stunden</div>
					</div>

					<div class="color-1">
						<span class="minutes color-2"></span>
						<div class="smalltext">Minuten</div>
					</div>

					<div class="color-1">
						<span class="seconds color-2"></span>
						<div class="smalltext">Sekunden</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col s12 m8 offset-m2 grey-text text-lighten-2">
				<h4 class="center">Herzlich willkommen!</h4>
				<div class="divider"></div>

				<div class="textblock">
					<div class="row">
						<div class="col s12">
							<p>
								Auf dieser Website findest du Informationen rund um das Brony Radio Germany Meetup und kannst dich dafür anmelden.
							</p>
							<p>
								Das Brony Radio Germany Meetup ist ein alljährliches Treffen, organisiert vom Team des BRG, auf dem sich Bronies von nah und fern treffen und kennenlernen oder wiedersehen.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="background-pattern">
			<div class="container">

				<div class="row">
					<?php include_once(__DIR__ . '/../sidebar.php'); ?>

					<div class="col s12 l8 pull-l4">
						<div class="card color-3">
							<div class="card-content grey-text text-lighten-2">
								<h3 class="card-title center">Warum ein Meetup von einem Radio?</h3>
								<div class="divider"></div>

								<div class="row">
									<div class="col s12 textblock">
										<p>
											Das Brony Radio Germany entstand Ende 2014 und ging im Januar 2015 erstmals auf Sendung.
										</p>
										<p>
											Schnell bildete sich aus dem lose organisieren Chat in dem die Hörer saßen eine kleine und dann stetig wachsende Community, die auf engem Kontakt zwischen Radio und Hörern gründete. Jeder war irgendwie ein Teil des Radios und auch das Radio Team bildete sich nach und nach aus der Community heraus.
										</p>
										<p>
											Weil aber diese Community über ganz Deutschland verstreut war und man sich selten und nur zum Teil treffen konnte, kamen wir auf die Idee ein Brony Meetup zu organisieren, so dass einmal im Jahr das Team und die Community zusammenkommen konnten.
										</p>
										<p>
											Erstmals fand das BRG Meetup 2016 statt und war ein voller Erfolg. Natürlich ist jeder auf dem Meetup willkommen, ob er nun zur BRG Community gehört oder nicht. Denn das Meetup steht natürlich ganz unter dem Motto des Brony Radio Germany:
										</p>
										<h3 class="stroked-text color-text-5 center">Where Bronies Come Together!</h3>
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
