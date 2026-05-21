<?php

namespace App\Filament\Resources\SupportTickets\Schemas;

use App\Enums\SupportTicketPriority;
use App\Enums\SupportTicketStatus;
use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupportTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'email')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('related_order_id')
                    ->relationship(name: 'relatedOrder', titleAttribute: 'id')
                    ->searchable()
                    ->preload(),
                Select::make('assigned_to_user_id')
                    ->label('Assigned to')
                    ->relationship(
                        name: 'assignedTo',
                        titleAttribute: 'email',
                        modifyQueryUsing: fn ($q) => $q->whereIn('role', [UserRole::Admin, UserRole::Support])
                    )
                    ->searchable()
                    ->preload(),
                TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(collect(SupportTicketStatus::cases())->mapWithKeys(
                        fn (SupportTicketStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    ))
                    ->required()
                    ->native(false),
                Select::make('priority')
                    ->options(collect(SupportTicketPriority::cases())->mapWithKeys(
                        fn (SupportTicketPriority $s): array => [$s->value => (string) str($s->name)->headline()]
                    ))
                    ->native(false),
                Select::make('opened_by_role')
                    ->options(collect(UserRole::cases())->mapWithKeys(
                        fn (UserRole $r): array => [$r->value => (string) str($r->name)->headline()]
                    ))
                    ->native(false),
            ]);
    }
}
