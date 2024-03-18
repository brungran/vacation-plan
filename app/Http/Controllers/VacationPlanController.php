<?php

namespace App\Http\Controllers;

use App\Models\VacationPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use function Spatie\LaravelPdf\Support\pdf;

class VacationPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json([
            'Successful'=>true,
            'data'=>VacationPlan::all()
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
        $vacationPlan = new VacationPlan;
        $vacationPlan->title = $request->title;
        $vacationPlan->description = $request->description;
        $vacationPlan->date = $request->date;
        $vacationPlan->location = $request->location;
        $vacationPlan->participants = $request->participants;
        $vacationPlan->save();
        return response()->json([
            'successful'=>true,
            'data'=>$vacationPlan
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'Successful'=>true,
            'data'=>VacationPlan::find($id)
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
        $vacationPlan = VacationPlan::find($id);
        $vacationPlan->title = $request->title;
        $vacationPlan->description = $request->description;
        $vacationPlan->date = $request->date;
        $vacationPlan->location = $request->location;
        $vacationPlan->participants = $request->participants;
        $vacationPlan->save();
        return response()->json([
            'successful'=>true,
            'data'=>$vacationPlan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vacationPlan = VacationPlan::find($id);
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
        // Pdf::view('pdf.vacationPlan')->save('./plan.pdf');
        return pdf()
            ->view('pdf.vacationPlan', compact('id'))
            ->name('plan.pdf');
            // ->download();
    }
}
