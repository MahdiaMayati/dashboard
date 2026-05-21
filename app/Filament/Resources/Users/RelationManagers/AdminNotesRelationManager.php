<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Models\AdminNote;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminNotesRelationManager extends RelationManager
{
    protected static string $relationship = 'adminNotesAbout';

    protected static ?string $title = 'Internal notes';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('note')
                    ->wrap(),
                TextColumn::make('admin.name')
                    ->label('Admin'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add note')
                    ->form([
                        Textarea::make('note')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->action(function (array $data): void {
                        AdminNote::query()->create([
                            'user_id' => $this->getOwnerRecord()->getKey(),
                            'admin_user_id' => auth()->id(),
                            'note' => $data['note'],
                        ]);
                    })
                    ->authorize(fn (): bool => auth()->user()->can('create', AdminNote::class)),
            ])
            ->recordActions([
                DeleteAction::make()
                    ->authorize(fn (AdminNote $record): bool => auth()->user()->can('delete', $record)),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
