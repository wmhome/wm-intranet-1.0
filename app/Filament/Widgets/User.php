<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class User extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    public ?string $filter = 'today';

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $this->getDataUser(),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getDataUser(){
        //Crear usuarios que han sifo creados por mes o en que mes estamos solicitando vacaciones o ver en que mes se solicitan más vacaciones...
        return [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
    }
}
