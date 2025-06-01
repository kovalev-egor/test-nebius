<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *      schema="Organization",
 *      type="object",
 *      title="Организация",
 *      description="Данные об организации, включая здание, деятельность и координаты",
 *      required={"id", "name"},
 *
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="Уникальный идентификатор организации",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Название организации",
 *          example="Центр медицинской диагностики"
 *      ),
 *      @OA\Property(
 *          property="building_id",
 *          type="integer",
 *          description="ID здания, в котором расположена организация",
 *          example=3
 *      ),
 *      @OA\Property(
 *          property="activity_id",
 *          type="integer",
 *          description="ID вида деятельности организации",
 *          example=7
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Описание или назначение организации",
 *          example="Диагностический центр, предоставляющий услуги МРТ и КТ"
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="float",
 *          description="Географическая широта здания организации",
 *          example=55.751244
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="float",
 *          description="Географическая долгота здания организации",
 *          example=37.618423
 *      )
 *  )
 */
class OrganizationSchema
{

}
