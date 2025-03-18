<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12 m6 l4">
					<div id="Dashboard" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Statistiken</h3>
							<div class="divider"></div>

							<div class="overflow-side-scroll">
								<table class="striped">
									<tbody>
										<tr>
											<th>Betten</th>
											<td><?php echo $bedCount; ?></td>
										</tr>
										<tr>
											<th>Belegt</th>
											<td><?php echo $bookingsCount; ?></td>
										</tr>
										<tr>
											<th>Frei</th>
											<td><?php echo $bedCount - $bookingsCount; ?></td>
										</tr>
										<tr>
											<th>Bezahlt</th>
											<td><?php echo $paidBookingsCount; ?></td>
										</tr>
										<tr>
											<th>Unbezahlt</th>
											<td><?php echo $bookingsCount - $paidBookingsCount; ?></td>
										</tr>
										<tr>
											<th>Männer</th>
											<td><?php echo $malesCount; ?></td>
										</tr>
										<tr>
											<th>Diverse</th>
											<td><?php echo $nonBinariesCount; ?></td>
										</tr>
										<tr>
											<th>Frauen</th>
											<td><?php echo $femalesCount; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col s12 m6 l8">
					<div id="dashboard" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Aktionen</h3>
							<div class="divider"></div>

							<div class="row center">
								<div class="col s12">
									<a href="mailto:<?php echo htmlentities($mailToAllRecipients); ?>" class="btn waves-effect waves-light color-1">
										E-Mail an alle
									</a>
								</div>
							</div>

							<div class="row center">
								<div class="col s12">
									<a href="api/booking/export" class="btn waves-effect waves-light color-1" download>
										Buchungen<i class="material-icons right">file_download</i>
									</a>
								</div>
							</div>

							<div class="row center">
								<div class="col s12">
									<?php if ($bookingIsActive) : ?>
										<a id="close-booking-process" class="btn waves-effect waves-light color-1">
											Anmeldung schließen<i class="material-icons right">lock</i>
										</a>
									<?php else : ?>
										<a id="open-booking-process" class="btn waves-effect waves-light color-1">
											Anmeldung öffnen<i class="material-icons right">lock_open</i>
										</a>
									<?php endif; ?>
								</div>
							</div>

							<div class="row center">
								<div class="col s12">
									<?php if ($waitingListIsActive) : ?>
										<a id="close-waiting-list" class="btn waves-effect waves-light color-1">
											Warteliste schließen<i class="material-icons right">lock</i>
										</a>
									<?php else : ?>
										<a id="open-waiting-list" class="btn waves-effect waves-light color-1">
											Warteliste öffnen<i class="material-icons right">lock_open</i>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
