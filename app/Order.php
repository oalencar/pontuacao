<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 *
 * @package App
 * @property string $codigo
 * @property string $descricao
 * @property string $company
 * @property string $client
*/
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['codigo', 'descricao', 'company_id', 'client_id'];
    protected $hidden = [];
    
    

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
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withTrashed();
    }
    
    public function client()
    {
        return $this->belongsTo(Cliente::class, 'client_id')->withTrashed();
    }
    
}
