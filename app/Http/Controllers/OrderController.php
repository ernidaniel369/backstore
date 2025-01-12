<?php

namespace App\Http\Controllers;

use App\Models\Buyers;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Obtener todas las órdenes de compra (Solo Admin)
    public function getAllOrders()
    {
        $this->authorize('admin');
        $orders = Orders::all();
        return response()->json($orders);
    }

    // Obtener órdenes filtradas por fecha (Solo Admin)
    public function getOrdersByDate(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $orders = Orders::whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        return response()->json($orders);
    }

    /////////////////////////////////////////////////////////
    public function createOrder(Request $request)
    {
        $order = new Orders();
        $order->name = $request->name;
        $order->amount = $request->amount;
        $order->price = $request->price;
        $order->purchase_id = $request->email;
        
        do {
            $code = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Orders::where('code', $code)->exists());
        
        $order->code = $code;
        $order->save();
        
        return response()->json(['message' => 'Compra exitosa']);
    }

    //////////////////////////////////
    public function purchaseOrder(Request $request)
    {   
        try {
            $input = $request->all();
            $purchase_id = $input['details']['purchase_units'][0]['reference_id'];
            $status = $input['details']['status'];
            $email_paypal = $input['details']['payer']['email_address'];
            $id_user = $input['data']['payerID'];
            $total = $input['details']['purchase_units'][0]['amount']['value'];
    
            $buyer = new Buyers();
            $buyer->purchase_id = $purchase_id;
            $buyer->status = $status;
            $buyer->email_paypal = $email_paypal;
            $buyer->id_user = $id_user;
            $buyer->total = $total;
            $buyer->email_user = ""; 
            $buyer->save();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
