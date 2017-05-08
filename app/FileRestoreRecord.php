<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileRestoreRecord extends Model
{
	protected $table = 'fileRestoreRecord';
    //与文件的多对一关系
    public function file(){
     	return $this->belongsTo('App\File','fileId');
     }
}
