<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function index(){

        $products = Product::paginate(6);

        return view("allproducts",compact("products"));
    }

    public function laptopProducts(){
        $products = DB::table('products')->where('type',"Laptop")->get();
        return view("laptopProducts",compact("products"));
    }

    public function desktopProducts(){
        $products = DB::table('products')->where('type',"Desktop")->get();
        return view("desktopProducts",compact("products"));
    }

    public function accesoriiProducts(){
        $products = DB::table('products')->where('type',"Accesorii")->get();
        return view("accesoriiProducts",compact("products"));
    }

    public function search(Request $request){
        $searchText = $request->get("searchText");
        $products = Product::where('name',"Like",$searchText."%")->paginate(3);
        return view("allproducts",compact("products"));
    }

    public function addProductToCart(Request $request, $id){
        // salavam sesiunea pentru a nu pierde datele
        $prevCart = $request->session()->get('cart');
        // initializam obiectul Cart cu datele existent sau gol
        // logica din cosntructor se ocupa de restul
        $cart = new Cart($prevCart);

        // preluam datele produsului cu ajutorul modelului Product pe baza id-ului primit din route
        $product = Product::find($id);

        $cart->addItem($id,$product);

        // salvam cart in sesiune
        $request->session()->put('cart', $cart);
        //dump($cart);

        return redirect()->route("allProducts");
    }

    public function showCart(){
        //folosim Session din libraria Illuminate pentru a prelua detaliile cosului
        $cart = Session::get('cart');

        // verificam daca cart este gol sau nu
        if ($cart){
            return view('cartproducts',['cartItems'=>$cart]);
        }else{
            return redirect()->route('allProducts');
        }
    }

    public function deleteItemFromCart(Request $request,$id){

        $cart = $request->session()->get('cart');
        if (array_key_exists($id,$cart->items)){
            unset($cart->items[$id]);
        }

        $prevCart = $request->session()->get('cart');
        $updatedCart = new Cart($prevCart);
        $updatedCart->updatePriceAndQuantity();

        $request->session()->put('cart',$updatedCart);

        return redirect()->route('cartproducts');

    }
}
