<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Resources\Forms\Form;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Hash;

class CreateUser extends CreateRecord
{
    public static $resource = UserResource::class;

    public function beforeCreate()
    {
        $this->validate([
            'record.password' => 'required',
        ]);
        $this->record['password'] = Hash::make($this->record['password']);
    }
}