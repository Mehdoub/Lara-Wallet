<?php

namespace App\Contracts\Interfaces\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CreatePaymentRequest;
use App\Models\Payment;

interface PaymentControllerInterface
{

    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     operationId="PaymentIndex",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment List",
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
     *     path="/api/v1/payments",
     *     operationId="PaymentStore",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Create",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"amount","currency_key"},
     *                  @OA\Property(property="amount", type="text"),
     *                  @OA\Property(property="currency_key", type="text"),
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
    public function store(CreatePaymentRequest $request);

    /**
     * @OA\Patch(
     *     path="/api/v1/payments/{payment}/reject",
     *     operationId="PaymentReject",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Reject",
     *
     *      @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         description="payment unique_id",
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
    public function reject(Payment $payment);

    /**
     * @OA\Patch(
     *     path="/api/v1/payments/{payment}/verify",
     *     operationId="PaymentVerify",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Verify",
     *
     *      @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         description="payment unique_id",
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
    public function verify(Payment $payment);

    /**
     * @OA\Get(
     *     path="/api/v1/payments/{payment}",
     *     operationId="PaymentShow",
     *     tags={"PAYMENT"},
     *
     *     summary="Show Payment",
     *
     *      @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         description="payment unique_id",
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
    public function show(Payment $payment);

    /**
     * @OA\Delete(
     *     path="/api/v1/payments/{payment}/destroy",
     *     operationId="PaymentDelete",
     *     tags={"PAYMENT"},
     *
     *     summary="Delete Payment",
     *
     *      @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         description="payment unique_id",
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
    public function destroy(Payment $payment);
}
