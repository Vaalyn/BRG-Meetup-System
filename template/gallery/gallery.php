<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="background-pattern">
			<div class="container">
				<div class="row">
					<div class="col s12 m8 l6 offset-m2 offset-l3">
						<div class="card color-3">
							<div class="card-content grey-text text-lighten-2">
								<?php if ($year !== null) : ?>
									<h3 class="card-title center">Galerie <?php echo $year; ?></h3>
								<?php else : ?>
									<h3 class="card-title center">Galerie</h3>
								<?php endif; ?>
								<div class="divider"></div>

								<div class="row">
									<div class="col s12 center">
										<a href="gallerie/2016" class="btn color-1">Galerie 2016</a>
									</div>
								</div>

								<div class="row">
									<div class="col s12 center">
										<a href="gallerie/2017" class="btn color-1">Galerie 2017</a>
									</div>
								</div>

								<div class="row">
									<div class="col s12 center">
										<a href="gallerie/2018" class="btn color-1">Galerie 2018</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php if ($year !== null) : ?>
					<?php include_once(__DIR__ . '/images.php'); ?>
				<?php endif; ?>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
