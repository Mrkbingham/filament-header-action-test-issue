<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255),
                Action::make('formDeleteAction')
                    ->label('Delete Customer')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalContent(new HtmlString('Form action modal content'))
                    ->action(function (array $data, $record) {
                        $record->delete();
                    })
                    ->visible(fn ($record) => $record !== null),
                Group::make([
                        Action::make('nestedFormDeleteAction')
                            ->label('Delete Customer')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->modalContent(new HtmlString('Nested form action modal content'))
                            ->action(function (array $data, $record) {
                                $record->delete();
                            })
                            ->visible(fn ($record) => $record !== null),
                    ])
                    ->key('group')
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
