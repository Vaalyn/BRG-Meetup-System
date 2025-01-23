<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div id="room-list" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Zimmer</h3>
							<div class="divider"></div>

							<div class="overflow-side-scroll">
								<table class="striped">
									<thead>
										<tr>
											<th>Name</th>
											<th>Zimmerart</th>
											<th>Betten</th>
											<th>Preis</th>
											<th>Belegt</th>
											<th>Erstellt</th>
											<th>Aktualisiert</th>
											<th>Aktion</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($rooms as $room) : ?>
											<tr>
												<td><?php echo htmlentities($room->name); ?></td>
												<td><?php echo htmlentities($room->roomType->name); ?></td>
												<td><?php echo $room->bed_count; ?></td>
												<td><?php echo $room->price; ?>&nbsp;€</td>
												<td><?php echo $room->bookings->count(); ?></td>
												<td>
													<?php echo $room->created_at->format('H:i:s'); ?>
													<br />
													<?php echo $room->created_at->format('d.m.Y'); ?>
												</td>
												<td>
													<?php echo $room->updated_at->format('H:i:s'); ?>
													<br />
													<?php echo $room->updated_at->format('d.m.Y'); ?>
												</td>
												<td>
													<a href="backoffice/room/<?php echo $room->room_id; ?>/details" alt="Details" class="btn-floating waves-effect waves-light color-1 tooltipped" data-delay="200" data-position="top" data-tooltip="Details">
														<i class="material-icons">assignment</i>
													</a>

													<button class="btn-floating waves-effect waves-light color-1 tooltipped edit-room" data-id="<?php echo $room->room_id; ?>" data-delay="200" data-position="top" data-tooltip="Bearbeiten">
														<i class="material-icons">mode_edit</i>
													</button>

													<button class="btn-floating waves-effect waves-light color-1 tooltipped delete-room" data-id="<?php echo $room->room_id; ?>" data-delay="200" data-position="top" data-tooltip="Löschen">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
										<?php endforeach; ?>

										<?php if (!count($rooms)) : ?>
											<tr>
												<td class="center" colspan="8">
													Keine Zimmer gefunden
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

		<div class="fixed-action-btn horizontal">
			<button class="btn-floating btn-large waves-effect waves-light color-1 modal-trigger" data-target="add-room-modal">
				<i class="large material-icons">add</i>
			</button>
		</div>

		<div id="add-room-modal" class="modal modal-fixed-footer color-3">
			<div class="modal-content white-text">
				<div class="row">
					<div class="col s12">
						<h5 class="center" data-default="Zimmer hinzufügen">Zimmer hinzufügen</h5>
						<div class="divider"></div>
					</div>
				</div>

				<div class="row">
					<form action="" method="post" class="col s12">
						<input name="id" id="id" type="hidden" value="0" />

						<div class="row">
							<div class="input-field col s12 m6">
								<input name="name" id="name" type="text" />
								<label for="name">Name</label>
							</div>

							<div class="input-field col s12 m6">
								<select name="room_type_id" id="room-type">
									<?php foreach ($roomTypes as $roomType) : ?>
										<option value="<?php echo $roomType->room_type_id; ?>"><?php echo htmlentities($roomType->name); ?></option>
									<?php endforeach; ?>
								</select>
								<label for="address-type">Zimmerart</label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12 m6">
								<input name="bed_count" id="bed-count" type="number" />
								<label for="bed-count">Betten</label>
							</div>

							<div class="input-field col s12 m6">
								<input name="price" id="price" type="number" />
								<label for="price">Preis</label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<input name="description" id="description" type="text" />
								<label for="description">Beschreibung</label>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer color-1">
				<button class="modal-action modal-save waves-effect waves-green btn-flat white-text">Speichern</button>
				<button class="modal-action modal-close waves-effect waves-red btn-flat white-text">Abbrechen</button>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
