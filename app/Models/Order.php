<?php
namespace App\Models;

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
 * @property Company $company
 * @property string $client
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @property int|null $client_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderStatus[] $order_statuses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Score[] $scores
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['codigo', 'descricao', 'start_date', 'company_id', 'client_id'];
    protected $hidden = [];
    protected $with = ['company', 'client'];

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
