<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Roles;
use Filament\Forms\Components\Field;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class UserResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function authorization()
    {
        return [
            Roles\Manager::allow(),
        ];
    }

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name')->autofocus()->required(),
                Components\TextInput::make('email')->email()->required(),
                Components\TextInput::make('password'),
                Components\BelongsToSelect::make('campus_id')
                    ->required()
                    ->relationship('campus', 'name')
                    ->preload(),
            ])
            ->columns(2);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('id'),
                Columns\Text::make('name')->primary()->searchable(),
                Columns\Text::make('email')->searchable(),
                Columns\Text::make('campus.name')->label('Campus'),
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListUsers::routeTo('/', 'index'),
            Pages\CreateUser::routeTo('/create', 'create'),
            Pages\EditUser::routeTo('/{record}/edit', 'edit'),
        ];
    }
}