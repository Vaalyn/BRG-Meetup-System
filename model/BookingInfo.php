<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingInfo extends Model {
	protected $table      = 'booking_info';
	protected $primaryKey = 'booking_info_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function booking(): BelongsTo {
		return $this->belongsTo(Booking::class, 'booking_id');
	}
}
