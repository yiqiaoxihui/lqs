<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //增量镜像与监控文件一对多关系
    public function overlay(){
    	return $this->belongsTo('App\Overlay','overlayId');
    }
    //
    public function fileRestore(){
    	return $this->hasOne('App\FileRestore','fileId');
    }
    /*与文件还原记录一对多关系*/
    public function fileRestoreRecords(){
    	return $this->hasMany('App\FileRestoreRecord','fileId');
    }
}
