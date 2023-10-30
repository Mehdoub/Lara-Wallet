<?php

namespace App\Contracts\Interfaces\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CurrencyStoreRequest;
use App\Models\Currency;

interface CurrencyControllerInterface
{
/**
     * @OA\Get(
     *     path="/api/v1/currencies",
     *     operationId="CurrencyIndex",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency List",
     *
     *      security={{"bearerAuth":{}}},
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
    public function index();

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
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"name","iso_code","symbol","key"},
     *                  @OA\Property(property="name", type="text"),
     *                  @OA\Property(property="iso_code", type="text"),
     *                  @OA\Property(property="symbol", type="text"),
     *                  @OA\Property(property="key", type="text"),
     *            ),
     *         ),
     *      ),
     *
     *      security={{"bearerAuth":{}}},
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
    public function store(CurrencyStoreRequest $request);

    /**
     * @OA\Patch(
     *     path="/api/v1/currencies/{key}/activate",
     *     operationId="CurrencyActivate",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency Activate",
     *
     *      @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="currency key",
     *         required=true,
     *         example="1",
     *         @OA\Schema(type="string")
     *     ),
     *
     *      security={{"bearerAuth":{}}},
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
    public function activate(Currency $currency);

    /**
     * @OA\Patch(
     *     path="/api/v1/currencies/{key}/deactivate",
     *     operationId="CurrencyDeactivate",
     *     tags={"CURRENCY"},
     *
     *     summary="Currency Deactivate",
     *
     *      @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="currency key",
     *         required=true,
     *         example="1",
     *         @OA\Schema(type="string")
     *     ),
     *
     *      security={{"bearerAuth":{}}},
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
    public function deactivate(Currency $currency);
}
