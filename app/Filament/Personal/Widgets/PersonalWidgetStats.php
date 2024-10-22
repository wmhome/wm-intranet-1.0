<?php

namespace App\Filament\Personal\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Forms\Components\Section;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user())),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user())),
            Stat::make('Total Today Work', $this->getTotalTodayWork(Auth::user())),
            Stat::make('Total Work', $this->getTotalWork(Auth::user())),
            Stat::make('Total Today Pause', $this->getTotalTodayPause(Auth::user())),
            Stat::make('Total Pause', $this->getTotalPause(Auth::user())),
        ];
    }

    protected function getPendingHolidays(User $user){
        $totalPendingHolidays = Holiday::where('user_id',$user->id)
            ->where('type','pending')->get()->count();

        return $totalPendingHolidays;
    }

    protected function getApprovedHolidays(User $user){
        $totalPendingHolidays = Holiday::where('user_id',$user->id)
            ->where('type','approved')->get()->count();

        return $totalPendingHolidays;
    }

    protected function getTotalWork(User $user){
        $timesheets = Timesheet::where('user_id',$user->id)
            ->where('type','work')->get();
        //dd($timesheets);
        $sumHours = 0;
        foreach ($timesheets as $timesheet) {
            // code...
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalTime = $startTime->diffInSeconds($finishTime);
            $sumHours = $sumHours + $totalTime;
        }
        //dd($sumHours);
        $tiempoFormato = gmdate("H:i:s", $sumHours);
        //dd($tiempoFormato);
        $interval = \Carbon\CarbonInterval::seconds($sumHours)->cascade();
        //dd(\Carbon\CarbonInterval::make($interval)->forHumans());
        //$output = dd('%sh %sm', $interval->totalHours, $interval->toArray()['minutes']);
        return $tiempoFormato;
    }

    protected function getTotalTodayWork(User $user){
        $timesheets = Timesheet::where('user_id',$user->id)
            ->where('type','work')->whereDate('created_at', Carbon::today())->get();
        //dd($timesheets);
        $sumHours = 0;
        foreach ($timesheets as $timesheet) {
            // code...
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalTime = $startTime->diffInSeconds($finishTime);
            $sumHours = $sumHours + $totalTime;
        }
        //dd($sumHours);
        $tiempoFormato = gmdate("H:i:s", $sumHours);
        //dd($tiempoFormato);
        $interval = \Carbon\CarbonInterval::seconds($sumHours)->cascade();
        //dd(\Carbon\CarbonInterval::make($interval)->forHumans());
        //$output = dd('%sh %sm', $interval->totalHours, $interval->toArray()['minutes']);
        return $tiempoFormato;
    }

    protected function getTotalPause(User $user){
        $timesheets = Timesheet::where('user_id',$user->id)
            ->where('type','pause')->get();
        //dd($timesheets);
        $sumHours = 0;
        foreach ($timesheets as $timesheet) {
            // code...
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalTime = $startTime->diffInSeconds($finishTime);
            $sumHours = $sumHours + $totalTime;
        }
        //dd($sumHours);
        $tiempoFormato = gmdate("H:i:s", $sumHours);
        //dd($tiempoFormato);
        $interval = \Carbon\CarbonInterval::seconds($sumHours)->cascade();
        //dd(\Carbon\CarbonInterval::make($interval)->forHumans());
        //$output = dd('%sh %sm', $interval->totalHours, $interval->toArray()['minutes']);
        return $tiempoFormato;
    }

    protected function getTotalTodayPause(User $user){
        $timesheets = Timesheet::where('user_id',$user->id)
            ->where('type','pause')->whereDate('created_at', Carbon::today())->get();
        //dd($timesheets);
        $sumHours = 0;
        foreach ($timesheets as $timesheet) {
            // code...
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalTime = $startTime->diffInSeconds($finishTime);
            $sumHours = $sumHours + $totalTime;
        }
        //dd($sumHours);
        $tiempoFormato = gmdate("H:i:s", $sumHours);
        //dd($tiempoFormato);
        $interval = \Carbon\CarbonInterval::seconds($sumHours)->cascade();
        //dd(\Carbon\CarbonInterval::make($interval)->forHumans());
        //$output = dd('%sh %sm', $interval->totalHours, $interval->toArray()['minutes']);
        return $tiempoFormato;
    }
}
