<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeacherResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function authorization()
    {
        return [
            Roles\Manager::allow()->only(['viewAny']),
        ];
    }

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\BelongsToSelect::make('user_id')
                    ->required()
                    ->relationship('user', 'name', function ($query) {
                        return $query->whereHas('roles', function (Builder $query) {
                            $query->where('role_id', 3);
                        })->take(30);
                    }),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('user.name')
                    ->label('name')
                    ->searchable()
                    ->primary(),
                Columns\Text::make('college.name')
                    ->label('college'),
                Columns\Text::make('department.name')
                    ->label('department'),
                Columns\Text::make('user.campus.name')
                    ->label('campus'),
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListTeachers::routeTo('/', 'index'),
            Pages\CreateTeacher::routeTo('/create', 'create'),
            Pages\EditTeacher::routeTo('/{record}/edit', 'edit'),
        ];
    }
}