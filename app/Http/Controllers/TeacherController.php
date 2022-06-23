<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Notice;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $notices = Notice::where('personal', session()->get('login'))->get();
        return view('teacher.index', compact('notices'));
    }
    public function classes()
    {
        $classes = Clas::where('teacher', session()->get('login'))->get();
        return view('teacher.class', compact('classes'));
        // dd($classes);
    }

    public function notice(Clas $clas)
    {

        // return view('teacher.class', compact('clas'));
        dd($clas);
    }
}
