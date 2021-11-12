<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.add_user');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'contact' => ['required'],
            'gst' => ['required'],
            'cin' => ['required'],
            'fssai' => ['required'],
            'username' => ['required', 'unique:users'],
            'pincode' =>['required'],
            'role' => ['required'],
        
            
        ]);

    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'gst' => $request->gst,
            'cin' => $request->cin,
            'fssai' => $request->fssai,
            'username' => $request->username,
            'address_line_1' => $request->address1,
            'address_line_2' => $request->address2,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'role' => $request->role,
        ]);

        return redirect('user');
    }
}
