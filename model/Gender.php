<?php
	namespace Model;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\HasMany;

	class Gender extends Model {
		protected $table      = 'gender';
		protected $primaryKey = 'gender_id';
		protected $dates      = ['created_at', 'updated_at'];

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function userInfos(): HasMany {
		    return $this->hasMany(UserInfo::class, 'gender_id');
		}
	}
?>
