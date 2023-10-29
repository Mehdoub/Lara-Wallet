<?php

namespace App\Http\Swaggers\Api\V1;

use Illuminate\Http\Request;

class PaymentControllerDoc
{

    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     operationId="PaymentIndex",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment List",
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
    public function index(Request $request)
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/reject",
     *     operationId="PaymentReject",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Reject",
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
    public function reject()
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/verify",
     *     operationId="PaymentVerify",
     *     tags={"PAYMENT"},
     *
     *     summary="Payment Verify",
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
    public function verify()
    {
    }
}
?>
