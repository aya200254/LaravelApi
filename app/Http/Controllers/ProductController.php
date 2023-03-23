<?php

namespace App\Http\Controllers;
use App\Models\product;
use Illuminate\Support\facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add(Request $request){

        $validator=validator::make($request->all(),[
            'name'=>'require',
            'category'=>'require',
            'brand'=>'require',
            'desc'=>'require',
        
            'image'=>'require |image ',
            'imgpath'=>'require',
            'price'=>'require',
    
        ]);
        if($validator->fails()){
    
            return response()->json(['Error'=>$validator->errors()->all()],status:409);
        }
        $p=product::find($request->id);
        $p->name=$request->name;
        $p->category=$request->category; 
        $p->brand=$request->brand; 
        $p->desc=$request->desc;
        $p->price=$request->price;
        $p->save();

        //storage image
                    $url="http://127.0.0.1:8000/storage/";
                    $file =$request->file(key: 'image');
                    $extension= $file->getClientOriginalExtension();
                    $path = $request->file(key: 'image')->storeAs(path: 'proimages/' , name: $p->id.'.'.$extension);
                    $p->image=$path;
                    $p->imgpath=$url.$path;
                    $p->save();
    }
   public function update(Request $request){

    $validator=validator::make($request->all(),[
        'name'=>'require',
        'category'=>'require',
        'brand'=>'require',
        'desc'=>'require',
        'id'=>'require',
        // 'image'=>'require |image ',
        // 'imgpath'=>'require',
        'price'=>'require',

    ]);
    if($validator->fails()){

        return response()->json(['Error'=>$validator->errors()->all()],status:409);
    }
    $p=product::find($request->id);
    $p->name=$request->name;
    $p->category=$request->category; 
    $p->brand=$request->brand; 
    $p->desc=$request->desc;
    $p->price=$request->price;
    $p->save();
    return response()->json(['message'=>' product sucessfully Updated']);
    //storage image
                // $url="http://127.0.0.1:8000/storage/";
                // $file =$request->file(key: 'image');
                // $extension= $file->getClientOriginalExtension();
                // $path = $request->file(key: 'image')->storeAs(path: 'proimages/' , name: $p->id.'.'.$extension);
                // $p->image=$path;
                // $p->imgpath=$url.$path;
                // $p->save();

   }

   public function delete(Request $request){

    $validator=validator::make($request->all(),[
        
        'id'=>'require',
       

    ]);
    if($validator->fails()){

        return response()->json(['Error'=>$validator->errors()->all()],status:409);
    }
    $p=product::find($request->id)->delete();

    $p->save();
    return response()->json(['message'=>' product sucessfully Deleted']);
    //storage image
                // $url="http://127.0.0.1:8000/storage/";
                // $file =$request->file(key: 'image');
                // $extension= $file->getClientOriginalExtension();
                // $path = $request->file(key: 'image')->storeAs(path: 'proimages/' , name: $p->id.'.'.$extension);
                // $p->image=$path;
                // $p->imgpath=$url.$path;
                // $p->save();

   }

   public function show(Request $request){
    session(['key'=>$request->keys]);
    $products= product::where(function($q){
        $q->where('products.id', 'LIKE', '%' .session(key:'key').'%')
            ->orWhere('products.name', 'LIKE', '%' .session(key:'key').'%')
            ->orWhere('products.price', 'LIKE', '%' .session(key:'key').'%')
            ->orWhere('products.category', 'LIKE', '%' .session(key:'key').'%')
            ->orWhere('products.brand', 'LIKE', '%' .session(key:'key').'%');
    })->select('product.*')->get();
    return response()->json(['products'=>$products]);
}

}