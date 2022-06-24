<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Personal;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        // dd(session()->get('login'));
        $clas = Clas::where('students', 'like', '%' . session()->get('login') . '%')->first();
        $notices = DB::table('teacher_student_notice')->where(['clas' => $clas->nomer])->get()->reverse();
        // dd($notices);
        return view('student.index', compact('notices'));
    }
    public function dataIndex()
    {
        $personal = Personal::where('login', session()->get('login'))->first();
        $student = Student::where('personal_id', $personal->id)->first();
        if ($student) {
            return view('student.data', compact('student'));
        }
        return view('student.data');
    }

    public function dataStore(Request $request)
    {
        $data = $request->all();
        $personal = Personal::where('login', session()->get('login'))->first();
        try {
            Student::updateOrCreate(['personal_id' => $personal->id], ['name' => $data['name'], 'phone' => $data['phone'], 'location' => $data['location']]);
            return redirect()->route('student.data.index');
        } catch (\Exception $e) {
            return redirect()->route('student.data.index');
        }
    }
}
