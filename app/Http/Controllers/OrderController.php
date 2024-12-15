<?php

namespace App\Http\Controllers;

use App\Models\Buyers;
use App\Models\orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   
    
/////////////////////////////////////////////////////////
public function createOrder(Request $request)
{
    $order = new orders();
    $order->name = $request->name;
    $order->amount = $request->amount;
    $order->price = $request->price;
    $order->purchase_id = $request->email;
    do {
        $code = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
    } while (orders::where('code', $code)->exists());
    $order->code = $code;
    $order->save();
    echo "Compra existosa";
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
