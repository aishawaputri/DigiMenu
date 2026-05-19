<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // DB Transaction: Jika gagal di tengah jalan, data tidak akan setengah-setengah masuknya
        DB::beginTransaction();

        try {
            $tableId = $request->table_id;
            
            // Logika untuk Takeaway
            if ($request->order_type === 'takeaway' || empty($tableId)) {
                $takeawayTable = Table::firstOrCreate(['name' => 'TAKEAWAY']);
                $tableId = $takeawayTable->id;
            }

            // 1. Simpan ke tabel orders
            $order = Order::create([
                'table_id' => $tableId,
                'guest_count' => $request->guest_count ?? 1,
                'total_amount' => $request->total_amount,
                'status' => 'PAID - ' . ($request->payment_method ?? 'CASH')
            ]);

            // 2. Simpan setiap item ke tabel order_items
            if ($request->has('cart') && is_array($request->cart)) {
                foreach ($request->cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['qty'],
                        'price' => $item['price']
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Pesanan berhasil dicatat di database!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Error Server: ' . $e->getMessage()
            ], 500);
        }
    }
}