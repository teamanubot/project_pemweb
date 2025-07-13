<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendanceDownloadController extends Controller
{
    public function __invoke(string $filename): BinaryFileResponse
    {
        $filePath = 'Attendance/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        $absolutePath = Storage::disk('public')->path($filePath);

        return response()->download($absolutePath, $filename, [
            'Content-Type' => mime_content_type($absolutePath),
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}