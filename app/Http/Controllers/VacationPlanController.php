<?php

namespace App\Http\Controllers;

use App\Models\VacationPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use function Spatie\LaravelPdf\Support\pdf;
use Carbon\Carbon;

class VacationPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page'=>['sometimes','nullable', 'integer'],
        ]);
        
        return response()->json([
            'Successful'=>true,
            'returned'=>VacationPlan::simplePaginate($request->per_page)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','string'],
            'description'=>['required','string'],
            'date'=>['required','date', 'after_or_equal:today', 'date_format:Y-m-d'],
            'location'=>['required','string'],
            'participants'=>['nullable','sometimes','string'],
        ]);
        
        VacationPlan::create($request->all());
        
        return response()->json([
            'successful'=>true,
            'data'=>VacationPlan::latest()->first()->toArray()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!$vacationPlan = VacationPlan::find($id)){
            return response()->json([
                'Successful'=>false,
                'message'=> 'Vacation plan not found.'
            ]);
        };
        
        return response()->json([
            'Successful'=>true,
            'data'=>$vacationPlan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'=>['sometimes','string'],
            'description'=>['sometimes','string'],
            'date'=>['sometimes','date', 'after_or_equal:today', 'date_format:Y-m-d'],
            'location'=>['sometimes','string'],
            'participants'=>['nullable','sometimes','string'],
        ]);
        
        if(!$VacationPlan = VacationPlan::find($id)){
            return response()->json([
                'successful'=>false,
                'message'=> 'Vacation plan not found.'
            ]);
        }
        $VacationPlan->update($request->all());

        return response()->json([
            'successful'=>true,
            'data'=>VacationPlan::find($id)->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!$vacationPlan = VacationPlan::find($id)){
            return response()->json([
                'Successful'=>false,
                'message'=> 'Vacation plan not found.'
            ]);
        };
        
        $vacationPlan->delete();
        return response()->json([
            'Successful' => true
        ]);
    }

    /**
     * Generate a PDF file for the specified vacation plan.
     */
    public function pdf(string $id)
    {
        if(!$vacationPlan = VacationPlan::find($id)){
            return response()->json([
                'Successful'=>false,
                'message'=> 'Vacation plan not found.'
            ]);
        };
        
        $vacationPlan->date = Carbon::parse($vacationPlan->date);
        
        // Pdf::view('pdf.vacationPlan')->save('./plan.pdf');
        return pdf()
            ->view('pdf.vacationPlan', compact('vacationPlan'))
            ->name('plan.pdf');
            // ->download();
    }
}
