<?php

namespace App\Filament\Pages;

use App\Models\Application;
use App\Models\Company;
use App\Models\HrContact;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class QuickApplicationForm extends Page implements HasForms
{
    use InteractsWithForms;

    // Title for the page
    protected static ?string $title = 'Quick Application Form';

    // Override the getTitle method (non-static)
    public function getTitle(): string
    {
        return __('Quick Application Form');
    }

    // Navigation label for sidebar
    protected static ?string $navigationLabel = 'Quick Application';

    // Override the static getNavigationLabel method
    public static function getNavigationLabel(): string
    {
        return __('Quick Application');
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.quick-application-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema)
    {
        return $schema
            ->schema([
                Section::make(__('Company Information'))
                    ->description(__('Enter company details or select an existing one'))
                    ->schema([
                        TextInput::make('company_name')
                            ->label(__('Company Name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('company_industry')
                            ->label(__('Industry'))
                            ->maxLength(255),
                        TextInput::make('company_email')
                            ->label(__('Email'))
                            ->email()
                            ->maxLength(255),
                        TextInput::make('company_phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('company_website')
                            ->label(__('Website'))
                            ->url()
                            ->maxLength(255),
                        Textarea::make('company_address')
                            ->label(__('Address'))
                            ->rows(3),
                    ])->columns(2),

                Section::make(__('HR Contact'))
                    ->description(__('Enter HR contact details (optional)'))
                    ->schema([
                        Select::make('existing_hr_contact_id')
                            ->label(__('Select Existing HR Contact'))
                            ->options(function (callable $get) {
                                $companyId = $get('existing_company_id');
                                if (!$companyId)
                                    return [];

                                return HrContact::where('company_id', $companyId)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->live()
                            ->visible(fn(callable $get) => (bool) $get('existing_company_id'))
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (!$state)
                                    return;

                                $contact = HrContact::find($state);
                                if ($contact) {
                                    $set('hr_name', $contact->name);
                                    $set('hr_position', $contact->position);
                                    $set('hr_email', $contact->email);
                                    $set('hr_phone', $contact->phone);
                                }
                            }),
                        TextInput::make('hr_name')
                            ->label(__('Name'))
                            ->maxLength(255),
                        TextInput::make('hr_position')
                            ->label(__('Position'))
                            ->maxLength(255),
                        TextInput::make('hr_email')
                            ->label(__('Email'))
                            ->email()
                            ->maxLength(255),
                        TextInput::make('hr_phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),

                Section::make(__('Application Details'))
                    ->description(__('Enter details about your application'))
                    ->schema([
                        TextInput::make('position')
                            ->label(__('Position'))
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('applied_date')
                            ->label(__('Applied Date'))
                            ->required()
                            ->default(now()),
                        Select::make('status')
                            ->options([
                                'draft' => __('Draft'),
                                'applied' => __('Applied'),
                                'interview' => __('Interview'),
                                'offer' => __('Offer'),
                                'rejected' => __('Rejected'),
                                'withdrawn' => __('Withdrawn'),
                            ])
                            ->required()
                            ->default('draft'),
                        Textarea::make('notes')
                            ->label(__('Notes'))
                            ->rows(3),
                        FileUpload::make('documents')
                            ->label(__('Documents'))
                            ->multiple()
                            ->disk('public')
                            ->directory('application-documents')
                            ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        DB::beginTransaction();

        try {
            // Create or use existing company
            if (!empty($data['existing_company_id'])) {
                $company = Company::find($data['existing_company_id']);
            } else {
                $company = Company::create([
                    'name' => $data['company_name'],
                    'industry' => $data['company_industry'] ?? null,
                    'email' => $data['company_email'] ?? null,
                    'phone' => $data['company_phone'] ?? null,
                    'website' => $data['company_website'] ?? null,
                    'address' => $data['company_address'] ?? null,
                ]);
            }

            // Create or use existing HR contact
            if (!empty($data['existing_hr_contact_id'])) {
                $hrContact = HrContact::find($data['existing_hr_contact_id']);
            } elseif (!empty($data['hr_name'])) {
                $hrContact = HrContact::create([
                    'company_id' => $company->id,
                    'name' => $data['hr_name'],
                    'position' => $data['hr_position'] ?? null,
                    'email' => $data['hr_email'] ?? null,
                    'phone' => $data['hr_phone'] ?? null,
                ]);
            } else {
                $hrContact = null;
            }

            // Create application
            $application = Application::create([
                'company_id' => $company->id,
                'hr_contact_id' => $hrContact?->id,
                'position' => $data['position'],
                'applied_date' => $data['applied_date'],
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Handle documents
            if (!empty($data['documents'])) {
                foreach ($data['documents'] as $document) {
                    $application->addMedia(storage_path('app/public/' . $document))
                        ->toMediaCollection('documents');
                }
            }

            DB::commit();

            Notification::make()
                ->title(__('Application created successfully'))
                ->success()
                ->send();

            $this->form->fill();

        } catch (\Exception $e) {
            DB::rollBack();

            Notification::make()
                ->title(__('Error creating application'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
