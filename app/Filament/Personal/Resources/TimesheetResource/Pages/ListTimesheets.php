<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Timesheet;
use Filament\Notifications\Notification;
use App\Imports\MyTimesheetImport;
use Barryvdh\DomPDF\Facade\Pdf;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        $lastTimesheet = Timesheet::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        if($lastTimesheet == null){
            return [
                Actions\Action::make('inWork')
                ->label('Start Work')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (){
                    $user = Auth::user();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = $user->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'work';
                    $timesheet->save();

                    Notification::make()
                        ->title('You start your work')
                        ->success()
                        ->send();
                }),
                Actions\CreateAction::make(),

            ];
        }
        return [
            Actions\Action::make('inWork')
                ->label("Start Working")
                ->color('success')
                ->visible(!$lastTimesheet->day_out == null)
                ->disabled($lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->keyBindings(['command+s', 'ctrl+s'])
                ->action(function(){
                    $user = Auth::user();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = $user->id;
                    $timesheet->day_in = Carbon::now();
                    //$timesheet->day_out = Carbon::now();
                    $timesheet->type = "work";
                    $timesheet->save();

                    Notification::make()
                        ->title('You start your work')
                        ->color('success')
                        ->body('You start your work at '.Carbon::now())
                        ->success()
                        ->send();
                }),
            Actions\Action::make('stopWork')
                ->label("Stop Working")
                ->color('danger')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();

                    Notification::make()
                        ->title('You stop your work')
                        ->color('danger')
                        ->success()
                        ->send();
                }),
            Actions\Action::make('inPause')
                ->label("Start Pause")
                ->color('info')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    //$timesheet->day_out = Carbon::now();
                    $timesheet->type = "pause";
                    $timesheet->save();

                    Notification::make()
                        ->title('You start your pause')
                        ->color('info')
                        ->success()
                        ->send();
                }),
            Actions\Action::make('stopPause')
                ->label('Stop Pause')
                ->color('danger')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type == 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    //$timesheet->day_out = Carbon::now();
                    $timesheet->type = "work";
                    $timesheet->save();

                    Notification::make()
                        ->title('You stop your pause')
                        ->color('danger')
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make(),
            \EightyNine\ExcelImport\ExcelImportAction::make()->color("primary")->use(MyTimesheetImport::class),
            Actions\Action::make('createPDF')
                ->label('Crear PDF')
                ->color('primary')
                ->requiresConfirmation()
                ->url(
                    fn (): string => route('pdf.example', ['user' => Auth::user()]),
                    shouldOpenInNewTab: true
                )
        ];
    }
}
