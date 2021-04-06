<?php

namespace App\Filament\Resources;

use App\Filament\Roles;
use Filament\Resources\Resource;
use Filament\Resources\Forms\Form;
use Filament\Resources\Tables\Table;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Forms\Components;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Filament\Resources\Forms\Components\BelongsToSelect;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\BelongsToSelect::make('user_id')
                    ->required()
                    ->relationship('user', 'name', function ($query) {
                        return $query->whereHas('roles', function (Builder $query) {
                            $query->where('role_id', 2);
                        });
                    }),
                Components\BelongsToSelect::make('college_id')
                    ->when(fn () => true, function ($field, $record) {
                        return $field->relationship('college', 'name', function ($query) use ($record) {
                            if (isset($record->user->campus_id)) {
                                $c = $record->user->campus_id;
                            } else $c = null;
                            return $query->where('campus_id', $c);
                        });
                    })
                    ->dependable()
                    ->preload(),
                Components\BelongsToSelect::make('department_id')
                    ->when(fn () => true, function ($field, $record) {
                        return $field->relationship('department', 'name', function ($query) use ($record) {
                            if (isset($record->college_id)) {
                                $c = $record->college_id;
                            } else $c = null;
                            return $query->where('college_id', $c);
                        });
                    })
                    ->preload(),
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
            Pages\ListStudents::routeTo('/', 'index'),
            Pages\CreateStudent::routeTo('/create', 'create'),
            Pages\EditStudent::routeTo('/{record}/edit', 'edit'),
        ];
    }
}