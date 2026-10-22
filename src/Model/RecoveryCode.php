<?php

namespace BronyRadioGermany\Meetup\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecoveryCode extends Model {
	use SoftDeletes;

	protected $table      = 'recovery_code';
	protected $primaryKey = 'recovery_code_id';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}
}
