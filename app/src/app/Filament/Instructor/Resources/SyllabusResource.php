<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\SyllabusResource\Pages;
use App\Filament\Instructor\Resources\SyllabusResource\RelationManagers;
use App\Models\Syllabus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SyllabusResource extends Resource
{
    protected static ?string $model = Syllabus::class;

    protected static ?string $navigationGroup = 'Content & Modules';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Upload Dokumen')
                    ->directory('Syllabus') // folder penyimpanan di storage/app/public/Syllabus
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword', // .doc
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                    ])
                    ->maxSize(102400) // maksimal 2MB
                    ->disk('public') // gunakan disk 'public' (pastikan `php artisan storage:link` sudah dijalankan)
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                        $course = \App\Models\Course::find($get('course_id'));

                        $courseTitle = $course?->name ?? 'course';
                        $title = $get('title') ?? 'Untitled';

                        $extension = $file->getClientOriginalExtension();

                        return "{$courseTitle} - {$title}.{$extension}";
                    }),
                Forms\Components\Toggle::make('is_verified')
                    ->default(null)
                    ->hidden(),
                Forms\Components\TextInput::make('verified_by_user_id')
                    ->numeric()
                    ->default(null)
                    ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),
                Tables\Columns\TextColumn::make('verified_by_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),  
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => route('syllabus.download', ['filename' => basename($record->file_path)]))
                    ->openUrlInNewTab(true) // WAJIB dibuka di tab baru agar browser force download
                    ->button()
                    ->color('success')
                    ->visible(fn($record) => filled($record->file_path)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSyllabi::route('/'),
            'create' => Pages\CreateSyllabus::route('/create'),
            'edit' => Pages\EditSyllabus::route('/{record}/edit'),
        ];
    }
}
