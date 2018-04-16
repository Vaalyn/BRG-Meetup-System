<?php
	namespace Model;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	class Room extends Model {
		use SoftDeletes;

		protected $table      = 'room';
		protected $primaryKey = 'room_id';
		protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function roomType(): BelongsTo {
			return $this->belongsTo(RoomType::class, 'room_type_id');
		}

		/**
		 * @param bool $withTrashed
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function bookings(bool $withTrashed = false): HasMany {
			if ($withTrashed) {
				return $this->hasMany(Booking::class, 'room_id')->withTrashed();
			}

			return $this->hasMany(Booking::class, 'room_id');
		}
	}
?>
