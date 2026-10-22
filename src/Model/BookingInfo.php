<?php

namespace BronyRadioGermany\Meetup\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingInfo extends Model {
	protected $table      = 'booking_info';
	protected $primaryKey = 'booking_info_id';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function booking(): BelongsTo {
		return $this->belongsTo(Booking::class, 'booking_id');
	}
}
