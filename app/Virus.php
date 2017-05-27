<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Virus extends Model
{
    protected $table = 'virus';
    //病毒与病毒记录一对多关系
    public function virusKills(){
        return $this->hasMany('App\VirusKill','virusId');
    }
}
