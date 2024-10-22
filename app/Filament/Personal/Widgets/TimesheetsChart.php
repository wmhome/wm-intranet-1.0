<?php

namespace App\Filament\Personal\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Timesheet;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimesheetsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    public ?string $filter = 'today';
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            '7 days' => 'Last week',
            '30 days' => 'Last month',
            'year' => 'This year',
        ];
    }
    public function getDescription(): ?string
    {
        return 'Horas trabajadas';
    }
    protected function getData(): array
    {
        $activeFilter = $this->filter;
        if($activeFilter == 'year'){
            $start = now()->startOfYear();
            $end = now()->endOfYear();
        }
        else{
            $start = now()->sub($activeFilter);
            $end = now();
        }
        $data = Trend::query(Timesheet::where('user_id',Auth::user()->id)->where('type','work')->distinct('day_in'))
            ->dateColumn('day_in')
            ->between(
                start: $start,
                end: $end,
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Timesheets',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
