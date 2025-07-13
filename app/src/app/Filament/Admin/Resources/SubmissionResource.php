<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubmissionResource\Pages;
use App\Filament\Admin\Resources\SubmissionResource\RelationManagers;
use App\Models\Submission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $navigationGroup = 'Assessments';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('quiz_id')
                    ->relationship('quiz', 'title')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('submitted_at')
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Upload Dokumen')
                    ->directory('Submission') // folder penyimpanan di storage/app/public/Submission
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword', // .doc
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                    ])
                    ->maxSize(102400) // maksimal 2MB
                    ->disk('public') // gunakan disk 'public' (pastikan `php artisan storage:link` sudah dijalankan)
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                        $quiz = \App\Models\Quiz::find($get('quiz_id'));
                        $user = \App\Models\User::find($get('user_id'));

                        $quizTitle = $quiz?->title ?? 'quiz';
                        $userName = $user?->name ?? 'user';

                        $extension = $file->getClientOriginalExtension();

                        return "{$quizTitle} - {$userName}.{$extension}";
                    }),
                Forms\Components\Textarea::make('text_answer')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('score')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('feedback')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('graded_by_user_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('graded_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quiz.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graded_by_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graded_at')
                    ->dateTime()
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
                    ->url(fn($record) => route('submission.download', ['filename' => basename($record->file_path)]))
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
            'index' => Pages\ListSubmissions::route('/'),
            'create' => Pages\CreateSubmission::route('/create'),
            'edit' => Pages\EditSubmission::route('/{record}/edit'),
        ];
    }
}
