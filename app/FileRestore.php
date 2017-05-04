<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileRestore extends Model
{
	protected $table = 'fileRestore';
    //
    public function file(){
    	return $this->belongsTo('App\File','fileId');
    }
}
