<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($data['login'] == config('app.ADMIN_LOGIN') && $data['password'] == config('app.ADMIN_PASSWORD')) {
            session(['role' => 'admin']);
            session(['login' => 'admin']);
            session(['password' => 'admin']);
            return redirect()->route('admin.index');
        }
        $personal = Personal::where(['login' => $data['login'], 'password' => $data['password']])->first();
        if ($personal) {
            session(['role' => $personal->role]);
            session(['login' => $personal->login]);
            session(['password' => $personal->password]);
            return redirect()->route($personal->role . '.index');
        }
        // dd($personal);
        // dd($data);
        return redirect()->route('login.index');
    }

    public function logout()
    {
        session()->forget('role');
        session()->forget('login');
        session()->forget('password');
        return redirect()->route('login.index');
    }
}
