<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Events\TransactionPaid;
use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected bool $wasPaid = false;

    protected function beforeSave(): void
    {
        $this->wasPaid = $this->record->status === 'paid';
    }

    protected function afterSave(): void
    {
        if (! $this->wasPaid && $this->record->status === 'paid') {
            TransactionPaid::dispatch($this->record);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
