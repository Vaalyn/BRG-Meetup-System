<?php include_once(__DIR__ . '/../header.php'); ?>
	<main class="background-pattern">
		<div class="container">
			<?php if ($isUserUnderage) : ?>
				<div class="row">
					<div class="col s12 m8 l6 offset-m2 offset-l3">
						<div class="card color-3">
							<div class="card-content grey-text text-lighten-2">
								<div class="row">
									<div class="col s12 center">
										Minderjährige Teilnehmer müssen einen Muttizettel von einem Erziehungsberechtigten ausfüllen lassen und unterschrieben zum Meetup mitbringen.
									</div>
								</div>

								<div class="row">
									<div class="col s12 center">
										<a href="files/Muttizettel.pdf" class="btn color-1" target="_blank">Muttizettel<i class="material-icons right">file_download</i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col s12 m8 offset-m2">
					<div id="booking" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Zimmer buchen</h3>
							<div class="divider"></div>

							<form>
								<div class="row">
									<div class="col s12 center">
										<input name="couple" id="couple" class="filled-in" type="checkbox" />
										<label for="couple">Doppelzimmer für dich und deinen Partner/Partnerin buchen?</label>
									</div>
								</div>

								<div id="is-couple" class="hide">
									<div class="row">
										<div class="col s12">
											Sollte dein Partner sich bereits angemeldet haben, gib einfach den Pärchencode, den er oder sie mit der Anmeldung für ein Doppelzimmer erhalten hat, ein und deine Anmeldung wird auf das selbe Doppelzimmer gebucht.
										</div>
									</div>

									<div class="row">
										<div class="col s12 l6 offset-l3 input-field">
											<input name="couple_code" id="couple-code" type="text" value="" />
											<label for="couple-code">Pärchencode</label>
										</div>
									</div>

									<div class="row">
										<div id="room-id-couple-wrapper" class="col s12 l6 offset-l3 input-field">
											<select name="room_id_couple" id="room-id-couple">
												<?php foreach ($roomsCouple as $room) : ?>
													<?php if ($room->bookings->count() < $room->bed_count) : ?>
														<option value="<?php echo $room->room_id; ?>"><?php
															echo htmlentities(sprintf(
																'%s (%s / %s belegt)',
																$room->name,
																$room->bookings->count(),
																$room->bed_count
															));
														?></option>
													<?php else : ?>
														<option value="<?php echo $room->room_id; ?>" disabled><?php
															echo htmlentities(sprintf(
																'%s (%s / %s belegt)',
																$room->name,
																$room->bookings->count(),
																$room->bed_count
															));
														?></option>
													<?php endif; ?>
												<?php endforeach; ?>
											</select>
											<label for="room-id-couple">Zimmer</label>
										</div>
									</div>
								</div>

								<div id="is-single" class="row">
									<div class="col s12 l6 offset-l3 input-field">
										<select name="room_id_single" id="room-id-single">
											<?php foreach ($roomsSingle as $room) : ?>
												<?php if ($room->bookings->count() < $room->bed_count) : ?>
													<option value="<?php echo $room->room_id; ?>"><?php
														echo htmlentities(sprintf(
															'%s (%s / %s belegt)',
															$room->name,
															$room->bookings->count(),
															$room->bed_count
														));
													?></option>
												<?php else : ?>
													<option value="<?php echo $room->room_id; ?>" disabled><?php
														echo htmlentities(sprintf(
															'%s (%s / %s belegt)',
															$room->name,
															$room->bookings->count(),
															$room->bed_count
														));
													?></option>
												<?php endif; ?>
											<?php endforeach; ?>
										</select>
										<label for="room-id-single">Zimmer</label>
									</div>
								</div>

								<div class="row">
									<div class="col s12 input-field">
										<textarea name="stuff" id="stuff" class="materialize-textarea" placeholder="Hast du Allergien?&#10;Bringst du was mit?&#10;Besondere Wünsche?"></textarea>
										<label for="stuff">Möchtest du uns noch was mitteilen?</label>
									</div>
								</div>

								<div class="row hide">
									<div class="col s12 input-field">
										<textarea name="allergies" id="allergies" class="materialize-textarea"></textarea>
										<label for="allergies">Auf welche Allergien/Unverträglichkeiten müssen wir für dich achten?</label>
									</div>
								</div>

								<div class="row hide">
									<div class="col s12 input-field">
										<textarea name="wishes" id="wishes" class="materialize-textarea" placeholder="Hast du besondere Wünsche, welche die Verpflegung oder Aktivitäten betrifft, trage diese bitte hier ein. Wir werden dann sehen ob sich diese umsetzen lassen."></textarea>
										<label for="wishes">Welche Wünsche hast du an das Meetup?</label>
									</div>
								</div>

								<div class="row">
									<div class="col s12 center">
										<input name="bedding" id="bedding" class="filled-in" type="checkbox" />
										<label for="bedding">Mir ist bewusst, dass ich Bettwäsche und Bettlaken (oder Schlafsack und Bettlaken) selbst mit zu bringen habe. Wenn ich diese nicht selbst mitbringe sind von mir 7 Euro Leihgebühren für Leibettwäsche zu entrichten.</label>
									</div>
								</div>

								<?php if ($availableNightHikePlaces > 0) : ?>
									<div class="row">
										<div class="col s12 center">
											<input name="night_hike" id="night-hike" class="filled-in" type="checkbox" />
											<label for="night-hike">Ich möchte an der Nachtwanderung teilnehmen.</label>
										</div>
									</div>

									<div class="row">
										<div class="col s12 center">
											<p class="center">
												<a href="nachtwanderung" class="waves-effect waves-teal btn-flat" target="_blank">Informationen zur Nachtwanderung</a>
											</p>
										</div>
									</div>
								<?php endif; ?>

								<div class="row">
									<div class="col s12 center">
										<div class="divider"></div>
										<p>
											Mit deiner Anmeldung zum Meetup bestätigst du die <a href="haftungsausschluss" target="_blank">Einverständnis- und Verzichtserklärung, Veranstaltungsregeln sowie Haftungsfreistellung</a> gelesen zu haben und akzeptierst diese.
										</p>
										<div class="divider"></div>
									</div>
								</div>

								<div class="row center">
									<div class="col s12">
										<a id="book-room" class="btn waves-effect waves-light color-1 submit">Buchen
											<i class="material-icons right">assignment_turned_in</i>
										</a>

										<div class="preloader-wrapper big active hide">
											<div class="spinner-layer spinner-blue-only">
												<div class="circle-clipper left">
													<div class="circle"></div>
												</div>
												<div class="gap-patch">
													<div class="circle"></div>
												</div>
												<div class="circle-clipper right">
													<div class="circle"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
