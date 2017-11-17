<?php

namespace App\Http\Controllers\Teacher;

use App\Model\Classes;
use App\Model\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher');
    }

    public function classes() {
        $data = Classes::latest()->paginate(5);
        return view('teacher.class.register_class',compact('data'));
    }

    public function listClass() {
        $teacher_id = Auth::guard('teacher')->user()->id;
        $data = DB::table('classes')->where('teacher_id', $teacher_id)->get();
        return view('teacher.class.list-class', ['data' => $data]);
    }

    public function registerClass($id) {
        $classes = Classes::where('id','=',$id)->first();
        $teacher_id = Auth::guard('teacher')->user()->id;
        if(!$classes->teacher_id == 1 || $teacher_id == 1 || $classes->teacher_id == $teacher_id)
            return back()->with('danger', 'Class was registered by other teacher!!!!');
        DB::table('classes')->where('id', $id)->update(['teacher_id' => $teacher_id]);
        return redirect()->action('Teacher\TeacherController@listClass')->with('success', 'Register Class Successfully');
    }

    public function deleteClass($id)
    {
        DB::table('classes')->where('id', $id)->update(['teacher_id' => '1']);
        return back()->with('success', 'Class detele successfully!!');
    }

    public function listStudent($id) {
        $classes = Classes::where('id','=',$id)->first();
        $data = $classes->students;
        $classes_id = $id;
        return view('teacher/class/list-student', ['data' => $data, 'classes_id' => $classes_id]);
    }

    public function updateScore(Request $request, $id, $classes_id) {
        $student = Student::where('id','=',$id)->first();
        foreach($student->classes as $css)
        {
            if($css->pivot->class_id == $classes_id){
                $css->pivot->score = $request->score;
                $css->pivot->save();
            }
        }
        return redirect()->action('Teacher\TeacherController@listStudent', ['id' => $classes_id])
            ->with('success','Update Score Successfully!!');
    }

    public function getUpdateScore($id, $classes_id) {
        $student = DB::table('students')->where('id','=',$id)->first();
        return view('teacher/class/update-score', [
                                                        'student' => $student,
                                                        'classes_id' => $classes_id,
                                                        ]);
    }
    //
}