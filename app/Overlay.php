<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overlay extends Model
{
    //基础镜像与增量镜像的一对多关系
    public function baseImage(){
    	return $this->belongsTo('App\BaseImage','baseImageId');
    }
}
