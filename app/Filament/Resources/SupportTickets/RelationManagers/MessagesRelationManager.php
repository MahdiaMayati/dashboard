<?php

namespace App\Filament\Resources\SupportTickets\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $title = 'Conversation';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('sender.name')
                    ->label('From'),
                TextColumn::make('message')
                    ->wrap()
                    ->limit(200),
                IconColumn::make('is_internal')
                    ->boolean()
                    ->label('Internal'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Reply')
                    ->form([
                        Textarea::make('message')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Toggle::make('is_internal')
                            ->label('Internal note (hidden from customer)')
                            ->default(false),
                    ])
                    ->action(function (array $data): void {
                        $this->getOwnerRecord()->messages()->create([
                            'sender_user_id' => auth()->id(),
                            'message' => $data['message'],
                            'is_internal' => (bool) ($data['is_internal'] ?? false),
                        ]);
                    }),
            ])
            ->defaultSort('created_at');
    }
}
