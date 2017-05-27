<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overlay extends Model
{
    //基础镜像与增量镜像的一对多关系
    public function baseImage(){
    	return $this->belongsTo('App\BaseImage','baseImageId');
    }
    //增量镜像与监控文件一对多关系
    public function files(){
    	return $this->hasMany('App\File','overlayId');
    }
    //全盘扫描与增量镜像一对多关系
    public function fileScanRecord(){
    	return $this->hasOne('App\FileScanRecord','fileId');
    }
    //增量镜像与病毒记录一对多关系
    public function virusKills(){
        return $this->hasMany('App\VirusKill','overlayId');
    }
}
