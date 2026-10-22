<?php

namespace BronyRadioGermany\Meetup\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaitingList extends Model {
	use SoftDeletes;

	protected $table      = 'waiting_list';
	protected $primaryKey = 'waiting_list_id';
}
