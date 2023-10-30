<?php

namespace App\Contracts\Interfaces\Controllers\Api\V1;

use App\Http\Requests\Api\V1\RegisterRequest;

interface AuthControllerInterface
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     operationId="AuthLogin",
     *     tags={"AUTH"},
     *
     *     summary="User Login",
     *
     *      @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"email","password"},
     *                  @OA\Property(property="email", type="text"),
     *                  @OA\Property(property="password", type="text"),
     *            ),
     *         ),
     *      ),
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
    public function login();

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     operationId="AuthRegister",
     *     tags={"AUTH"},
     *
     *     summary="User Register",
     *
     *      @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"name","email","password"},
     *                  @OA\Property(property="name", type="text"),
     *                  @OA\Property(property="email", type="text"),
     *                  @OA\Property(property="password", type="text"),
     *            ),
     *         ),
     *      ),
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
    public function register(RegisterRequest $request);

    /**
     * @OA\Post(
     *     path="/api/v1/auth/refresh",
     *     operationId="AuthRefresh",
     *     tags={"AUTH"},
     *
     *     summary="Refresh Auth JWT Token",
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
    public function refresh();

    /**
     * @OA\Get(
     *     path="/api/v1/auth/getme",
     *     operationId="GetMe",
     *     tags={"AUTH"},
     *
     *     summary="Get Logged In User Data",
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
    public function getme();

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     operationId="AuthLogout",
     *     tags={"AUTH"},
     *
     *     summary="User Logout",
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
    public function logout();
}
