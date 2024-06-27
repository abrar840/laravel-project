<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class userController extends Controller
{
    //


public function signup(Request  $req){

//dd($req);
     
        $req->validate([
             
            'password' => 'required|string|min:8|confirmed',
        ]);




        $user = new User;
        $user->name=   $req->input('name');
        $user->email = $req->input('email');
        $user->password = bcrypt($req->input('password')); // Hash the password
        $user->save();


    

        return redirect()->route('home');


    
}



public function login(Request $request)
{
    //dd($request);
    // Validate the incoming request data
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

     
    if (auth()->attempt($credentials)) {
      // dd($credentials);   
 return redirect('/home');

    }



    // Authentication failed...
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}



public function logout(Request $request)
    {
        Auth::logout();


        return redirect('/login');


    }

 


}
 