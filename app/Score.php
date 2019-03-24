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
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $order_id
 * @property int|null $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Score onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Score whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Score withoutTrashed()
 * @mixin \Eloquent
 */
class Score extends Model
{
    use SoftDeletes;

    protected $fillable = ['score', 'partner_id'];
    protected $hidden = [];
    protected $with = ['order', 'partner'];



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
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

}
