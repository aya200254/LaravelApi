<?php
namespace App\Http\Controllers;
use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Validator;
class userController extends Controller
{
    public function register(Request $request){

        $validator=validator::make($request->all(),[
            'email'=>'require | unique :users',
            'password'=>'require',
            'name'=>'require',            
        ]);
        if($validator->fails()){
    
            return response()->json(['Error'=>$validator->errors()->all()],status:409);
        }
        $p=new User();
        $p->name=$request->name;
        $p->email=$request->email; 
        $p->password=encrypt($request->password); 
        $p->save();
        return response()->json(['message'=>["Sucessfully Registered"]]);
    }
   public function login(Request $request){

    $validator=validator::make($request->all(),[
        'email'=>'require ',
         'password'=>'require', 

    ]);
    if($validator->fails()){

        return response()->json(['Error'=>$validator->errors()->all()],status:409);
    }
   
    $user=User::where('email',$request->email)->get()->first();
    $password=bcrypt($user->password);
    if($user && $password == $request->password ){
        
        return response()->json(['user'=>$user]);
       
    }
        else{
            return response()->json(['Error'=>["oops! Something Going Wrong"]],status:409);
        }

   }


}
