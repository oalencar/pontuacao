<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 *
 * @package App
 * @property string $nome
 * @property text $endereco
 * @property string $telefone
*/
class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'endereco', 'telefone'];
    protected $hidden = [];



    public function awards() {
        return $this->belongsToMany(Award::class, 'award_company', 'company_id', 'award_id');

    }

    public function partners() {
        return $this->belongsToMany(Partner::class, 'company_partner', 'company_id', 'partner_id');
    }
}
