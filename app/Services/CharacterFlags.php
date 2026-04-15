<?php

namespace App\Services;

use App\Models\CharacterData;
use Illuminate\Support\Collection;

class CharacterFlags
{
    public function __construct(
        protected CharacterData $character
    ) {}

    public function hasQuestFlag(string $name, int|string|array $expected = 1): bool
    {
        $value = $this->character->questGlobals->firstWhere('name', $name)?->value;
        return $this->compareValue($value, $expected);
    }

    public function hasZoneFlag(int $zoneId): bool
    {
        return $this->character->zoneFlags->contains('zoneid', $zoneId);
    }

    public function checkDataBucket(string $key, string|array $expected): bool
    {
        $buckets = $this->character->data_buckets_by_key;
        $value = $buckets[$key]->value ?? null;

        $expected = array_map('strval', (array) $expected);
        return in_array((string) $value, $expected, true);
    }

    public function matchPreRequirement(array $check): bool
    {
        $type = $check['type'] ?? 'db';

        if ($type === 'db') {
            $key = str_replace('{character_id}', $this->character->id, $check['key'] ?? '');
            $value = $this->character->data_buckets_by_key[$key]->value ?? null;

            if (isset($check['match'])) {
                $expected = array_map('strval', (array) $check['match']);
                return in_array((string) $value, $expected, true);
            }

            return intval($value) >= ($check['min'] ?? 1);
        }

        if ($type === 'qg') {
            $key = $check['key'] ?? '';
            $min = intval($check['min'] ?? 1);
            return $this->hasQuestFlag($key, $min);
        }

        if ($type === 'zf') {
            return $this->hasZoneFlag($check['zone_id'] ?? $check['key']);
        }

        return false;
    }

    protected function compareValue(mixed $value, int|string|array $expected): bool
    {
        if (is_null($value)) {
            return false;
        }

        if (is_array($expected)) {
            return in_array($value, $expected, true);
        }

        return intval($value) >= intval($expected);
    }

    public function getDescriptionKey(array $pre): string
    {
        $charId = $this->character->id;
        $rawKey = str_replace('{character_id}-', '', $pre['key'] ?? '');
        //$baseKey = preg_replace('/^\d+-/', '', $rawKey);

        if (isset($pre['match']) && is_array($pre['match'])) {
            $value = $this->character->data_buckets_by_key[$rawKey]->value ?? null;
            $suffix = in_array($value, $pre['match'], true) ? $value : $pre['match'][0];
        } else {
            $suffix = $pre['min'] ?? '1';
        }

        return "{$rawKey}_{$suffix}";
    }

    public function analyzeStep(array $step): array
    {
        $stepPre = $step['pre'] ?? [];
        $allMatched = true;
        $matchDetails = [];

        foreach ($stepPre as $pre) {
            $matched = $this->matchPreRequirement($pre);
            $optional = $pre['optional'] ?? false;

            $matchDetails[] = [
                'matched' => $matched,
                'optional' => $optional,
                'description_key' => $this->getDescriptionKey($pre),
            ];

            if (!$matched && !$optional) {
                $allMatched = false;
            }
        }

        $hasZoneFlag = isset($step['zone_flag']) && $this->hasZoneFlag($step['zone_flag']);
        $isComplete = $hasZoneFlag || $allMatched;

        return compact('matchDetails', 'allMatched', 'hasZoneFlag', 'isComplete');
    }
}
