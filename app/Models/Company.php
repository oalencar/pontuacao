<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 *
 * @package App
 * @property string $nome
 * @property text $endereco
 * @property string $telefone
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Award[] $awards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Partner[] $partners
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereEndereco($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withoutTrashed()
 * @mixin \Eloquent
 */
class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'endereco', 'telefone'];
    protected $hidden = [];

    public function partners() {
        return $this->hasMany(Partner::class,  'company_id');
    }

    public function partner_types() {
        return $this->hasMany(PartnerType::class,  'company_id');
    }
}
