<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    public static $resource = StudentResource::class;
}
