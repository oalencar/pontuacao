<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Score
 *
 * @package App
 * @property string $order
 * @property string $user
 * @property integer $score
*/
class Score extends Model
{
    use SoftDeletes;

    protected $fillable = ['score', 'order_id', 'user_id'];
    protected $hidden = [];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setOrderIdAttribute($input)
    {
        $this->attributes['order_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setScoreAttribute($input)
    {
        $this->attributes['score'] = $input ? $input : null;
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
