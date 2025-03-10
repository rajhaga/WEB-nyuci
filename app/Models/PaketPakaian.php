<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketPakaian extends Model
{
    use HasFactory;
    protected $table = 'paket_pakaians'; // This should match the actual table name

    
    protected $fillable = ['nama'];

    // app/Models/PaketPakaian.php
    public function jenisPakaian()
    {
        return $this->belongsToMany(JenisPakaian::class, 'paket_jenis_pakaian', 'paket_pakaian_id', 'jenis_pakaian_id')
                    ->withPivot('price');
    }
    

}
