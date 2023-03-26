<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
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
=======
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 409);
>>>>>>> Ayah
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Successfully registered']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 409);
        }

        $user = User::where('email', $request->email)->first();

        if ($user && bcrypt($request->password) == $user->password) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 409);
        }
    }
}
