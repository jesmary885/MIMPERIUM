<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use PDF;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class ShoppingCart extends Component
{

    protected $listeners = ['render'];

    public function destroy(){
        Cart::destroy();

        $this->emitTo('dropdown-cart', 'render');
    }

    public function delete($rowID){
        Cart::remove($rowID);
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }

    public function finish(){

        $fecha = date("d-m-Y");

        $puntos = 0;
        $puntos_category = 0;

        foreach (Cart::content() as $item) {
            
            $puntos = ($item->options['points'] *  $item->qty) + $puntos;

            if($item->options['category'] == 1) $puntos_category = ($item->options['points'] *  $item->qty) + $puntos_category;
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->total = Cart::subtotal();
        $order->content = Cart::content();
        $order->status = 1;
        $order->points_total = $puntos;
        $order->points_total_category = $puntos_category;
        $order->save();

        foreach (Cart::content() as $item) {
            discount($item);
        }

        $data = [
            'productos' => Cart::content(),
            'total' => Cart::subtotal(),
            'fecha' => $fecha,
            'nro_orden' => $order->id,  
            'cliente' =>  auth()->user()->name,
            'cliente_code' =>  auth()->user()->code,
        ];
      
        $pdf = PDF::loadView('order.exportPdf',$data)->output();

        Cart::destroy();

        return response()->streamDownload(
            fn () => print($pdf),
            "Pedido de productos.pdf"
        );
    }
}
