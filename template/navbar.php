<div class="navbar-fixed">
	<nav class="color-1">
		<div class="nav-wrapper container">
			<a href="#" data-activates="side-nav" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>

			<a id="logo-container" href="https://www.bronyradiogermany.com" class="brand-logo">
				<span>
					<img src="img/brg_logo.png" alt="Brony Radio Germany Logo">
				</span>
			</a>

			<ul class="right hide-on-med-and-down">
				<li>
					<a href="">Startseite</a>
				</li>
				<li>
					<a class="dropdown-button" data-activates="nav-info-dropdown">
						Infos<i class="material-icons right">arrow_drop_down</i>
					</a>

					<ul id="nav-info-dropdown" class="dropdown-content color-1">
						<li>
							<a href="programm" class="white-text">Programmplan</a>
						</li>
						<li>
							<a href="nachtwanderung" class="white-text">Nachtwanderung</a>
						</li>
						<li>
							<a href="veranstaltungsort" class="white-text">Veranstaltungsort</a>
						</li>
						<li>
							<a href="verpflegung" class="white-text">Verpflegung</a>
						</li>
						<li>
							<a href="packliste" class="white-text">Packliste</a>
						</li>
						<li>
							<a href="teilnahmegebuehr" class="white-text">Teilnahmegebühr</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="zimmer">Zimmer</a>
				</li>
				<li>
					<a href="gallerie">Galerie</a>
				</li>

				<?php if (!$auth->check()) : ?>
					<li>
						<a href="anmeldung">Anmeldung</a>
					</li>
					<li>
						<a href="login">Login</a>
					</li>
				<?php else : ?>
					<?php if (!$auth->user()->booking()->exists()) : ?>
						<li>
							<a href="anmeldung">Anmeldung</a>
						</li>
					<?php else : ?>
						<li>
							<a href="meine-buchung">Meine Buchung</a>
						</li>
					<?php endif; ?>

					<?php if ($auth->isAdmin()) : ?>
						<li>
							<a href="backoffice/dashboard">Dashboard</a>
						</li>
					<?php endif; ?>
					<li>
						<a href="account" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Account">
							<i class="material-icons">account_circle</i>
						</a>
					</li>
					<li>
						<a href="logout" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Logout">
							<i class="material-icons">exit_to_app</i>
						</a>
					</li>
				<?php endif; ?>
			</ul>

			<ul class="side-nav color-1" id="side-nav">
				<li>
					<a href="" class="white-text">Startseite</a>
				</li>
				<li>
					<a href="programm" class="white-text">Programmplan</a>
				</li>
				<li>
					<a href="nachtwanderung" class="white-text">Nachtwanderung</a>
				</li>
				<li>
					<a href="veranstaltungsort" class="white-text">Veranstaltungsort</a>
				</li>
				<li>
					<a href="verpflegung" class="white-text">Verpflegung</a>
				</li>
				<li>
					<a href="packliste" class="white-text">Packliste</a>
				</li>
				<li>
					<a href="teilnahmegebuehr" class="white-text">Teilnahmegebühr</a>
				</li>
				<li>
					<a href="zimmer" class="white-text">Zimmer</a>
				</li>
				<li>
					<a href="gallerie" class="white-text">Galerie</a>
				</li>

				<?php if (!$auth->check()) : ?>
					<li>
						<a href="anmeldung" class="white-text">Anmeldung</a>
					</li>
					<li>
						<a href="login" class="white-text">Login</a>
					</li>
				<?php else : ?>
					<?php if (!$auth->user()->booking()->exists()) : ?>
						<li>
							<a href="anmeldung" class="white-text">Anmeldung</a>
						</li>
					<?php else : ?>
						<li>
							<a href="meine-buchung" class="white-text">Meine Buchung</a>
						</li>
					<?php endif; ?>

					<?php if ($auth->isAdmin()) : ?>
						<li>
							<a href="backoffice/dashboard" class="white-text">Dashboard</a>
						</li>
					<?php endif; ?>
					<li>
						<a href="account" class="white-text">Account</a>
					</li>
					<li>
						<a href="logout" class="white-text">Logout</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>
</div>
