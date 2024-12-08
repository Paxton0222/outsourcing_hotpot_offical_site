<?php

namespace App\Services;

use App\Exceptions\UserExistsException;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService implements CrudByIdServiceInterface
{
    use CrudByIdService;

    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
        $this->initRepository($this->UserRepository);
    }

    /**
     * @throws UserExistsException
     */
    public function create(array $data): User
    {
        return $this->UserRepository->createUser($data);
    }
}
