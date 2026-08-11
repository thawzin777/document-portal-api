<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserController extends BaseController
{
    //

    public function index()
    {
        $users=DB::table('users')->orderBy('created_at','desc')->paginate(6);
        return response()->json($users,200);
        //return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    public function show($id)
    {
        $user=DB::table('users')->where('id',$id)->first();
        if($user){
            return $this->sendResponse($user, "User $id retrieved successfully.");
        }else{
            return $this->sendError('User not found', [], 404);
        }
    }

    public function store(Request $request)
    {
        $validated=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:user,admin'],
        ]);
  
      
        $validatedData = $validated->validated();
        $userId=DB::table('users')->insertGetId([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=>bcrypt($validatedData['password']),
            'role'=>$validatedData['role'],
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        $user = DB::table('users')
        ->where('id', $userId)
        ->first();

        return $this->sendResponse($user, "User created successfully.");
    }
}
