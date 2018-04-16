<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div id="canceled-bookings-list" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Stornierte Buchungen</h3>
							<div class="divider"></div>

							<div class="overflow-side-scroll">
								<table class="striped">
									<thead>
										<tr>
											<th>Username</th>
											<th>Vorname</th>
											<th>Nachname</th>
											<th>E-Mail</th>
											<th>Bezahlt</th>
											<th>Aktion</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($bookings as $booking) : ?>
											<tr>
												<td><?php echo htmlentities($booking->user->username); ?></td>
												<td><?php echo htmlentities($booking->user->userInfo->first_name); ?></td>
												<td><?php echo htmlentities($booking->user->userInfo->last_name); ?></td>
												<td>
													<a href="mailto:<?php echo htmlentities($booking->user->email); ?>">
														<?php echo htmlentities($booking->user->email); ?>
													</a>
												</td>
												<td>
													<?php if ($booking->paid) : ?>
														<i class="material-icons green-text text-darken-2">check_circle</i>
													<?php else : ?>
														<i class="material-icons red-text text-darken-2">remove_circle</i>
													<?php endif; ?>
												</td>
												<td>
													<button class="btn-floating waves-effect waves-light color-1 tooltipped delete-booking" data-id="<?php echo $booking->booking_id; ?>" data-delay="200" data-position="top" data-tooltip="Stornieren">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
										<?php endforeach; ?>

										<?php if (!count($bookings)) : ?>
											<tr>
												<td class="center" colspan="6">
													Keine stornierten Buchungen gefunden
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
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
