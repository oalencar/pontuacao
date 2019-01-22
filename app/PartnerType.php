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

//    public function awards() {
//        return $this->hasMany(Award::class, 'partner_type_id');
//    }

    public function awards()
    {
//        return $this->belongsToMany(Company::class, 'company_partner', 'partner_id','company_id' );
        return $this->belongsToMany(Award::class, 'award_partner_type', 'partner_type_id','award_id' );
    }
}
