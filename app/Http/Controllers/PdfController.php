<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    //
    public function TimesheetRecords (User $user){
        $timesheets = Timesheet::where('user_id', $user->id)->get();
        $pdf = Pdf::loadView('pdf.example',['timesheets'=> $timesheets]);

        return $pdf->download();
    }
}
