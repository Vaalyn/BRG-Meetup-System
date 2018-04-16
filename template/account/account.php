<?php include_once(__DIR__ . '/../header.php'); ?>
	<main class="background-pattern">
		<div class="container">
			<div class="row">
				<div class="col s12 m8 l6 offset-m2">
					<div id="user-details" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center"><?php echo htmlentities($user->username); ?></h3>
							<div class="divider"></div>

							<div class="row">
								<div class="input-field col s12">
									<input id="email" type="text" value="<?php echo htmlentities($user->email); ?>" readonly/>
									<label for="email">E-Mail</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12 m6">
									<input id="password-old" type="password"/>
									<label for="password-old">Altes Passwort</label>
								</div>

								<div class="input-field col s12 m6">
									<input id="password-new" type="password" />
									<label for="password-new">Neues Passwort</label>
								</div>
							</div>

							<div class="row">
								<div class="col s12 center">
									<button class="btn waves-effect waves-light color-1 update-user">Speichern
										<i class="material-icons right">save</i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col s12 m8 l6 offset-m2">
					<div id="user-details" class="card color-3">
						<div class="card-content grey-text text-lighten-2">
							<h3 class="card-title center">Informationen</h3>
							<div class="divider"></div>

							<div class="row">
								<div class="col s12 m6 input-field">
									<input id="first-name" type="text" value="<?php echo htmlentities($user->userInfo->first_name); ?>" />
									<label for="first-name">Vorname</label>
								</div>

								<div class="col s12 m6 input-field">
									<input id="last-name" type="text" value="<?php echo htmlentities($user->userInfo->last_name); ?>" />
									<label for="last-name">Nachname</label>
								</div>
							</div>

							<div class="row">
								<div class="col s12 m6 input-field">
									<input name="birthday" id="birthday" class="datepicker" type="text" value="<?php echo htmlentities($user->userInfo->birthday->format('d.m.Y')); ?>" />
									<label for="birthday">Geburtstag</label>
								</div>

								<div class="col s12 m6 input-field">
									<select id="gender">
										<?php foreach ($genders as $gender) : ?>
											<?php if ($gender->gender_id === $user->userInfo->gender->gender_id) : ?>
												<option value="<?php echo $gender->gender_id; ?>" selected><?php echo htmlentities($gender->name); ?></option>
											<?php else : ?>
												<option value="<?php echo $gender->gender_id; ?>"><?php echo htmlentities($gender->name); ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
									<label for="gender">Geschlecht</label>
								</div>
							</div>

							<div class="row">
								<div class="col s12 center">
									<button class="btn waves-effect waves-light color-1 update-user-info">Speichern
										<i class="material-icons right">save</i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
