<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Filament\Personal\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\HolidayPending;
use Filament\Notifications\Notification;

class ListHolidays extends ListRecords
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            //Customizing data before saving when I not use create page and use modal
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = Auth::user()->id;
                    $data['type'] = "pending";

                    $user = User::find(1);
                    $dataToSend = array(
                        'day' => $data['day'],
                        'name' => User::find($data['user_id'])->name,
                        'email' => User::find($data['user_id'])->email,
                    );
                    Mail::to($user)->send(new HolidayPending($dataToSend));
                    $recipient = auth()->user();
                    Notification::make()
                        ->title('Solicitud de vacaciones')
                        ->body(" El día ".$data['day']." está pendiente de aprovar.")
                        ->warning()
                        ->sendToDatabase($recipient);
                    return $data;
                })
        ];
    }
}
