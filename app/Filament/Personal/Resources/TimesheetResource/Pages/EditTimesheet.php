<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimesheet extends EditRecord
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    //the form can redirect back to the List page
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
