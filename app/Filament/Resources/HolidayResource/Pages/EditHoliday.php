<?php

namespace App\Filament\Resources\HolidayResource\Pages;
use Illuminate\Database\Eloquent\Model;

use App\Filament\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\HolidayApproved;
use App\Mail\HolidayDecline;
use Filament\Notifications\Notification;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        //dd($record);
        //Send email only if apporved
        if($record->type == 'approved'){
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day,
            );
            Mail::to($user)->send(new HolidayApproved($data));
            Notification::make()
                ->title('Solicitud de vacaciones aprovada')
                ->body('Tu colicitud de vacaciones para el día '.$data['day'].' ha sido aprovado.')
                ->success()
                ->sendToDatabase($user);
        }
        else if($record->type == 'decline'){
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day,
            );
            Mail::to($user)->send(new HolidayDecline($data));
            Notification::make()
                ->title('Solicitud de vacaciones aprovada')
                ->body('Tu colicitud de vacaciones para el día '.$data['day'].' ha sido rechazado.')
                ->danger()
                ->sendToDatabase($user);
        }
        return $record;
    }
}
