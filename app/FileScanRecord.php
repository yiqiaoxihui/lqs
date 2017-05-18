<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileScanRecord extends Model
{
    //
    protected $table = 'fileScanRecord';

    public function overlay(){
    	return $this->belongsTo('App\Overlay','overlayId');
    }
}
