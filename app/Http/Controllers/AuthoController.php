<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            session([
                'user_id' => $user->id,
                'name' => $user->name,
                'role' => $user->role
            ]);

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/employee/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }
}