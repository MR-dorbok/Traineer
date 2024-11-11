<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;

class TraineeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Trainee::query();
        
     
        if ($request->has('search') && $request->search) {
            $query->where(function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                      ->orWhere('specialization', 'like', '%' . $request->search . '%');
            });
        }
    
     
        if ($request->has('specialization') && $request->specialization) {
            $query->where('specialization', $request->specialization);
        }
    
     
        $trainees = $query->get();
    
     
        $specializations = Trainee::pluck('specialization')->unique();
    
        return view('trainees.index', compact('trainees', 'specializations'));
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('trainees.create');
    }
    
    // Controller method to edit trainee
// Controller
public function destroy($id)
{
    $trainee = Trainee::findOrFail($id);
    $trainee->delete();

    // إعادة التوجيه مع رسالة فلاش
    return redirect()->route('trainees.index')->with('success', 'تم حذف المتدرب بنجاح');
}

public function performAction(Request $request)
{
    // تحقق من أن الـ action هو "delete"
    if ($request->input('action') === 'delete') {
        // احصل على الـ ID من الـ request
        $traineeId = $request->input('trainee_id');
        
        // ابحث عن المتدرب وقم بحذفه
        $trainee = Trainee::find($traineeId);
        
        if ($trainee) {
            $trainee->delete();
            return redirect()->route('trainees.index')->with('success', 'تم حذف المتدرب بنجاح');
        }
        
        return redirect()->route('trainees.index')->with('error', 'المتدرب غير موجود');
    }

    // في حالة أن الـ action ليس "delete" يمكننا إعادته إلى الـ index مع رسالة خطأ
    return redirect()->route('trainees.index')->with('error', 'لم يتم تحديد العملية');
}

    
    // لتعديل المتدرب
    public function edit($id)
    {
        $trainee = Trainee::find($id);  // استخدام find بدلاً من findOrFail لتجنب الخطأ
        if (!$trainee) {
            // في حالة عدم العثور على المتدرب، يمكن إعادة التوجيه إلى صفحة أخرى أو عرض رسالة
            return redirect()->route('trainees.index')->with('error', 'لم يتم العثور على المتدرب');
        }
        return view('trainees.edit', compact('trainee'));
    }
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees',
            'specialization' => 'nullable|string',
            'phone' => 'nullable|string'
        ]);
    
        Trainee::create($request->all());
        return redirect()->route('trainees.index')->with('success', 'تم إضافة المتدرب بنجاح');
    }
    
    public function update(Request $request, Trainee $trainee) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees,email,' . $trainee->id,
            'specialization' => 'nullable|string',
            'phone' => 'nullable|string'
        ]);
    
        $trainee->update($request->all());
        return redirect()->route('trainees.index')->with('success', 'تم تحديث بيانات المتدرب بنجاح');
    }
    
   // داخل الـ Controller

}