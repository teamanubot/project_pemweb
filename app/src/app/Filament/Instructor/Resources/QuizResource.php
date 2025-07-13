<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\QuizResource\Pages;
use App\Filament\Instructor\Resources\QuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationGroup = 'Assessments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sesi_id')
                    ->relationship('sesi', 'id')
                    ->default(null),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->options([
                        'quiz' => 'Quiz',
                        'assignment' => 'Assignment',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Upload Dokumen')
                    ->directory('Quiz') // folder penyimpanan di storage/app/public/Quiz
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
                        $course = \App\Models\Course::find($get('course_id'));

                        $quizTitle = $quiz?->title ?? 'quiz';
                        $courseName = $course?->name ?? 'course';

                        $extension = $file->getClientOriginalExtension();

                        return "{$courseName} - {$quizTitle}.{$extension}";
                    }),
                Forms\Components\DateTimePicker::make('due_date')
                    ->required(),
                Forms\Components\TextInput::make('max_score')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('created_by_user_id')
                    ->options(function () {
                        $user = auth('instructor')->user();
                        return $user ? [$user->id => $user->name] : [];
                    })
                    ->default(auth('instructor')->id())
                    ->disabled()
                    ->required()
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sesi.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by_user_id')
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
                    ->url(fn($record) => route('quiz.download', ['filename' => basename($record->file_path)]))
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /** @var \App\Models\User|null $user */
        $user = auth('instructor')->user();

        if ($user && $user->hasRole('teacher')) {
            return parent::getEloquentQuery()
                ->where('created_by_user_id', $user->id);
        }

        return parent::getEloquentQuery()->whereRaw('1 = 0'); // Non-teacher tidak bisa lihat apa pun
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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
