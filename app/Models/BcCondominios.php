<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_cliente
 * @property string $nombre
 * @property float $m2
 * @property float $costo_m2
 * @property string $calle
 * @property string $numero
 * @property string $created_at
 * @property string $updated_at
 */
class BcCondominios extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bccondominios';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_cliente', 'nombre', 'm2', 'costo_m2', 'calle', 'numero', 'created_at', 'updated_at'];

}
