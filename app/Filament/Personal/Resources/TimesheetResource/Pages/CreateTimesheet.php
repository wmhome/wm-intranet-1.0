<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTimesheet extends CreateRecord
{
    protected static string $resource = TimesheetResource::class;

    //Customizing data before saving
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }

    //the form can redirect back to the List page
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
