<?php

namespace App\Filament\Resources\JobFunctionResource\Pages;

use App\Filament\Resources\JobFunctionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobFunctions extends ListRecords
{
    protected static string $resource = JobFunctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
