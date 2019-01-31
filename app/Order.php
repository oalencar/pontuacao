<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 *
 * @package App
 * @property string $codigo
 * @property string $descricao
 * @property string $start_date
 * @property string $company
 * @property string $client
*/
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['codigo', 'descricao', 'start_date', 'company_id', 'client_id'];
    protected $hidden = [];
    protected $with = ['company'];

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setClientIdAttribute($input)
    {
        $this->attributes['client_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withTrashed();
    }

    public function client()
    {
        return $this->belongsTo(Cliente::class, 'client_id')->withTrashed();
    }

    public function order_statuses() {
        return $this->hasMany(OrderStatus::class, 'order_id');
    }

    public function scores() {
        return $this->hasMany(Score::class, 'order_id');
    }

}
