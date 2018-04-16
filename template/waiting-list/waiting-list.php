<?php include_once(__DIR__ . '/../header.php'); ?>
	<main class="background-pattern">
		<div class="container">
			<div class="row">
				<div class="col s12 m8 offset-m2">
					<div id="waiting-list" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Auf Warteliste eintragen</h3>
							<div class="divider"></div>

							<form>
								<div class="row">
									<div class="col s12 m6 input-field">
										<input name="username" id="username" type="text" />
										<label for="username">Username</label>
									</div>

									<div class="col s12 m6 input-field">
										<input name="email" id="email" type="email" />
										<label for="email">E-Mail</label>
									</div>
								</div>

								<div class="row">
									<div class="col s12 input-field">
										<textarea name="notice" id="notice" class="materialize-textarea"></textarea>
										<label for="notice">Möchtest du uns noch etwas mitteilen?</label>
									</div>
								</div>

								<div class="row center">
									<div class="col s12">
										<a id="book-room" class="btn waves-effect waves-light color-1 submit">Eintragen
											<i class="material-icons right">assignment_turned_in</i>
										</a>
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
