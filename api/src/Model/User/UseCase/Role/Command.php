<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Role;

class Command
{
    /**
     * @var string
     */
    public string $id;
    /**
     * @var string
     */
    public string $role;
}
