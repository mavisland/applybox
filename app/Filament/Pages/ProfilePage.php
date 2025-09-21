<?php

namespace App\Filament\Pages;

use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Profile';

    public function getTitle(): string
    {
        return __('Profile');
    }

    protected static ?string $navigationLabel = 'Profile';

    public static function getNavigationLabel(): string
    {
        return __('Profile');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::UserCircle;
    // We'll handle navigation grouping in getNavigationGroup method
    protected static ?int $navigationSort = 6;

    protected string $view = 'filament.pages.profile-page';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function form(Schema $schema)
    {
        return $schema
            ->schema([
                Section::make(__('Profile Information'))
                    ->description(__('Update your account\'s profile information and email address.'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Full Name'))
                            ->required()
                            ->maxLength(255),
                    ]),

                Section::make(__('Update Password'))
                    ->description(__('For your security, make sure you use a strong and long password.'))
                    ->schema([
                        TextInput::make('current_password')
                            ->label(__('Current Password'))
                            ->password()
                            ->dehydrated(false)
                            ->rules(['required_with:password'])
                            ->currentPassword()
                            ->autocomplete('current-password'),
                        TextInput::make('password')
                            ->label(__('New Password'))
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->rules([
                                'confirmed',
                                Password::defaults(),
                            ]),
                        TextInput::make('password_confirmation')
                            ->label(__('Confirm New Password'))
                            ->password()
                            ->dehydrated(false)
                            ->rules([
                                Password::defaults(),
                            ])
                            ->autocomplete('new-password'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();

        // Update name
        if ($data['name'] !== $user->name) {
            $user->name = $data['name'];
        }

        // Update password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        Notification::make()
            ->title(__('Profile updated successfully.'))
            ->success()
            ->send();

        // Reset password fields
        $this->form->fill([
            'name' => $user->name,
            'current_password' => null,
            'password' => null,
            'password_confirmation' => null,
        ]);
    }
}
