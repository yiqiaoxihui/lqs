<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileScanRecord extends Model
{
    //
    protected $table = 'fileScanRecord';
    //全盘扫描与增量镜像一对多关系
    public function overlay(){
    	return $this->belongsTo('App\Overlay','overlayId');
    }
}
