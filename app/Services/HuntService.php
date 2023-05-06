<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class HuntService
{
    protected PendingRequest $client;

    public function __construct(User $user)
    {
        $encoded = JWT::encode(['user_id' => $user->id], env('JWT_SECRET'), 'HS256');

        $this->client = Http::baseUrl(env('HUNT_ENDPOINT'))
            ->withHeaders([
                'token' => $encoded,
            ]);
    }

    public function hunts(): array
    {
        $data = $this->client->get('list')->throw()->json('data');

        return $data;
    }

    public function huntDetail(int $huntId): array
    {
        $hunt = $this->client->get($huntId)->throw()->json('data');

        return $hunt;
    }
}
