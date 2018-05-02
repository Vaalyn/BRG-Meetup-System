<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div id="waiting-list" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Warteliste</h3>
							<div class="divider"></div>

							<div class="overflow-side-scroll">
								<table class="striped">
									<thead>
										<tr>
											<th>Username</th>
											<th>Erstellt</th>
											<th>E-Mail</th>
											<th>Notiz</th>
											<th>Aktion</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($waitingListEntries as $waitingListEntry) : ?>
											<tr>
												<td><?php echo htmlentities($waitingListEntry->username); ?></td>
												<td>
													<?php echo $waitingListEntry->created_at->format('H:i:s'); ?>
													<br />
													<?php echo $waitingListEntry->created_at->format('d.m.Y'); ?>
												</td>
												<td>
													<a href="mailto:<?php echo htmlentities($waitingListEntry->email); ?>">
														<?php echo htmlentities($waitingListEntry->email); ?>
													</a>
												</td>
												<td><?php echo htmlentities($waitingListEntry->notice); ?></td>
												<td>
													<button class="btn-floating waves-effect waves-light color-1 tooltipped delete-entry" data-id="<?php echo $waitingListEntry->waiting_list_id; ?>" data-delay="200" data-position="top" data-tooltip="Löschen">
														<i class="material-icons">delete</i>
													</button>
												</td>
											</tr>
										<?php endforeach; ?>

										<?php if (!count($waitingListEntries)) : ?>
											<tr>
												<td class="center" colspan="5">
													Keine Wartelisteneinträge gefunden
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
