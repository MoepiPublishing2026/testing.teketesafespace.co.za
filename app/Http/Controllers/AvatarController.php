<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\AvatarStore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class AvatarController extends Controller
{
    public function show(Request $request, int $user, AvatarStore $avatars): BaseResponse
    {
        $viewer = $request->user();

        if (! $viewer || (int) $viewer->id !== $user) {
            return $this->deny($viewer ? 404 : 401);
        }

        $model = User::find($user);
        $absolute = $model ? $avatars->locate((string) $model->profile_picture) : null;

        if (! $absolute) {
            return $this->deny(404);
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($absolute) ?: '';
        $ext = AvatarStore::ALLOWED[$mime] ?? null;

        if ($ext === null) {
            return $this->deny(404);
        }

        $response = new BinaryFileResponse($absolute, 200, [
            'Content-Type' => $mime,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store, max-age=0',
            'Referrer-Policy' => 'no-referrer',
            'Content-Security-Policy' => "default-src 'none'; sandbox",
        ], false);
        $response->setContentDisposition('inline', 'avatar.'.$ext);

        return $response;
    }

    private function deny(int $status): Response
    {
        return response('', $status, [
            'Cache-Control' => 'no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
