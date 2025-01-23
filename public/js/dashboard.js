$(document).ready(function() {
	$('.button-collapse').sideNav();
	$('.modal').modal();
	$('select').material_select();

	$('#dashboard #open-booking-process').on('click', function() {
		$.post('api/booking/enable')
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

	$('#dashboard #close-booking-process').on('click', function() {
		$.post('api/booking/disable')
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

	$('#dashboard #open-waiting-list').on('click', function() {
		$.post('api/waiting-list/enable')
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

	$('#dashboard #close-waiting-list').on('click', function() {
		$.post('api/waiting-list/disable')
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

	$('#add-room-modal .modal-save').on('click', function() {
		let formData = $('#add-room-modal form').serialize();

		$.post('api/room/save', formData)
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

	$('#room-list .edit-room').on('click', function() {
		let id = $(this).data('id');

		$.get('api/room/' + id)
			.done(function(data) {
				if (data.status === 'success') {
					$('#add-room-modal h5').text('Zimmer bearbeiten');
					$('#add-room-modal form #id').val(id);
					$('#add-room-modal form #name').val(data.result.name);
					$('#add-room-modal form #description').val(data.result.description);
					$('#add-room-modal form #room-type').val(data.result.room_type_id);
					$('#add-room-modal form #bed-count').val(data.result.bed_count);
					$('#add-room-modal form #price').val(data.result.price);

					Materialize.updateTextFields();
					$('#add-room-modal select').material_select();
					$('#add-room-modal').modal('open');
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Zimmerdaten konnten nicht geladen werden', 3000);
			});
	});

	$('#room-list .delete-room').on('click', function() {
		let id = $(this).data('id');

		$.ajax({url: 'api/room/' + id, method: 'DELETE'})
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
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Zimmer konnte nicht gelöscht werden', 3000);
			});
	});

	$('#add-room-modal').modal({
		complete: function() {
			$('#add-room-modal h5').text($('#add-room-modal h5').data('default'));
			$('#add-room-modal form')[0].reset();
			$('#add-room-modal form #id').val('0');
		}
	});

	$('#booking-list .show-booking-details').on('click', function() {
		let id = $(this).data('id');

		$.get('api/booking/' + id)
			.done(function(data) {
				if (data.status === 'success') {
					$('#booking-details-modal #username').val(data.result.user.username);
					$('#booking-details-modal #birthday').val(data.result.user.user_info.birthday.substring(0, 10));
					$('#booking-details-modal #gender').val(data.result.user.user_info.gender.name);
					$('#booking-details-modal #first-name').val(data.result.user.user_info.first_name);
					$('#booking-details-modal #last-name').val(data.result.user.user_info.last_name);
					$('#booking-details-modal #email').val(data.result.user.email);
					$('#booking-details-modal #country').val(data.result.user.user_info.country);
					$('#booking-details-modal #zip').val(data.result.user.user_info.zip);
					$('#booking-details-modal #city').val(data.result.user.user_info.city);
					$('#booking-details-modal #street').val(data.result.user.user_info.street);
					$('#booking-details-modal #house-number').val(data.result.user.user_info.house_number);
					$('#booking-details-modal #allergies').val(data.result.booking_info.allergies);
					$('#booking-details-modal #stuff').val(data.result.booking_info.stuff);
					$('#booking-details-modal #wishes').val(data.result.booking_info.wishes);

					Materialize.updateTextFields();
					$('#booking-details-modal').modal('open');
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Zimmerdaten konnten nicht geladen werden', 3000);
			});
	});

	$('#booking-list .confirm-room').on('click', function() {
		let id = $(this).data('id');

		$.post('api/booking/' + id + '/confirm')
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

	$('#booking-list .remove-room-confirmation').on('click', function() {
		let id = $(this).data('id');

		$.post('api/booking/' + id + '/confirm/remove')
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

	$('#booking-list .set-booking-paid').on('click', function() {
		let id = $(this).data('id');

		$.post('api/booking/' + id + '/paid')
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

	$('#booking-list .set-booking-unpaid').on('click', function() {
		let id = $(this).data('id');

		$.post('api/booking/' + id + '/unpaid')
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

	$('#booking-list .move-to-room').on('click', function() {
		let id = $(this).data('id');

		$.get('api/booking/' + id)
			.done(function(data) {
				if (data.status === 'success') {
					$('#booking-move-room-modal #booking-id').val(id);
					$('#booking-move-room-modal #username').val(data.result.user.username);
					$('#booking-move-room-modal #room-id').val(data.result.room_id);

					Materialize.updateTextFields();
					$('#booking-move-room-modal select').material_select();
					$('#booking-move-room-modal').modal('open');
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + data.errors, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Buchungsdaten konnten nicht geladen werden', 3000);
			});
	});

	$('#booking-move-room-modal .modal-save').on('click', function() {
		let bookingId = $('#booking-move-room-modal #booking-id').val();
		let roomId = $('#booking-move-room-modal #room-id').val();
		let reason = $('#booking-move-room-modal #reason').val();

		$.post('api/booking/' + bookingId + '/move/room/' + roomId, {reason: reason})
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

	$('#booking-list .cancel-booking').on('click', function() {
		let id = $(this).data('id');

		$('#cancel-booking-modal #id').val(id);

		$('#cancel-booking-modal').modal('open');
	});

	$('#cancel-booking-modal .modal-save').on('click', function() {
		let id = $('#cancel-booking-modal #id').val();
		let reason = $('#cancel-booking-modal #reason').val();

		$.post('api/booking/' + id + '/cancel', {reason: reason})
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

	$('#canceled-bookings-list .delete-booking').on('click', function() {
		let id = $(this).data('id');

		if (!window.confirm('Die stornierte Buchung wirklich aus dem System entfernen?')) {
			return;
		}

		$.ajax({url: 'api/booking/' + id, method: 'DELETE'})
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
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim löschen', 3000);
			});
	});

	$('#waiting-list .delete-entry').on('click', function() {
		let id = $(this).data('id');

		$.ajax({url: 'api/waiting-list/' + id, method: 'DELETE'})
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
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Fehler beim löschen', 3000);
			});
	});
});
