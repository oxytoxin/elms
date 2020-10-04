<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MiscController extends Controller
{
    public function fileDownload(File $file)
    {
        // if ($file->google_id)
        //     return Storage::download($file->google_id);
        return Storage::disk('google')->download($file->google_id, $file->url);
    }
}
