<?php
namespace App\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Score onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Score withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Score withoutTrashed()
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
