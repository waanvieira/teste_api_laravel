<?php

namespace App\Services;

use App\Repositories\UserRepository;

/**
 * Classe que vai conter as regras de negócio
 */
class UserService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($query, $paginate, $data)
    {
        $response = $this->repository->getAll($query, $paginate, $data);
        $currentPage = (int)\Request::get('page', 1);
        $cache_name  = 'list_users';

        $key = $cache_name .'_'. $currentPage;

        $result = cache()->tags($cache_name)->remember($key, now()->addMinutes(60), function () use($response, $paginate) {
                        return $response->paginate($paginate);
                    });

        return $result;
    }

    public function store($request)
    {
        return $this->repository->store($request);
    }

    public function update($request, $id)
    {
        return $this->repository->update($request, $id);
    }

    public function findByID($id)
    {
        return $this->repository->findByID($id);
    }

    public function findBy($data, $paginate = null)
    {
        return $this->repository->findBy($data, $paginate);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

}
