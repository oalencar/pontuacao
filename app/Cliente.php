<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cliente
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $email_alternative
 * @property string $phone
 * @property string $company
*/
class Cliente extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'email_alternative', 'phone', 'company_id'];
    protected $hidden = [];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withTrashed();
    }
    
}
