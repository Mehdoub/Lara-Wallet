<?php

namespace App\Contracts\Interfaces\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CreditTransferRequest;

interface CreditTransferControllerInterface
{
    /**
     * @OA\Post(
     *     path="/api/v1/credit-transfer",
     *     operationId="CreditTransfer",
     *     tags={"CREADIT-TRANSFER"},
     *
     *     summary="Transfer Credit Between Users",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"amount","currency_key","from_user_id","to_user_id"},
     *                  @OA\Property(property="amount", type="text"),
     *                  @OA\Property(property="currency_key", type="text"),
     *                  @OA\Property(property="from_user_id", type="integer"),
     *                  @OA\Property(property="to_user_id", type="integer"),
     *            ),
     *        ),
     *    ),
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
    public function transfer(CreditTransferRequest $request);
}
