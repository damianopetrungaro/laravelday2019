<?php

declare(strict_types=1);

namespace OrderService\Service;

use OrderService\Model\User;
use OrderService\ValueObjects\UserID;

final class FindUserID
{
    public function __invoke(string $id): ?UserID
    {
        if (!$user = User::find($id)) {
            return null;
        }

        try {
            return UserID::fromUUID($user['id']);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
