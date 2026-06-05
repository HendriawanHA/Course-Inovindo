<?php

namespace App\Filament\Resources\Instructors\Pages;

use App\Filament\Resources\Instructors\InstructorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListInstructors extends ListRecords
{
    protected static string $resource = InstructorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->exports([
                    ExcelExport::make('instructors')
                        ->modifyQueryUsing(fn ($query) => $query->where('role', 'instructor'))
                        ->withColumns([
                            Column::make('name')
                                ->heading('Name'),
                            Column::make('email')
                                ->heading('Email address'),
                            Column::make('headline')
                                ->heading('Headline'),
                            Column::make('created_at')
                                ->heading('Joined')
                                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),
                        ])
                        ->withFilename('instructors-' . now()->format('Y-m-d')),
                ]),
            CreateAction::make()
                ->label('New Instructor'),
        ];
    }
}
