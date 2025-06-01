<?php

namespace App\Http\Controllers;

use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(protected OrganizationService $organizationService)
    {
    }

    /**
     * @OA\Get(
     *      path="/api/organizations/building/{buildingId}",
     *      tags={"Организации"},
     *      summary="Организации по зданию",
     *      description="Получить список организаций, находящихся в заданном здании",
     *      @OA\Parameter(
     *          name="buildingId",
     *          in="path",
     *          required=true,
     *          description="Идентификатор здания",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Список организаций",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *      ),
     *      @OA\Response(response=401, description="Неавторизован"),
     *      security={{"ApiKeyAuth":{}}}
     *  )
     */
    public function byBuilding($buildingId): JsonResponse
    {
        return response()->json($this->organizationService->byBuilding($buildingId));
    }

    /**
     * @OA\Get(
     *      path="/api/organizations/activity/{activityId}",
     *      tags={"Организации"},
     *      summary="Организации по сфере деятельности",
     *      description="Возвращает организации, связанные с заданной сферой деятельности или её дочерними",
     *      @OA\Parameter(
     *          name="activityId",
     *          in="path",
     *          required=true,
     *          description="Идентификатор деятельности",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Список организаций", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))),
     *      @OA\Response(response=401, description="Неавторизован"),
     *      @OA\Response(response=404, description="Сфера деятельности не найдена"),
     *      security={{"ApiKeyAuth":{}}}
     *  )
     */
    public function byActivity($activityId): JsonResponse
    {
        return response()->json($this->organizationService->byActivity($activityId));
    }

    /**
     * @OA\Get(
     *      path="/api/organizations/area",
     *      tags={"Организации"},
     *      summary="Организации по геолокации",
     *      description="Находит организации в радиусе от заданной географической точки",
     *      @OA\Parameter(name="latitude", in="query", required=true, description="Широта точки центра", @OA\Schema(type="number", format="float")),
     *      @OA\Parameter(name="longitude", in="query", required=true, description="Долгота точки центра", @OA\Schema(type="number", format="float")),
     *      @OA\Parameter(name="radius", in="query", required=true, description="Радиус (в километрах)", @OA\Schema(type="number", format="float", minimum=0)),
     *      @OA\Response(response=200, description="Список организаций", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))),
     *      @OA\Response(response=401, description="Неавторизован"),
     *      @OA\Response(response=422, description="Ошибка в параметрах запроса"),
     *      security={{"ApiKeyAuth":{}}}
     *  )
     */
    public function byArea(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:0',
        ]);

        return response()->json($this->organizationService->byArea($validated));
    }

    /**
     * @OA\Get(
     *      path="/api/organizations/{id}",
     *      tags={"Организации"},
     *      summary="Информация об организации",
     *      description="Получить полные данные об одной организации по её ID",
     *      @OA\Parameter(name="id", in="path", required=true, description="ID организации", @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Информация об организации", @OA\JsonContent(ref="#/components/schemas/Organization")),
     *      @OA\Response(response=401, description="Неавторизован"),
     *      @OA\Response(response=404, description="Организация не найдена"),
     *      security={{"ApiKeyAuth":{}}}
     *  )
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->organizationService->show($id));
    }

    /**
     * @OA\Get(
     *      path="/api/organizations/search",
     *      tags={"Организации"},
     *      summary="Поиск организаций по названию",
     *      description="Позволяет искать организации по названию или его части",
     *      @OA\Parameter(name="name", in="query", required=true, description="Название (или его часть)", @OA\Schema(type="string")),
     *      @OA\Response(response=200, description="Список организаций", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))),
     *      @OA\Response(response=401, description="Неавторизован"),
     *      @OA\Response(response=422, description="Неверные параметры запроса"),
     *      security={{"ApiKeyAuth":{}}}
     *  )
     */
    public function byName(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        return response()->json($this->organizationService->byName($validated));
    }
}
