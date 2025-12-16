<?php

namespace App\Filament\Resources\HierarchyResource\Pages;

use App\Filament\Resources\HierarchyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHierarchy extends EditRecord
{
    protected static string $resource = HierarchyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
