<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    public function baseImages(){
    	//return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
    	return $this->hasMany('App\BaseImage','server_id');
    }
    //Has Many Through
    /*The first argument passed to the hasManyThrough method is the name of the final model we wish to access, while the second argument is the name of the intermediate model.
	Typical Eloquent foreign key conventions will be used when performing the relationship's queries. If you would like to customize the keys of the relationship, you may pass them as the third and fourth arguments to the hasManyThrough method. The third argument is the name of the foreign key on the intermediate model, while the fourth argument is the name of the foreign key on the final model.
	*/
	//通过BaseImage作为中介，连接server和Overaly
    public function overlays(){
    	return $this->hasManyThrough('App\Overlay','App\BaseImage','server_id','baseImageId');
    }

}
