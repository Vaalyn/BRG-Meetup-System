<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12 l6 offset-l3">
					<div id="room-details" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Zimmerdetails</h3>
							<div class="divider"></div>

							<div class="overflow-side-scroll">
								<table class="striped">
									<tbody>
										<tr>
											<th>Name</th>
											<td><?php echo htmlentities($room->name); ?></td>
										</tr>
										<tr>
											<th>Betten</th>
											<td><?php echo $room->bed_count; ?></td>
										</tr>
										<tr>
											<th>Preis</th>
											<td><?php echo $room->price; ?>&nbsp;€</td>
										</tr>
										<tr>
											<th>Buchungen</th>
											<td><?php echo $room->bookings->count(); ?></td>
										</tr>
										<tr>
											<th>Erstellt</th>
											<td>
												<?php echo $room->created_at->format('H:i:s'); ?><br/>
												<?php echo $room->created_at->format('d.m.Y'); ?>
											</td>
										</tr>
										<tr>
											<th>Aktualisiert</th>
											<td>
												<?php echo $room->updated_at->format('H:i:s'); ?><br/>
												<?php echo $room->updated_at->format('d.m.Y'); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div id="booking-list" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Buchungen</h3>
							<div class="divider"></div>

							<div class="overflow-side-scroll">
								<table class="striped">
									<thead>
										<tr>
											<th>Username</th>
											<th>Vorname</th>
											<th>Nachname</th>
											<th>Bezahlt</th>
											<th>Erstellt</th>
											<th>Aktualisiert</th>
											<th>Aktion</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($room->bookings as $booking) : ?>
											<tr>
												<td><?php echo htmlentities($booking->user->username); ?></td>
												<td><?php echo htmlentities($booking->user->userInfo->first_name); ?></td>
												<td><?php echo htmlentities($booking->user->userInfo->last_name); ?></td>
												<td>
													<?php if ($booking->paid) : ?>
														<i class="material-icons green-text text-darken-2">check_circle</i>
													<?php else : ?>
														<i class="material-icons red-text text-darken-2">remove_circle</i>
													<?php endif; ?>
												</td>
												<td>
													<?php echo $booking->created_at->format('H:i:s'); ?>
													<br />
													<?php echo $booking->created_at->format('d.m.Y'); ?>
												</td>
												<td>
													<?php echo $booking->updated_at->format('H:i:s'); ?>
													<br />
													<?php echo $booking->updated_at->format('d.m.Y'); ?>
												</td>
												<td>
													<?php if ($booking->confirmed) : ?>
														<button class="btn-floating waves-effect waves-light color-1 tooltipped remove-room-confirmation" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Zimmer bestätigung aufheben">
															<i class="material-icons">lock_open</i>
														</button>
													<?php else : ?>
														<button class="btn-floating waves-effect waves-light color-1 tooltipped confirm-room" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Zimmer bestätigen">
															<i class="material-icons">lock</i>
														</button>
													<?php endif; ?>

													<?php if ($booking->paid) : ?>
														<button class="btn-floating waves-effect waves-light color-1 tooltipped set-booking-unpaid" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Ist nicht bezahlt">
															<i class="material-icons">remove</i>
														</button>
													<?php else : ?>
														<button class="btn-floating waves-effect waves-light color-1 tooltipped set-booking-paid" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Ist bezahlt">
															<i class="material-icons">check</i>
														</button>
													<?php endif; ?>

													<button class="btn-floating waves-effect waves-light color-1 tooltipped show-booking-details" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Details">
														<i class="material-icons">assignment</i>
													</button>

													<a href="mailto:<?php echo htmlentities($booking->user->email); ?>" class="btn-floating waves-effect waves-light color-1 tooltipped" data-delay="200" data-position="top" data-tooltip="E-Mail schreiben">
														<i class="material-icons">mail_outline</i>
													</a>

													<button class="btn-floating waves-effect waves-light color-1 tooltipped move-to-room" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Zimmer ändern">
														<i class="material-icons">swap_calls</i>
													</button>

													<button class="btn-floating waves-effect waves-light color-1 tooltipped cancel-booking" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Stornieren">
														<i class="material-icons">delete</i>
													</button>
												</td>
											</tr>
										<?php endforeach; ?>

										<?php if (!count($room->bookings)) : ?>
											<tr>
												<td class="center" colspan="7">
													Keine Buchungen gefunden
												</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="booking-details-modal" class="modal modal-fixed-footer color-3">
			<div class="modal-content white-text">
				<div class="row">
					<div class="col s12">
						<h5 class="center" data-default="Zimmer hinzufügen">Buchungsinformationen</h5>
						<div class="divider"></div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4 input-field">
						<input id="username" type="text" value="" readonly />
						<label for="username">Username</label>
					</div>

					<div class="col s12 m6 l4 input-field">
						<input id="birthday" type="text" value="" readonly />
						<label for="birthday">Geburtstag</label>
					</div>

					<div class="col s12 m6 l4 input-field">
						<input id="gender" type="text" value="" readonly />
						<label for="gender">Geschlecht</label>
					</div>
				</div>

				<div class="row">
					<div class="col s12 m6 l4 input-field">
						<input id="first-name" type="text" value="" readonly />
						<label for="first-name">Vorname</label>
					</div>

					<div class="col s12 m6 l4 input-field">
						<input id="last-name" type="text" value="" readonly />
						<label for="last-name">Nachname</label>
					</div>

					<div class="col s12 l4 input-field">
						<input id="email" type="text" value="" readonly />
						<label for="email">E-Mail</label>
					</div>
				</div>

				<div class="row hide">
					<div class="col s12 input-field">
						<textarea id="allergies" class="materialize-textarea" readonly></textarea>
						<label for="allergies">Allergien</label>
					</div>
				</div>

				<div class="row">
					<div class="col s12 input-field">
						<textarea id="stuff" class="materialize-textarea" readonly></textarea>
						<label for="stuff">Möchtest du uns noch was mitteilen?</label>
					</div>
				</div>

				<div class="row hide">
					<div class="col s12 input-field">
						<textarea id="wishes" class="materialize-textarea" readonly></textarea>
						<label for="wishes">Wünsche</label>
					</div>
				</div>
			</div>
			<div class="modal-footer color-1">
				<button class="modal-action modal-close waves-effect waves-red btn-flat white-text">Schließen</button>
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

				<input id="booking-id" type="hidden" value="0" />

				<div class="row">
					<div class="col s12 l6 input-field">
						<input id="username" type="text" value="" readonly />
						<label for="username">Username</label>
					</div>

					<div class="col s12 l6 input-field">
						<select id="room-id">
							<?php foreach ($rooms as $room) : ?>
								<option value="<?php echo $room->room_id; ?>"><?php echo htmlentities($room->name); ?></option>
							<?php endforeach; ?>
						</select>
						<label for="room-id">Zimmer</label>
					</div>
				</div>

				<div class="row">
					<div class="col s12 input-field">
						<textarea id="reason" class="materialize-textarea"></textarea>
						<label for="reason">Grund für den Zimmerwechsel</label>
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
						<h5 class="center" data-default="Buchung stornieren">Buchung stornieren</h5>
						<div class="divider"></div>
					</div>
				</div>

				<input id="id" type="hidden" value="0" />

				<div class="row">
					<div class="col s12 input-field">
						<textarea id="reason" class="materialize-textarea"></textarea>
						<label for="reason">Grund für die Stornierung</label>
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
