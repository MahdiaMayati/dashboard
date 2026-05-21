<?php

namespace App\Filament\Resources\SupportTickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SupportTicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id'),
                TextEntry::make('subject')
                    ->columnSpanFull(),
                TextEntry::make('status')->badge(),
                TextEntry::make('priority')
                    ->badge()
                    ->placeholder('—'),
                TextEntry::make('user.name')->label('Customer'),
                TextEntry::make('user.email'),
                TextEntry::make('relatedOrder.id')
                    ->label('Related order')
                    ->placeholder('—'),
                TextEntry::make('assignedTo.name')
                    ->label('Assigned to')
                    ->placeholder('—'),
                TextEntry::make('opened_by_role')
                    ->badge()
                    ->placeholder('—'),
                TextEntry::make('resolved_at')->dateTime()->placeholder('—'),
                TextEntry::make('closed_at')->dateTime()->placeholder('—'),
                TextEntry::make('created_at')->dateTime(),
            ]);
    }
}
