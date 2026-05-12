<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Handlers;

use App\Modules\User\Auth\Application\Commands\RegisterCommand;
use App\Modules\User\Auth\Application\DTOs\AuthSessionData;
use App\Modules\User\Auth\Infrastructure\Pipelines\CreateRegisteredUser;
use App\Modules\User\Auth\Infrastructure\Pipelines\IssueAccessToken;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\AuthPipelinePayload;
use Illuminate\Pipeline\Pipeline;
use RuntimeException;

final readonly class RegisterHandler
{
    public function __construct(
        private Pipeline $pipeline,
    ) {}

    public function handle(RegisterCommand $command): AuthSessionData
    {
        /** @var AuthPipelinePayload $payload */
        $payload = $this->pipeline
            ->send(new AuthPipelinePayload($command))
            ->through([
                CreateRegisteredUser::class,
                IssueAccessToken::class,
            ])
            ->thenReturn();

        if (! $payload->user || ! $payload->token) {
            throw new RuntimeException('Registration pipeline finished without a user session.');
        }

        return AuthSessionData::fromUserAndToken($payload->user, $payload->token);
    }
}
