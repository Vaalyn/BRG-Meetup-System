<?php
	namespace Model;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;

	class UserInfo extends Model {
		protected $table      = 'user_info';
		protected $primaryKey = 'user_info_id';
		protected $dates      = ['birthday', 'created_at', 'updated_at'];

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function gender(): BelongsTo {
			return $this->belongsTo(Gender::class, 'gender_id');
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user(): BelongsTo {
			return $this->belongsTo(User::class, 'user_id');
		}
	}
?>
