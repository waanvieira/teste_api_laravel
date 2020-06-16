<?php

namespace App\Repositories;

use App\Entities\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int                               $take
     * @param bool                              $paginate
     *
     * @return EloquentCollection|Paginator
     */
    public function getAll($do_query = null, $paginate = null, Array $data)
    {
        $query = $this->model;

        if ($do_query) {
            return $query;
        }

        if($paginate){
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    public function findBy(Array $data, $totalPage = null)
    {
        $query = $this->model;

        $result = $query->where(function ($query) use($data){
            if($data['name']){
                $query->where('name', $data['name']);
            }

            if($data['email']){
                $query->where('email', $data['email']);
            }
        });

        if($totalPage) {
            $result->paginate($totalPage);
        }

        return $result->get();
    }

    public function findByID($id)
    {
        try{

            $response = $this->model->find($id);

            if(!$response) {
                return ['result' => false, 'message' => 'Registro não encontrado.', 'code' => 404];
            }

            return ['result' => true, 'message' => 'Registro encontrado com sucesso.', 'data' => $response, 'code' => 200];
        }
        catch (\Exception $exception)
        {
            return ['result' => false, 'message' => 'Erro interno.', 'code' => 500];
        }
    }

    public function store($request)
    {
        // //Inicia o Database Transaction
        DB::beginTransaction();

        try
        {
            //Sucesso!
            DB::commit();

            $response = $this->model->create($request->all());

            return ['result' => true, 'message' => 'Registro cadastrado com sucesso.', 'data' => $response, 'code' => 201];

        }
        catch (\Exception $exception)
        {
            //Fail, desfaz as alterações no banco de dados
            DB::rollBack();
            return ['result' => false, 'message' => 'Erro interno.', 'code' => 500];
        }
    }

    public function update($request, $id)
    {
        //Inicia o Database Transaction
        DB::beginTransaction();

        try
        {
            $response = $this->model->find($id);

            if(!$response) {
                return ['result' => false, 'message' => 'Registro não encontrado.', 'code' => 404];
            }

            $response->update($request->all());

            //Sucesso!
            DB::commit();

            return ['result' => true, 'message' => 'Registro encontrado com sucesso.', 'data' => $response, 'code' => 200];

        }
        catch (\Exception $exception)
        {
            //Fail, desfaz as alterações no banco de dados
            DB::rollBack();
            return ['result' => false, 'message' => 'Erro interno.', 'code' => 500];
        }
    }

    // Exclusão lógica
    public function delete($id)
    {
        try
        {
            //método de exclusão lógica, a definir
            $response = $this->model->find($id);

            if(!$response) {
                return ['result' => false, 'message' => 'Registro não encontrado.', 'code' => 404];
            }

            $response->delete();

            return ['result' => true, 'message' => 'Registro excluído com sucesso', 'code' => 200];
        }
        catch (\Exception $exception)
        {
            return false;
            return ['result' => false, 'message' => 'Erro interno.', 'code' => 500];
        }
    }

}
