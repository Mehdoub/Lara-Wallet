<?php

namespace App\Http\Swaggers\Api\V1;

class CurrencyControllerDoc
{
/**
     * @OA\Get(
     *     path="/api/v1/currencies",
     *     operationId="CurrencyIndex",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency List",
     *
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=201, description="Successful operation"),
     *      @OA\Response(response=202, description="Successful operation"),
     *      @OA\Response(response=204, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function index()
    {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/currencies",
     *     operationId="CurrencyStore",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency Create",
     *
     *      @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\Schema(type="object", required={"name"}),
     *         @OA\Property(property="name", type="text"),
     *     ),
     *
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=201, description="Successful operation"),
     *      @OA\Response(response=202, description="Successful operation"),
     *      @OA\Response(response=204, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function store()
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/currencies/{key}/activate",
     *     operationId="CurrencyActivate",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency Activate",
     *
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="currency id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=201, description="Successful operation"),
     *      @OA\Response(response=202, description="Successful operation"),
     *      @OA\Response(response=204, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function activate()
    {
    }
    // TODO use contracts and interfaces

    /**
     * @OA\Patch(
     *     path="/api/v1/currencies/{key}/deactivate",
     *     operationId="CurrencyDeactivate",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency Deactivate",
     *
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="currency id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=201, description="Successful operation"),
     *      @OA\Response(response=202, description="Successful operation"),
     *      @OA\Response(response=204, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function deactivate()
    {
    }
}
