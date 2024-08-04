<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\product;
use App\Models\rate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Backend\Http\Data\DataType;

class FeedbackController extends Controller
{
    public function index()
    {
        $title = "Feedback";
        $feedbacks = rate::all();
        return view('backend::feedback.index', [
            'title' => $title,
            'feedbacks' => $feedbacks,
        ]);
    }


    public function State($id){
        try {
            $feedbacks = rate::findOrFail($id);
            $feedbacks->status = ($feedbacks->status == 1) ? 0 : 1;
            $feedbacks->save();
    
            return redirect()->back()->with('success', 'feedbacks updated successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }

    public function view($id)
    {
        try{
            $feedback = rate::findOrFail($id);
            return response()->json([
                'feedback' => $feedback,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }
}