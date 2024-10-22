<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Timesheet;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEmploess = User::all()->count();
        $totalHolidays = Holiday::where('type','pending')->count();
        $totalTimesheets = Timesheet::all()->count();
        return [
            Stat::make('Total Employess', $totalEmploess),
            Stat::make('Pending Holidays', $totalHolidays)
                ->description('Holidays pending to approve')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
            Stat::make('Total Timesheets', $totalTimesheets),
        ];
    }
}
