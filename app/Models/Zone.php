<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Zone extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'zone';

    public static function getExpansionZones(int $expansion): Collection
    {
        return self::where('expansion', '<=', $expansion)
            ->where('min_status', 0)
            ->select('id', 'expansion', 'short_name', 'long_name', 'version', 'zone_exp_multiplier')
            ->orderBy('expansion', 'asc')
            ->orderBy('long_name', 'asc')
            ->get()
            ->groupBy('expansion');
    }

    public static function resolveZone(int $zoneid, ?int $version = null): Builder
    {
        $query = self::where('zoneidnumber', $zoneid);

        if ($version !== null) {
            $query->where('version', $version);
        } else {
            $query->orderBy('version');
        }

        return $query;
    }
}
