<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class QrCodeApiController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
            'logo' => 'nullable|string' // path opzionale tipo 'logo-nartigiana.png'
        ]);

        $qr = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H');

        if ($request->logo && file_exists(public_path($request->logo))) {
            $qr->merge(public_path($request->logo), 0.3, true);
        }

        $image = $qr->generate($request->data);

        return Response::make($image, 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
