<?php

namespace BronyRadioGermany\Meetup\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model {
	use SoftDeletes;

	protected $table      = 'room_type';
	protected $primaryKey = 'room_type_id';
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function rooms(): HasMany {
	    return $this->hasMany(Room::class, 'room_type_id');
	}
}
