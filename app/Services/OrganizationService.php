<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Activity;

class OrganizationService
{
    private function baseRelations(): array
    {
        return ['building', 'phones', 'activities'];
    }

    public function byBuilding(int $buildingId)
    {
        return Organization::where('building_id', $buildingId)
            ->with($this->baseRelations())
            ->get();
    }

    public function byActivity(int $activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $activityIds = $this->getDescendantActivityIds($activity);

        return Organization::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activity_id', $activityIds);
        })->with($this->baseRelations())->get();
    }

    /**
     * @param array $params ['latitude' => float, 'longitude' => float, 'radius' => float]
     */
    public function byArea(array $params)
    {
        $latitude = $params['latitude'];
        $longitude = $params['longitude'];
        $radius = $params['radius'];

        return Organization::whereHas('building', function ($query) use ($latitude, $longitude, $radius) {
            $query->whereRaw(
                "6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                ) <= ?",
                [$latitude, $longitude, $latitude, $radius]
            );
        })->with($this->baseRelations())->get();
    }

    public function show(int $id)
    {
        return Organization::with($this->baseRelations())->findOrFail($id);
    }

    public function byName(string $name)
    {
        return Organization::where('name', 'like', '%' . $name . '%')
            ->with($this->baseRelations())
            ->get();
    }

    private function getDescendantActivityIds(Activity $activity): array
    {
        $ids = [$activity->id];
        $children = $activity->children()->get();

        foreach ($children as $child) {
            if ($this->getActivityDepth($child) <= 3) {
                $ids = array_merge($ids, $this->getDescendantActivityIds($child));
            }
        }

        return $ids;
    }

    private function getActivityDepth(Activity $activity, int $depth = 1): int
    {
        if (!$activity->parent) {
            return $depth;
        }

        return $this->getActivityDepth($activity->parent, $depth + 1);
    }
}
