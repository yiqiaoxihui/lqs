<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    public function overlay(){
    	return $this->belongsTo('App\Overlay','overlayId');
    }
    //增量镜像与监控文件一对多关系
}
