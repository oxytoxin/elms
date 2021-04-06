<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;
use Hash;

class EditUser extends EditRecord
{
    public static $resource = UserResource::class;

    public function beforeSave()
    {
        if (!$this->record->password) {
            $this->record->password = User::find($this->record->id)->password;
        } else
            $this->record->password = Hash::make($this->record->password);
    }
}