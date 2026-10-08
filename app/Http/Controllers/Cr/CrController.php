<?php

namespace App\Http\Controllers\Cr;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassRoutine;
use App\Models\ClassCancellation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CrController extends Controller
{
   public function index()
   {
    $crBatch = Auth::user()->batch_no;
    
    $students = User::where('batch_no', $crBatch)->where('role', 'user')->get();
    $routines = ClassRoutine::where('batch_no', $crBatch)->get();

    // Fetch all cancellations belonging to routines of this batch
    $cancelledClasses = ClassCancellation::whereHas('routine', function ($query) use ($crBatch) {
        $query->where('batch_no', $crBatch);
    })->with('routine')->orderBy('cancelled_date', 'desc')->get();

    return view('cr.dashboard', compact('students', 'routines', 'cancelledClasses', 'crBatch'));
    }

    public function storeRoutine(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'course_title' => 'required|string',
            'course_code' => 'required|string',
            'course_teacher' => 'required|string',
            'room' => 'required|string',
            'class_time' => 'required|string',
        ]);

        ClassRoutine::create([
            'batch_no' => Auth::user()->batch_no,
            'day' => $request->day,
            'course_title' => $request->course_title,
            'course_code' => $request->course_code,
            'course_teacher' => $request->course_teacher,
            'room' => $request->room,
            'class_time' => $request->class_time,
        ]);

        return redirect()->back()->with('success', 'Class routine added successfully!');
    }

    // UPDATE ROUTINE
    public function updateRoutine(Request $request, $id)
    {
        $routine = ClassRoutine::findOrFail($id);
        if ($routine->batch_no !== Auth::user()->batch_no) { abort(403); }

        $request->validate([
            'day' => 'required|string',
            'course_title' => 'required|string',
            'course_code' => 'required|string',
            'course_teacher' => 'required|string',
            'room' => 'required|string',
            'class_time' => 'required|string',
        ]);

        $routine->update($request->all());

        return redirect()->back()->with('success', 'Routine updated successfully!');
    }

    // DELETE ROUTINE
    public function deleteRoutine($id)
    {
        $routine = ClassRoutine::findOrFail($id);
        if ($routine->batch_no !== Auth::user()->batch_no) { abort(403); }

        $routine->delete();

        return redirect()->back()->with('success', 'Routine deleted successfully!');
    }

    // TOGGLE CANCEL FOR A SPECIFIC DATE
    public function toggleCancelDate(Request $request, $id)
    {
        $routine = ClassRoutine::findOrFail($id);
        if ($routine->batch_no !== Auth::user()->batch_no) { abort(403); }

        $request->validate([
            'cancelled_date' => 'required|date'
        ]);

        $date = $request->cancelled_date;

        $existing = ClassCancellation::where('class_routine_id', $id)
                                     ->where('cancelled_date', $date)
                                     ->first();

        if ($existing) {
            // If already cancelled for this date, restore it (delete cancellation record)
            $existing->delete();
            $message = "Class restored for {$date}.";
        } else {
            // Otherwise, mark it cancelled for this specific date
            ClassCancellation::create([
                'class_routine_id' => $id,
                'cancelled_date' => $date
            ]);
            $message = "Class cancelled specifically for {$date}. Other days remain active.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function storeUser(Request $request)
    {
        $crBatch = Auth::user()->batch_no;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'student_id' => ['required', 'string', 'max:50', 'unique:users'],
            'department' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'student_id' => $request->student_id,
            'department' => $request->department,
            'batch_no' => $crBatch,
            'role' => 'user',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Student account created successfully!');
    }
}