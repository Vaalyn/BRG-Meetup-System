<?php include_once(__DIR__ . '/../header.php'); ?>
	<main class="background-pattern">
		<div class="container">
			<div class="row">
				<div class="col s12 m8 l6 offset-m2 offset-l3">
					<div id="registration" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Account erstellen</h3>
							<div class="divider"></div>

							<div class="row">
								<form action="" method="post" class="col s12">
									<div class="row">
										<div class="input-field col s12 m6">
											<input name="username" id="username" type="text" />
											<label for="username">Username</label>
										</div>

										<div class="input-field col s12 m6">
											<input name="password" id="password" type="password" />
											<label for="password">Passwort</label>
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12">
											<input name="email" id="email" type="email" />
											<label for="email">E-Mail</label>
										</div>
									</div>

									<div class="row">
										<div class="col s12 m6 input-field">
											<input name="first_name" id="first-name" type="text" value="" />
											<label for="first-name">Vorname</label>
										</div>

										<div class="col s12 m6 input-field">
											<input name="last_name" id="last-name" type="text" value="" />
											<label for="last-name">Nachname</label>
										</div>
									</div>

									<div class="row">
										<div class="col s12 m6 input-field">
											<input name="birthday" id="birthday" class="datepicker" type="text" value="" />
											<label for="birthday">Geburtstag</label>
										</div>

										<div class="col s12 m6 input-field">
											<select name="gender_id" id="gender">
												<?php foreach ($genders as $gender) : ?>
													<option value="<?php echo $gender->gender_id; ?>"><?php echo htmlentities($gender->name); ?></option>
												<?php endforeach; ?>
											</select>
											<label for="gender">Geschlecht</label>
										</div>
									</div>

									<div class="row">
										<div class="col s12">
											<p>
												Mit deiner Registrierung bestätigst du die <a href="datenschutz" target="_blank">Datenschutzerklärung</a> gelesen und verstanden zu haben und akzeptierst diese.
											</p>

											<div class="g-recaptcha"
												data-sitekey="<?php echo $recaptchaKey; ?>"
												data-callback="submitRegistrationForm"
												data-size="invisible">
											</div>
											<script src="https://www.google.com/recaptcha/api.js" async defer></script>
										</div>
									</div>

									<div class="row center">
										<div class="col s12">
											<a class="btn waves-effect waves-light color-1 submit">Account erstellen
												<i class="material-icons right">check</i>
											</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
