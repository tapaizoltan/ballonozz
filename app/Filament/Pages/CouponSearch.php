<?php

namespace App\Filament\Pages;

use App\Models\Coupon;
use Filament\Forms\Form;
use Filament\Pages\Page;

use Filament\Actions\Action;
use PhpParser\Node\Stmt\Label;

use Filament\Forms\Components\Grid;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class CouponSearch extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    protected static ?string $navigationIcon = 'iconoir-password-cursor';
    protected static ?string $navigationLabel = 'Kuponkereső';
    protected static ?string $title = 'Kuponkereső';

    protected static string $view = 'filament.pages.coupon-search';

    public function mount() {
        $this->form->fill();
    }

    public function form(Form $form) :Form {
        return $form->schema([
            Grid::make(4)
            ->schema([
                Section::make() 
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->minLength(3)
                            ->maxLength(20)
                            ->label('Kupon kód')
                            ->prefixIcon('iconoir-input-field')
                            ->helperText('Adja meg az előzetesen kapott kuponkódját és az "Ellenőrzés" gombra kattintva ellenőrizze annak állapotát.'),
                            ])->columnSpan(2),
                
            ]),
        ])->statePath('data');
    }

    public function getFormActions() {
        return [
            Action::make('survey')->submit('survey')->label('Ellenőrzés'),
        ];
    }

    public function survey() {
        try {
            $data = $this->form->getState();
            $validcode = Coupon::query()
            ->where('code', 'LIKE', $data)
            ->get();

            //dd($validcode);
            
            
        }
        catch(Halt $exception) {
            return;
        }
        /*
        Notification::make() 
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
        */
    }

}
