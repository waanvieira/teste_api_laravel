<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    private $service;
    private $totalPaginate = 10;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataForm = [];

        $response = $this->service->getAll(true, $this->totalPaginate, $dataForm);

        if(!$response){
            return response()->json([
                    'message'   => 'Registro não encontrado',
                    ], 404);
        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->service->store($request);

        if(!$response['result']){
            return response()->json([
                                'result' => $response['result'],
                                'message' => $response['message'],
                                $response['code']]);
        }

        return response()->json([
                             'response' => $response['data']
                            ], $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->service->findById($id);

        if(!$response['result']){
            return response()->json(['result' => $response['result'], 'message' => $response['message']]);
        }

        return response()->json([
                             'response' => $response
                            ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = $this->service->update($request, $id);

        if(!$response['result']){
            return response()->json([
                                'result' => $response['result'],
                                'message' => $response['message'],
                                $response['code']]);
        }

        return response()->json([
                             'response' => $response['data']
                            ], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->service->delete($id);

        if(!$response['result']){
            return response()->json([
                                'result' => $response['result'],
                                'message' => $response['message'],
                                $response['code']]);
        }

        return response()->json([
                             'response' => $response['result'],
                             'message'  => $response['message'],
                            ], $response['code']);
    }

}
