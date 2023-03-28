<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function add(Request $request){

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'category'=>'required',
            'brand'=>'required',
            'desc'=>'required',
            'image'=>'required|image',
            'price'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()], 409);
        }

        $p = new Product();
        $p->name = $request->name;
        $p->category = $request->category;
        $p->brand = $request->brand;
        $p->desc = $request->desc;
        $p->price = $request->price;
        $p->save();

        //store Image
        $url = "http://localhost:8000/image/";
        $file = $request->file('image');
        $extention = $file->getClientOriginalExtension();
        $path = $request->file('image')->storeAs( $p->id.'.'.$extention);
        $request->image->move(public_path('image'),$path);
        $p->image = $path;
        $p->imgpath = $url.$path;
        $p->save();

        return response()->json(['message'=>["Product Successfully added"]]);

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'category'=>'required',
            'brand'=>'required',
            'desc'=>'required',
            'id'=>'required',
            'price'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()], 409);
        }

        $p = Product::find($request->id);
        $p->name = $request->name;
        $p->category = $request->category;
        $p->brand = $request->brand;
        $p->desc = $request->desc;
        $p->price = $request->price;
        $p->save();

        return response()->json(['message'=>["Product Successfully Updated"]]);
    }

    public function delete(Request $request){

        $validator = Validator::make($request->all(),[
            'id'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()], 409);
        }

        $p = Product::find($request->id)->delete();

        return response()->json(['message'=>["Product Successfully Deleted"]]);
    }

    public function show(Request $request){

        session(['keys'=> $request->keys]);
        $products = Product::where(function($q){
            $q->where('products.id','LIKE','%'.session('keys').'%')
              ->orWhere('products.name','LIKE','%'.session('keys').'%')
              ->orWhere('products.price','LIKE','%'.session('keys').'%')
              ->orWhere('products.category','LIKE','%'.session('keys').'%')
              ->orWhere('products.brand','LIKE','%'.session('keys').'%');
        })->select('products.*')->get();

        return response()->json(['products'=>$products]);
    }
}
