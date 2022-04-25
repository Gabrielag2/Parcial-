<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $primaryKey = 'product_id';
    protected $fillable = [
         'category_id', 'codigo', 'nombre', 'descripcion', 'estado','imagen','precio'
     ];
    static function get_ll()
    {
        $return=DB::table('products')
        ->join('categories','products.category_id','=','categories.category_id');
        return $return;
    }

}
