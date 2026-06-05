<?php

namespace App\Filament\Resources\Transactions;

use BackedEnum;
use UnitEnum;
use App\Models\Transaction;
use App\Models\Enrollment;
use App\Filament\Resources\Transactions\Pages;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static string | UnitEnum | null $navigationGroup = 'Finance';

    protected static ?string $navigationLabel = 'Transactions';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    protected static ?string $modelLabel = 'Transaction';

    protected static ?string $pluralModelLabel = 'Transactions';

    protected static ?string $recordTitleAttribute = 'invoice_number';

    public static function getGloballySearchableAttributes(): array
    {
        return ['invoice_number', 'status', 'user.name', 'user.email', 'course.title'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Student' => $record->user?->name ?? '-',
            'Course' => $record->course?->title ?? '-',
            'Status' => ucfirst($record->status),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->label('Student')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('course_id')
                ->label('Course')
                ->relationship('course', 'title')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('invoice_number')
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('amount')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                    'cancelled' => 'Cancelled',
                ])
                ->default('pending')
                ->required(),

            DateTimePicker::make('paid_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable(),

                TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('amount')
                    ->money('IDR'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'cancelled' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->dateTime(),

                TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('markAsPaid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Transaction $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Transaction $record): void {
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        Enrollment::firstOrCreate(
                            [
                                'user_id' => $record->user_id,
                                'course_id' => $record->course_id,
                            ],
                            [
                                'status' => 'active',
                                'progress' => 0,
                                'enrolled_at' => now(),
                            ]
                        );

                        Notification::make()
                            ->title('Payment Approved')
                            ->body('Student has been enrolled successfully.')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
