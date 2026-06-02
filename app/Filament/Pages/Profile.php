<?php

namespace App\Filament\Pages;

use BackedEnum;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Filament\Forms\Components\Textarea;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Profile';

    protected string $view = 'livewire.filament.pages.profile';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->form->fill([
            'avatar' => $user->avatar,
            'name' => $user->name,
            'email' => $user->email,
            'headline' => $user->headline,
            'bio' => $user->bio,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        View::make('filament.pages.profile-preview')
                            ->columnSpan(1),

                        Section::make('Edit Profile')
                            ->description('Update your public instructor profile information.')
                            ->schema([
                                FileUpload::make('avatar')
                                    ->label('Avatar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('avatars')
                                    ->imageEditor()
                                    ->imageEditorAspectRatioOptions(['1:1'])
                                    ->circleCropper(),

                                TextInput::make('name')
                                    ->required(),

                                TextInput::make('email')
                                    ->email()
                                    ->required(),

                                TextInput::make('headline')
                                    ->label('Headline'),

                                Textarea::make('bio')
                                    ->label('Bio')
                                    ->rows(5),
                            ])
                            ->columns(2)
                            ->columnSpan(2),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $user->update($this->form->getState());

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Profile updated successfully',
        ]);
    }
}
