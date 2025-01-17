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

			<?php if ($user->booking->couple && $user->booking->couple_code !== '') : ?>
				<div class="row">
					<div class="col s12 m8 l6 offset-m2 offset-l3">
						<div class="card color-3">
							<div class="card-content grey-text text-lighten-2">
								<p class="center">
									Du hast ein Pärchenzimmer gebucht und kannst deinem Partner/in diesen Pärchencode schicken, damit diese/r sich für das gleiche Zimmer anmelden kann:
								</p>

								<p class="center green-text">
									<?php echo $user->booking->couple_code; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col s12 m6 l4">
					<div id="booking" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Zimmer</h3>
							<div class="divider"></div>

							<div class="row">
								<div class="col s12">
									<div class="overflow-side-scroll">
										<table class="striped">
											<tbody>
												<tr>
													<th>Name</th>
													<td><?php echo htmlentities($user->booking->room->name); ?></td>
												</tr>
												<tr>
													<th>Betten&nbsp;gesamt</th>
													<td><?php echo $user->booking->room->bed_count; ?></td>
												</tr>
												<tr>
													<th>Betten&nbsp;belegt</th>
													<td><?php echo $user->booking->room->bookings->count(); ?></td>
												</tr>
												<tr>
													<th>Gebucht</th>
													<td>
														<?php echo $user->booking->created_at->format('H:i:s'); ?><br/>
														<?php echo $user->booking->created_at->format('d.m.Y'); ?>
													</td>
												</tr>
												<tr>
													<th>Bezahlt</th>
													<td>
														<?php if ($user->booking->paid) : ?>
															<i class="material-icons green-text">check</i>
														<?php else : ?>
															<i class="material-icons red-text">clear</i>
														<?php endif; ?>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<?php if ($bookingIsActive && !$allRoomsFull && !$user->booking->confirmed) : ?>
								<div class="row">
									<div class="col s12 center">
										<a href="#booking-move-room-modal" class="btn waves-effect waves-light color-1 modal-trigger">Ändern
											<i class="material-icons right">edit</i>
										</a>
									</div>
								</div>
							<?php else : ?>
								<div class="row">
									<div class="col s12 center">
										<p>
											Du möchtest dein Zimmer noch ändern oder deine Buchung stornieren?
										</p>
										<p>
											<a href="https://www.bronyradiogermany.com/kontakt/" class="waves-effect waves-teal btn-flat" target="_blank">Kontaktiere uns</a>
										</p>
									</div>
								</div>
							<?php endif; ?>

							<?php if ($bookingIsActive) : ?>
								<div class="row">
									<div class="col s12 center">
										<a href="#cancel-booking-modal" class="btn waves-effect waves-light color-1 modal-trigger">Stornieren
											<i class="material-icons">remove_circle_outline</i>
										</a>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<div id="booking" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Zahlungs<wbr/>informationen</h3>
							<div class="divider"></div>

							<div class="row">
								<div class="col s12">
									<div class="overflow-side-scroll">
										<table class="striped">
											<tbody>
												<tr>
													<th>Bank<wbr/>überweisung</th>
													<td><?php echo htmlentities($payment['bankTransfer']['recipient']); ?></td>
												</tr>

												<tr>
													<th>IBAN</th>
													<td><?php echo htmlentities($payment['bankTransfer']['iban']); ?></td>
												</tr>

												<tr>
													<th>BIC</th>
													<td><?php echo htmlentities($payment['bankTransfer']['bic']); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col s12">
									<p class="center">Teilnahmegebühr</p>
									<p class="center"><?php echo $user->booking->room->price; ?>&nbsp;€</p>

									<p>
										Gib als Betreff bei der Überweisung folgendes ein damit wir die Bezahlung deiner Anmeldung zuordnen können:
									</p>
									<?php
										echo sprintf(
											'<b>%s %s, %s, BRG Meetup %s</b>',
											htmlentities($user->userInfo->first_name),
											htmlentities($user->userInfo->last_name),
											htmlentities($user->username),
											date('Y', strtotime($meetupDate))
										);
									?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col s12 m6 l8">
					<div id="booking" class="card color-3">
						<div id="booking-information" class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Buchungs<wbr/>informationen</h3>
							<div class="divider"></div>

							<div class="row hide">
								<div class="col s12 input-field">
									<?php if ($bookingIsActive) : ?>
										<textarea id="allergies" class="materialize-textarea"><?php
											echo htmlentities($user->booking->bookingInfo->allergies);
										?></textarea>
									<?php else : ?>
										<textarea id="allergies" class="materialize-textarea" readonly><?php
											echo htmlentities($user->booking->bookingInfo->allergies);
										?></textarea>
									<?php endif; ?>
									<label for="allergies">Allergien</label>
								</div>
							</div>

							<div class="row">
								<div class="col s12 input-field">
									<?php if ($bookingIsActive) : ?>
										<textarea id="stuff" class="materialize-textarea" placeholder="Hast du Allergien?&#10;Bringst du was mit?&#10;Besondere Wünsche?"><?php
											echo htmlentities($user->booking->bookingInfo->stuff);
										?></textarea>
									<?php else : ?>
										<textarea id="stuff" class="materialize-textarea" placeholder="Hast du Allergien?&#10;Bringst du was mit?&#10;Besondere Wünsche?" readonly><?php
											echo htmlentities($user->booking->bookingInfo->stuff);
										?></textarea>
									<?php endif; ?>
									<label for="stuff">Möchtest du uns noch was mitteilen?</label>
								</div>
							</div>

							<div class="row hide">
								<div class="col s12 input-field">
									<?php if ($bookingIsActive) : ?>
										<textarea id="wishes" class="materialize-textarea" placeholder="Hast du besondere Wünsche, welche die Verpflegung oder Aktivitäten betrifft, trage diese bitte hier ein. Wir werden dann sehen ob sich diese umsetzen lassen."><?php
											echo htmlentities($user->booking->bookingInfo->wishes);
										?></textarea>
									<?php else : ?>
										<textarea id="wishes" class="materialize-textarea" placeholder="Hast du besondere Wünsche, welche die Verpflegung oder Aktivitäten betrifft, trage diese bitte hier ein. Wir werden dann sehen ob sich diese umsetzen lassen." readonly><?php
											echo htmlentities($user->booking->bookingInfo->wishes);
										?></textarea>
									<?php endif; ?>
									<label for="wishes">Wünsche</label>
								</div>
							</div>

							<?php if ($availableNightHikePlaces > 0 || $user->booking->bookingInfo->night_hike) : ?>
								<div class="row">
									<div class="col s12 center">
										<?php if ($user->booking->bookingInfo->night_hike) : ?>
											<input name="night_hike" id="night-hike" class="filled-in" type="checkbox" checked/>
										<?php else : ?>
											<input name="night_hike" id="night-hike" class="filled-in" type="checkbox" />
										<?php endif; ?>
										<label for="night-hike">Möchtest du an der Nachtwanderung teilnehmen?</label>
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

							<?php if ($bookingIsActive) : ?>
								<div class="row">
									<div class="col s12 center">
										<button class="btn waves-effect waves-light color-1 update-booking-information">Speichern
											<i class="material-icons right">save</i>
										</button>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="booking-move-room-modal" class="modal modal-fixed-footer color-3">
			<div class="modal-content white-text">
				<div class="row">
					<div class="col s12">
						<h5 class="center" data-default="Zimmer ändern">Zimmer ändern</h5>
						<div class="divider"></div>
					</div>
				</div>

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
			</div>
			<div class="modal-footer color-1">
				<button class="modal-action modal-save waves-effect waves-green btn-flat white-text">Speichern</button>
				<button class="modal-action modal-close waves-effect waves-red btn-flat white-text">Abbrechen</button>
			</div>
		</div>

		<div id="cancel-booking-modal" class="modal modal-fixed-footer color-3">
			<div class="modal-content white-text">
				<div class="row">
					<div class="col s12">
						<h5 class="center" data-default="Möchtest du deine Buchung wirklich stornieren?">Möchtest du deine Buchung wirklich stornieren?</h5>
						<div class="divider"></div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 center">
						<p>
							Wenn du deine Buchung stornierst, wird der Platz in dem Zimmer, das du gebucht hast, wieder freigegeben.
						</p>

						<p>
							Gibt es etwas bei dem wir dir helfen können, damit du doch zum Meetup kommen kannst?
						</p>

						<p>
							<a href="https://www.bronyradiogermany.com/kontakt/" class="waves-effect waves-teal btn-flat" target="_blank">Kontaktiere uns</a>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer color-1">
				<button class="modal-action modal-save waves-effect waves-green btn-flat white-text">Stornieren</button>
				<button class="modal-action modal-close waves-effect waves-red btn-flat white-text">Abbrechen</button>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
