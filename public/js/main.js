$(document).ready(function() {
	$('.button-collapse').sideNav();
	$('.parallax').parallax();
	$('.materialboxed').materialbox();
	$('select').material_select();
	$('.modal').modal();
	initializeClock();

	$('.datepicker').pickadate({
		monthsFull: [ 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember' ],
		monthsShort: [ 'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez' ],
		weekdaysFull: [ 'Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag' ],
		weekdaysShort: [ 'So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' ],
		format: 'dd.mm.yyyy',
		formatSubmit: 'yyyy-mm-dd',
		firstDay: 1,
		max: new Date(),
		selectMonths: true,
		selectYears: 100,
		today: 'Heute',
		clear: 'Löschen',
		close: 'Schließen',
		closeOnSelect: true,
		hiddenName: true
	});

	$('#user-details .update-user').on('click', function() {
		let passwordOld = $('#password-old').val();
		let passwordNew = $('#password-new').val();

		$.post('api/user/update', {password_old: passwordOld, password_new: passwordNew})
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim speichern', 3000);
			});
	});

	$('#booking-move-room-modal .modal-save').on('click', function() {
		let isCouple = $('#couple').prop('checked');
		let coupleCode = $('#couple-code').val();
		let roomId = 0;

		if (isCouple) {
			roomId = $('#room-id-couple').val();
		} else {
			roomId = $('#room-id-single').val();
		}

		$.post('api/booking/room/save', {
			couple: isCouple,
			couple_code: coupleCode,
			room_id: roomId
		})
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim speichern', 3000);
			});
	});

	$('#cancel-booking-modal .modal-save').on('click', function() {
		$.post('api/booking/cancel')
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim stornieren', 3000);
			});
	});

	$('#user-details .update-user-info').on('click', function() {
		let firstName = $('#first-name').val();
		let lastName = $('#last-name').val();
		let birthday = $('input[name=birthday]').val();
		let genderId = $('#gender').val();

		$.post('api/user/info/update', {
			first_name: firstName,
			last_name: lastName,
			birthday: birthday,
			gender_id: genderId
		})
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim speichern', 3000);
			});
	});

	$('#booking-information .update-booking-information').on('click', function() {
		let formData = {
			allergies: $('#allergies').val(),
			stuff: $('#stuff').val(),
			wishes: $('#wishes').val()
		};

		if ($('#night-hike').prop('checked')) {
			formData.night_hike = true;
		}

		$.post('api/booking/info/save', formData)
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim speichern', 3000);
			});
	});

	$('#registration .submit').on('click', function() {
		grecaptcha.execute();
	});

	$('#forgot-password-modal .modal-save').on('click', function() {
		let username = $('#username-forgot').val();
		let email = $('#email-forgot').val();

		$.post('api/user/password/forgot', {username: username, email: email})
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim zurücksetzen', 3000);
			});
	});

	$('#password-reset #change-password').on('click', function() {
		let code = $('#code').val();
		let password = $('#password').val();

		$.post('api/user/password/reset', {code: code, password: password})
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim zurücksetzen', 3000);
			});
	});

	$(document).on('change', '#booking #couple, #booking-move-room-modal #couple', function(e) {
		if ($(this).prop('checked')) {
			$('#is-couple').removeClass('hide');
			$('#is-single').addClass('hide');
		} else {
			$('#is-couple').addClass('hide');
			$('#is-single').removeClass('hide');
		}
	});

	$(document).on('input', '#booking #couple-code, #booking-move-room-modal #couple-code', function(e) {
		if ($(this).val().length === 0) {
			$('#room-id-couple-wrapper').removeClass('hide');
		} else {
			$('#room-id-couple-wrapper').addClass('hide');
		}
	});

	$('#booking #book-room').on('click', function() {
		let formData = $('#booking form').serializeArray();
		let isCouple = $('#booking form #couple').prop('checked');

		formData.forEach(function(entry, index) {
			switch (entry.name) {
				case 'room_id_single':
					if (!isCouple) {
						formData[index].name = 'room_id';
					}
					break;

				case 'room_id_couple':
					if (isCouple) {
						formData[index].name = 'room_id';
					}
					break;
			}
		});

		$('#booking #book-room').addClass('hide');
		$('#booking .preloader-wrapper').removeClass('hide');

		$.post('api/booking/create', formData)
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
					$('#booking .preloader-wrapper').addClass('hide');
					$('#booking #book-room').removeClass('hide');
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim buchen', 3000);
				$('#booking .preloader-wrapper').addClass('hide');
				$('#booking #book-room').removeClass('hide');
			});
	});

	$('#waiting-list .submit').on('click', function() {
		let formData = $('#waiting-list form').serializeArray();

		$.post('api/waiting-list/add', formData)
			.done(function(data) {
				if (data.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim eintragen', 3000);
			});
	});
});

function getTimeRemaining(endtime) {
	var t = Date.parse(endtime) - Date.parse(new Date());

	var seconds = Math.floor((t / 1000) % 60);
	var minutes = Math.floor((t / 1000 / 60) % 60);
	var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
	var days = Math.floor(t / (1000 * 60 * 60 * 24));

	return {
		'total': t,
		'days': days,
		'hours': hours,
		'minutes': minutes,
		'seconds': seconds
	};
}

function initializeClock(id) {
	var clock = document.getElementById('countdown-clock');

	if (clock === null) {
		return;
	}

	var daysSpan = clock.querySelector('.days');
	var hoursSpan = clock.querySelector('.hours');
	var minutesSpan = clock.querySelector('.minutes');
	var secondsSpan = clock.querySelector('.seconds');

	function updateClock() {
		var t = getTimeRemaining(new Date(countdownClockDate.replace(/-/g, '/')));

		daysSpan.innerHTML = t.days;
		hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
		minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
		secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

		if (t.total <= 0) {
			clearInterval(timeinterval);
		}
	}

	updateClock();
	var timeinterval = setInterval(updateClock, 1000);
}

function submitRegistrationForm(reCaptchaToken) {
	let formData = $('#registration form').serializeArray();

	formData.forEach(function(entry, index) {
		switch (entry.name) {
			case 'gender':
				formData.splice(index, 1);
				break;

			case 'gender_submit':
				formData[index].name = 'gender';
				break;
		}
	});

	$.post('api/registration', formData)
		.done(function(data) {
			if (data.status === 'success') {
				Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + data.message, 2000, '', function() {
					$.post('api/login', formData)
						.done(function(data) {
							window.location = $('base').attr('href') + 'login';
						});
				});
			} else {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
			}
		})
		.fail(function() {
			Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim speichern', 3000);
		});
};
