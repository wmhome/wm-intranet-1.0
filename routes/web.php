<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    //return view('welcome');
    return redirect('/personal');
});

Route::get('/pdf/generate/timesheet/{user}', [PdfController::class,'TimesheetRecords'])->name('pdf.example');