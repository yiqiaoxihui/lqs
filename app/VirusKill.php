<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirusKill extends Model
{
    protected $table = 'virusKill';
    //增量镜像与病毒记录一对多关系
    public function overlay(){
    	return $this->belongsTo('App\Overlay','overlayId');
    }
    //病毒与病毒记录一对多关系
    public function virus(){
    	return $this->belongsTo('App\Virus','virusId');
    }
}
