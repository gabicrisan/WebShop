<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminProductsController extends Controller
{
    //toate produsele
    public function index(){
        $products = Product::paginate(10);
        return view("admin.displayProducts",['products'=>$products]);
    }

    // doar afiseaza formularul
    public function editProductForm($id){
        $product = Product::find($id);

        return view('admin.editProductForm',['product'=>$product]);
    }

    //doar afiseaza formularul
    public function editProductImageForm($id){
        $product = Product::find($id);

        return view('admin.editProductImageForm',['product'=>$product]);
    }

    public function updateProductImage(Request $request,$id){
        Validator::make($request->all(),['image'=>"required|file|mimes:jpg,png,jpeg|max:5000"])->validate();

        if ($request->hasFile("image")){

            // verificam daca imaginea veche exista deci stabilim daca trebuie inlocuita
            $product = Product::find($id);
            $exists = Storage::disk('local')->exists("public/product_mages/".$product->image);
            // daca exista o stergem
            if ($exists){
                Storage::delete('public/product_images/'.$product->image);
            }

            //incarcam imaginea noua
            $ext = $request->file('image')->getClientOriginalExtension(); // returneaza extensia fisierului image
            $request->image->storeAs("public/product_images/",$product->image);

            // schimbam numele imaginii in DB
            $arrayToUpdate = array('image'=>$product->image);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);

            return redirect()->route('adminDisplayProducts');

        }else{

            return "NO Image was selected";


        }

    }

    public function updateProduct(Request $request,$id){

        // salvam datele din formular in variabile locale
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = str_replace('$','',$request->input('price'));

        // cream un array pentru update db
        $updateArray = array("name"=>$name,"description"=>$description,"type"=>$type,"price"=>$price);
        // actualizam db-ul
        DB::table('products')->where('id',$id)->update($updateArray);

        return redirect()->route('adminDisplayProducts');
    }

    //afiseaza formularul de adaugare produs nou
    public function createProductForm(){
        return view("admin.createProductForm");
    }

    //inregistreaza produsul nou in db
    public function sendCreateProductForm(Request $request){

        //salvam datele din form in variabile locale
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = str_replace('$','',$request->input('price'));

        //validam imaginea incarcata
        Validator::make($request->all(),['image'=>"required|file|mimes:jpg,png,jpeg|max:5000"])->validate();
        //salvam extensia imaginii
        $ext = $request->file('image')->getClientOriginalExtension(); // returneaza extensia fisierului image
        //redenumin imaginea cu numele produsului dar fara spatii
        $stringImageReFormat = str_replace( " ","",$request->input('name'));

        //concat numele cu ext
        $imageName = $stringImageReFormat.".".$ext;

        $imageEncoded = File::get($request->image);
        //salvam imaginea in storage
        Storage::disk('local')->put('public/product_images/'.$imageName, $imageEncoded);

        //cream array-ul pentru db
        $newProductArray = array("name"=>$name,"description"=>$description,"image"=>$imageName,"type"=>$type,"price"=>$price);
        //inseram datele in db
        $created = DB::table("products")->insert($newProductArray);

        if ($created){
            return redirect()->route('adminDisplayProducts');
        }else{
            return "Product was not created";
        }
    }

    public function deleteProduct($id){

        $product = Product::find($id);

        //verificam daca imaginea exista in storage-ul local
        $exists = Storage::disk('local')->exists("public/product_images/".$product->image);
        // daca exista o stergem
        if ($exists){
            Storage::delete('public/product_images/'.$product->image);
        }

        Product::destroy($id);

        return redirect()->route('adminDisplayProducts');
    }
}
