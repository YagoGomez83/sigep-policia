<?php

namespace App\Filament\Resources\JobFunctionResource\Pages;

use App\Filament\Resources\JobFunctionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobFunction extends EditRecord
{
    protected static string $resource = JobFunctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
