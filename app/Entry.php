<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model {

	protected $table = 'entries';

    protected $fillable = ['user_id', 'description', 'visit_at'];

    protected $dates = ['visit_at'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
