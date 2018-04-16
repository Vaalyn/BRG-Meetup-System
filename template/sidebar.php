<div class="col s12 m6 l4 push-l8 offset-m3 grey-text text-lighten-2 sidebar">
	<a href="https://www.bronyradiogermany.com">
		<div class="card banner-container color-3 hoverable">
			<img src="img/brg_website_link_banner.png"></img>
		</div>
	</a>

	<div class="row event-details">
		<div class="col s12">
			<div class="card color-3 ">
				<div class="card-content center">
					<p class="textblock">
						<?php
							echo sprintf(
								'Vom %s bis %s',
								date('d.m.Y', strtotime($meetupDate)),
								date('d.m.Y', strtotime($meetupDate . ' + 2 days'))
							);
						?>
					</p>

					<div class="divider"></div>
					<p class="textblock">
						Dorfstraße 41<br />
						07768 Seitenroda<br />
						Thüringen
					</p>

					<p class="center">
						<a href="veranstaltungsort" class="btn waves-effect waves-light color-1">Weitere Infos</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row event-cost">
		<div class="col s12">
			<div class="card color-3 ">
				<div class="card-content grey-text text-lighten-2 center">
					<h3 class="card-title center">Teilnahmegebühr</h3>
					<div class="divider"></div>

					<p>
						<?php echo sprintf('Die Teilnahme am BRG Meetup kostet %s€', $meetupCost); ?>
					</p>

					<p class="center">
						<a href="preis" class="btn waves-effect waves-light color-1">Weitere Infos</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
