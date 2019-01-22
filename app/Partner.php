<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Partner
 *
 * @package App
 * @property string $company
 * @property string $user
 * @property string $partner_type
*/
class Partner extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'partner_type_id'];
    protected $hidden = [];
    protected $with = ['partner_type'];



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
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPartnerTypeIdAttribute($input)
    {
        $this->attributes['partner_type_id'] = $input ? $input : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partner_type()
    {
        return $this->belongsTo(PartnerType::class, 'partner_type_id')->withTrashed();
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_partner', 'partner_id','company_id' );
    }

}
