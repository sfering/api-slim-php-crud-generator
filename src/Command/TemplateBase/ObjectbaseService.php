<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ObjectbaseRepository;

final class ObjectbaseService
{
    private ObjectbaseRepository $objectbaseRepository;

    public function __construct(ObjectbaseRepository $objectbaseRepository)
    {
        $this->objectbaseRepository = $objectbaseRepository;
    }

    public function checkAndGet(int $id): object
    {
        return $this->objectbaseRepository->checkAndGet($id);
    }

    public function getAll(): array
    {
        return $this->objectbaseRepository->getAll();
    }

    public function getOne(int $id): object
    {
        return $this->checkAndGet($id);
    }

    public function create(array $input): object
    {
        $objectbase = json_decode((string) json_encode($input), false);

        return $this->objectbaseRepository->create($objectbase);
    }

    public function update(array $input, int $id): object
    {
        $objectbase = $this->checkAndGet($id);
        $data = json_decode((string) json_encode($input), false);

        return $this->objectbaseRepository->update($objectbase, $data);
    }

    public function delete(int $id): void
    {
        $this->checkAndGet($id);
        $this->objectbaseRepository->delete($id);
    }
}
