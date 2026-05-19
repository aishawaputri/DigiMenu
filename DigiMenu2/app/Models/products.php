namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'category', 'image_path'];

    // Satu produk bisa ada di banyak detail pesanan
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}