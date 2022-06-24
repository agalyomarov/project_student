<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Notice;
use App\Models\Personal;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function info(Clas $clas)
    {
        $students = json_decode($clas->students);
        $personals = Personal::whereIn('login', $students)->get(['id'])->toArray();
        $persons = [];
        foreach ($personals as $person) {
            array_push($persons, $person['id']);
        }
        $students = Student::whereIn('personal_id', $persons)->get();
        foreach ($students as $student) {
            $student->personal = Personal::where('id', $student->personal_id)->first(['login']);
        }
        // dd($students);
        return view('teacher.student_data', compact('students', 'clas'));
    }

    public function notice(Clas $clas)
    {

        // return view('teacher.class', compact('clas'));
        // dd($clas);
        $notices = DB::table('teacher_student_notice')->where(['teacher' => session()->get('login'), 'clas' => $clas->nomer])->get()->reverse();
        // dd($notices);
        return view('teacher.notice', compact('clas', 'notices'));
    }

    public function noticeStore(Clas $clas, Request $request)
    {
        $data = $request->all();
        // dd($data);
        DB::table('teacher_student_notice')->insert(['teacher' => session()->get('login'), 'clas' => $clas->nomer, 'notice' => $data['notice'], 'created_at' => Carbon::now()->format('d.m.Y H:i:s')]);
        return redirect()->route('teacher.notice.index', $clas->id);
    }
    public function noticeDelete(Clas $clas, Request $request)
    {
        $data = $request->all();
        // dd($data);
        DB::table('teacher_student_notice')->where(['teacher' => session()->get('login'), 'clas' => $clas->nomer, 'id' => $data['notice']])->delete();
        return redirect()->route('teacher.notice.index', $clas->id);
    }
}
