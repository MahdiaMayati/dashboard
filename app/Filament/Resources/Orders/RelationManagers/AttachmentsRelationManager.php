<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('path')
                    ->label('Path'),
                TextColumn::make('disk'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        FileUpload::make('path')
                            ->disk('public')
                            ->directory('order-attachments')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('original_name')
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        $this->getOwnerRecord()->attachments()->create([
                            'disk' => 'public',
                            'path' => $data['path'],
                            'original_name' => $data['original_name'] ?? null,
                        ]);
                    }),
            ])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
