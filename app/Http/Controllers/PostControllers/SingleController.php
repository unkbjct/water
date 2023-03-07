<?php

namespace App\Http\Controllers\PostControllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function feedbackCreate(Request $request)
    {
        $feedback = New Feedback();
        $feedback->email = $request->input('email');
        $feedback->point = $request->input('point');
        $feedback->description = $request->input('description');
        $feedback->save();
        
        return redirect()->back()->with(['success' => 'Форма обратной связи отправлена успешна!']);
    }
}
