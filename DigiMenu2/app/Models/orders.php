namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_id', 'customer_name', 'guest_count', 
        'sub_total', 'discount', 'delivery_fee', 
        'total_amount', 'payment_method', 'status'
    ];

    // Pesanan ini milik meja nomor berapa?
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Satu pesanan memiliki banyak item keranjang
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}