<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="background-pattern">
			<div class="container">
				<div class="row">
					<?php include_once(__DIR__ . '/../sidebar.php'); ?>

					<div class="col s12 l8 pull-l4">
						<div class="row">
							<div class="col s12">
								<div id="rooms" class="card color-3">
									<div class="card-content grey-text text-lighten-2">
										<h3 class="card-title center">Zimmer</h3>
										<div class="divider"></div>
										<div class="row">
											<div class="col s12">Pärchenbetten sind größere Betten mit einfacher Matratze.</div>
											<div class="col s12">Diese sollten vorzugsweise von zwei Personen, können aber auch als Einzelbett genutzt werden.</div>
										</div>

										<div class="row">
											<div class="col s12">Einige Doppelbetten haben zwei getrennte Matratzen. Hier schläft man mit mehr Abstand.</div>
										</div>

										<div class="row">
											<div class="col s12">Manche Betten sind als Luftmatratze ausgewiesen. Wir haben zwar welche, aber ihr könnt auch gerne eure eigene mitbringen.</div>
										</div>

										<div class="row">
											<div class="col s12">Sollten alle Betten belegt sein haben wir noch die Möglichkeit einige Luftmatratzen im Dachgeschoss aufzustellen. Sprecht uns bei Fragen einfach an.</div>
										</div>
										<div class="row">
											<div class="divider"></div>
										</div>

										<div class="row">
											<div class="col s12 m6 l4">
												<img src="img/zimmerplan-erdgeschoss.png" alt="Zimmerplan Erdgeschoss" class="materialboxed z-depth-1" />
											</div>
											<div class="col s12 m6 l4">
												<img src="img/zimmerplan-obergeschoss.png" alt="Zimmerplan Oberschoss" class="materialboxed z-depth-1" />
											</div>
											<div class="col s12 m6 l4">
												<img src="img/zimmerplan-dachgeschoss.png" alt="Zimmerplan Dachgeschoss" class="materialboxed z-depth-1" />
											</div>
										</div>

										<div class="row">
											<div class="col s12">
												<?php if ($rooms->count()) : ?>
													<ul class="collapsible" data-collapsible="accordion">
														<?php foreach ($rooms as $room) : ?>
															<li>
																<div class="collapsible-header color-4">
																	<div class="left"><?php echo htmlentities($room->name); ?></div>

																	<?php
																		echo sprintf(
																			'<span class="new badge color-1">%s / %s <span class="hide-on-small-only">belegt</span></span>',
																			$room->bookings->count(),
																			$room->bed_count
																		);
																	?>
																</div>
																<div class="collapsible-body">
																	<?php if ($room->bookings->count()) : ?>
																		<ul class="browser-default">
																			<?php foreach ($room->bookings as $booking) : ?>
																				<li><?php echo htmlentities($booking->user->username); ?></li>
																			<?php endforeach; ?>
																		</ul>
																	<?php else : ?>
																		<p class="center">Für dieses Zimmer sind noch keine Anmeldungen vorhanden</p>
																	<?php endif; ?>
																</div>
															</li>
														<?php endforeach; ?>
													</ul>
												<?php else : ?>
													<p class="center">Die Liste der verfügbaren Zimmer wird noch erstellt und veröffentlicht.</p>
												<?php endif; ?>
											</div>
										</div>
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
