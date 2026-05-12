<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Handlers;

use App\Modules\User\Auth\Application\Commands\ForgotPasswordCommand;
use App\Modules\User\Auth\Infrastructure\Pipelines\FindPasswordResetUser;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\PasswordResetPipelinePayload;
use App\Modules\User\Auth\Infrastructure\Pipelines\SendPasswordResetEmail;
use Illuminate\Pipeline\Pipeline;

final readonly class ForgotPasswordHandler
{
    public function __construct(
        private Pipeline $pipeline,
    ) {}

    public function handle(ForgotPasswordCommand $command): void
    {
        $this->pipeline
            ->send(new PasswordResetPipelinePayload($command))
            ->through([
                FindPasswordResetUser::class,
                SendPasswordResetEmail::class,
            ])
            ->thenReturn();
    }
}
