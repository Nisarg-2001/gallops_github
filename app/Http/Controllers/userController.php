<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Hash;

class userController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        
        $user = new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->save();

        return redirect('dashboard');
    }
}
