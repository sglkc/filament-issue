<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Validation\ValidationException;

class Issue extends Page implements HasForms
{
    /*
     * Comment use InteractsWithForms to ""fix""
     */
    //use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.issue';

    public ?array $data = [];

    protected function onValidationError(ValidationException $exception): void
    {
        error_log('Hello validation error');
        Notification::make()
            ->danger()
            ->title($exception->getMessage())
            ->body(now())
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('input')
                            ->placeholder('type a letter for error')
                            ->regex('/\d+/'),
                        Actions::make([
                            Actions\Action::make('submit')->submit('submit')
                        ]),
                    ])
            ]);
    }

    public function submit(): void
    {
        $this->validate();
    }
}
