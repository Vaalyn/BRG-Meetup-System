<?php

namespace BronyRadioGermany\Meetup\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
	protected $table      = 'setting';
	protected $primaryKey = 'setting_id';
	protected $dates      = ['created_at', 'updated_at'];
}
