<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PartnerType
 *
 * @package App
 * @property string $description
 * @property string $company
*/
class PartnerType extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'company_id'];
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
    
    public function premiacaos() {
        return $this->hasMany(Premiacao::class, 'partner_type_id');
    }
}
