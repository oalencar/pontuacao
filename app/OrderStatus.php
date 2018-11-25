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
*/
class OrderStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['observacao', 'data'];
    protected $hidden = [];
    
    

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDataAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['data'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
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
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }
    
}
