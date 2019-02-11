<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderStatus
 *
 * @package App
 * @property text $observacao
 * @property string $data
 * @property int $id
 * @property int|null $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Order|null $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\OrderStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\OrderStatus withoutTrashed()
 * @mixin \Eloquent
 */
class OrderStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['observacao', 'data', 'order_id'];
    protected $hidden = [];

    /**
     * Get the post that owns the comment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDataAttribute($input)
    {
        if ($input != null && $input != '') {
//            $this->attributes['data'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
            $this->attributes['data'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['data'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getDataAttribute($input)
    {
//      $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
//            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

}
