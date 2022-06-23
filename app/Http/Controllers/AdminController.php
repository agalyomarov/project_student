<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Personal;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $personals = Personal::where('role', 'admin')->get();
        return view('admin.index', compact('personals'));
    }

    public  function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'login' => ['required', 'unique:personals,login'],
                'password' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('admin.index');
        }

        $validated = $validator->validated();
        $validated['enable'] = true;
        $validated['role'] = 'admin';
        Personal::create($validated);
        return redirect()->route('admin.index');
    }

    public function edit(Personal $admin)
    {
        $personals = Personal::where('role', 'admin')->get();
        return view('admin.index', compact('personals', 'admin'));
    }
    public function update(Personal $admin, Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'login' => ['required', 'unique:personals,login,' . $admin->id],
                'password' => ['required'],
            ]
        );
        if ($validator->fails()) {
            return redirect()->route('admin.index');
        }

        $validated = $validator->validated();
        $admin->login = $validated['login'];
        $admin->password = $validated['password'];
        $admin->save();
        return redirect()->route('admin.index');
    }

    public function delete(Personal $admin, Request $request)
    {
        $admin->delete();
        return redirect()->route('admin.index');
    }

    public function teacherIndex()
    {
        $personals = Personal::where('role', 'teacher')->get();
        return view('admin.teacher', compact('personals'));
    }

    public  function teacherStore(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'login' => ['required', 'unique:personals,login'],
                'password' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('admin.teacher.index');
        }

        $validated = $validator->validated();
        $validated['enable'] = true;
        $validated['role'] = 'teacher';
        Personal::create($validated);
        return redirect()->route('admin.teacher.index');
    }

    public function teacherEdit(Personal $teacher)
    {
        $personals = Personal::where('role', 'teacher')->get();
        return view('admin.teacher', compact('personals', 'teacher'));
    }
    public function teacherUpdate(Personal $teacher, Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'login' => ['required', 'unique:personals,login,' . $teacher->id],
                'password' => ['required'],
            ]
        );
        if ($validator->fails()) {
            return redirect()->route('admin.teacher.index');
        }

        $validated = $validator->validated();
        $teacher->login = $validated['login'];
        $teacher->password = $validated['password'];
        $teacher->save();
        return redirect()->route('admin.teacher.index');
    }

    public function teacherDelete(Personal $teacher, Request $request)
    {
        $teacher->delete();
        return redirect()->route('admin.teacher.index');
    }

    public function studentIndex()
    {
        $personals = Personal::where('role', 'student')->get();
        return view('admin.student', compact('personals'));
    }

    public  function studentStore(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'login' => ['required', 'unique:personals,login'],
                'password' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('admin.student.index');
        }

        $validated = $validator->validated();
        $validated['enable'] = true;
        $validated['role'] = 'student';
        Personal::create($validated);
        return redirect()->route('admin.student.index');
    }

    public function studentEdit(Personal $student)
    {
        $personals = Personal::where('role', 'student')->get();
        return view('admin.student', compact('personals', 'student'));
    }
    public function studentUpdate(Personal $student, Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'login' => ['required', 'unique:personals,login,' . $student->id],
                'password' => ['required'],
            ]
        );
        if ($validator->fails()) {
            return redirect()->route('admin.student.index');
        }

        $validated = $validator->validated();
        $student->login = $validated['login'];
        $student->password = $validated['password'];
        $student->save();
        return redirect()->route('admin.student.index');
    }

    public function studentDelete(Personal $student, Request $request)
    {
        $student->delete();
        return redirect()->route('admin.student.index');
    }

    public function noticeIndex(Personal $personal)
    {
        $admin = Personal::where(['login' => session()->get('login'), 'password' => session()->get('password')])->first();
        if (!$admin) {
            return redirect()->route('login.logout');
        }
        // dd($admin);
        // dd($personal);
        $notices = Notice::where(['admin' => session()->get('login'), 'personal' => $personal->login])->get()->reverse();
        // dd($notices);
        return view('admin.notice', compact('personal', 'notices'));
    }

    public function noticeStore(Personal $personal, Request $request)
    {
        $data = $request->all();
        Notice::create(['admin' => session()->get('login'), 'personal' => $personal->login, 'notice' => $data['notice'], 'created_at' => Carbon::now()->format('d.m.Y H:i:s')]);
        return redirect()->route('admin.notice.index', $personal->id);
        // dd($data);
    }

    public function noticeDelete(Personal $personal, Request $request)
    {
        $data = $request->all();
        Notice::where(['personal' => $personal->login, 'admin' => session()->get('login'), 'id' => $data['notice']])->delete();
        return redirect()->route('admin.notice.index', $personal->id);
        // dd($data);
    }
}
