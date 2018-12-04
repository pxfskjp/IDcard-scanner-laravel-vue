<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
  public function member() {
		return $this->belongsTo('App\Member', 'member_barcode_id', 'barcode_id');
	}

	public function event() {
		return $this->belongsTo('App\Event', 'event_id', 'id');
	}
}
