namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'floor'];

    // Satu meja bisa memiliki banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}