<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::table('users')
            ->where('username', $username)
            ->first();

        if ($user && Hash::check($password, $user->password)) {

            Session::put('username', $user->username);
            Session::put('userid', $user->id);
            Session::put('role', $user->role);

            // USER GATEOUT
            if ($user->role == 'gateout') {
                return redirect()->route('discharging');
            }

            // USER TALLY
            return redirect()->route('tally.konfirmasi');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Session::flush();

        return redirect()
            ->route('login')
            ->with('error', 'Anda telah logout.');
    }
}