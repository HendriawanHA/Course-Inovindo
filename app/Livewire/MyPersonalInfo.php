<?php

namespace App\Livewire;

use Filament\Forms;

use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo;

class MyPersonalInfo extends PersonalInfo
{
    public array $only = [
        'name',
        'email',
        'avatar',
        'headline',
        'bio',
    ];

    protected function getHeadlineComponent(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('headline')
            ->label('Headline')
            ->maxLength(255);
    }

    protected function getBioComponent(): Forms\Components\Textarea
    {
        return Forms\Components\Textarea::make('bio')
            ->rows(5)
            ->label('Bio');
    }

    protected function getProfileFormSchema(): array
    {
        return [

            Forms\Components\FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->disk('public')
                ->directory('avatars')

                ->imageEditor()

                ->imageEditorAspectRatioOptions([
                    '1:1',
                ])

                ->circleCropper(),

            $this->getNameComponent(),

            $this->getEmailComponent(),

            $this->getHeadlineComponent(),

            $this->getBioComponent(),

        ];
    }
}
