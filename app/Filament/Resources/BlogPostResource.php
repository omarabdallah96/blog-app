<?php

namespace App\Filament\Resources;

use Filament\Forms;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Filament\Resources\BlogPostResource\RelationManagers;
use App\Models\BlogPost;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Field;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\SelectColumn;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make() ->schema([

                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\MarkdownEditor::make('content')->required(),
                Forms\Components\FileUpload::make('featured_image')->maxFiles(1)->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->required()
                    ])->columns([
                        1
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {

        $users = User::pluck('name', 'id')->toArray();

        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('title')->sortable(),
                Tables\Columns\TextColumn::make('author.name')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'draft' => 'Draft',
                        'reviewing' => 'Reviewing',
                        'published' => 'Published',
                    ])->sortable(),

                Tables\Columns\TextColumn::make('created_at')->since()->sortable()->searchable(),


            ])
            ->filters([

                SelectFilter::make('author')
                    ->options($users)

                    ->attribute('author_id')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
