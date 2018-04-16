<?php
	namespace Model;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	use Illuminate\Database\Eloquent\SoftDeletes;

	class Booking extends Model {
		use SoftDeletes;

		protected $table      = 'booking';
		protected $primaryKey = 'booking_id';
		protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function room(): BelongsTo {
			return $this->belongsTo(Room::class, 'room_id');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user(): BelongsTo {
			return $this->belongsTo(User::class, 'user_id');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasOne
		 */
		public function bookingInfo(): HasOne {
			return $this->hasOne(BookingInfo::class, 'booking_id');
		}
	}
?>
