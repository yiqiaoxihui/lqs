<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseImage extends Model
{
    //
     protected $table = 'baseImages';
     //服务器与基础镜像的一对多关系
     public function server(){
     	return $this->belongsTo('App\Server','server_id');
     }
     //原始镜像和增量镜像一对多关系
     public function overlays(){
     	return $this->hasMany('App\Overlay','baseImageId');
     }
}
