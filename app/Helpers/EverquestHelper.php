<?php
use Illuminate\Support\Str;

if (!function_exists('tooltip_uid')) {
    function tooltip_uid(): string
    {
        static $counter = 0;
        return (string) ++$counter;
    }
}

if (!function_exists('eq_race')) {
    function eq_race($id)
    {
        $races = config('everquest.races');
        return $races[$id] ?? 'Unknown';
    }
}

if (!function_exists('eq_class')) {
    function eq_class($id)
    {
        $classes = config('everquest.classes');
        return $classes[$id] ?? 'Unknown';
    }
}

if (!function_exists('eq_language')) {
    function eq_language($id)
    {
        $lang = config('everquest.languages');
        return $lang[$id] ?? 'Unknown';
    }
}

if (!function_exists('eq_deity')) {
    function eq_deity($id)
    {
        $deity = config('everquest.deity');
        return $deity[$id] ?? 'Unknown';
    }
}

if (!function_exists('item_bagtypes')) {
    function item_bagtypes($id) {
        $bagtypes = config('everquest.bagtypes');
        return $bagtypes[$id] ?? 'Unknown';
    }
}

if (!function_exists('eq_skills')) {
    function eq_skills() {
        return config('everquest.skills');
    }
}

if (!function_exists('eq_aa_types')) {
    function eq_aa_types() {
        return config('everquest.aa_types');
    }
}

if (!function_exists('item_icon')) {
    function item_icon($icon_id, $size = 40) {
        //global $icons_dir, $icons_url;
        if (file_exists(public_path('img/icons/' . $icon_id . '.png'))) {
            return '<img src="' . asset('img/icons/' . $icon_id . '.png') . '" class="w-10 h-auto ml-4" />';
        }

        return;
    }
}

if (!function_exists('seconds_to_human')) {
    function seconds_to_human($seconds): string
    {
        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        $parts = [];
        if ($days > 0) {
            $parts[] = "{$days}d";
        }
        if ($hours > 0 || $days > 0) {
            $parts[] = "{$hours}h";
        }
        $parts[] = "{$minutes}m";

        return implode(' ', $parts);
    }
}

if (!function_exists('sign')) {
    function sign($val) {
        return ($val > 0 ? '+' : '') . $val;
    }
}

if (!function_exists('displaySkills')) {
    function displaySkills($character_skills, $languages) {
        $skills = config('everquest.skills');
        $lang = $languages->toArray();

        $output = '<div class="border-b border-slate-500 dark:border-neutral-700">
            <nav class="flex space-x-1" aria-label="Tabs" role="tablist">';
        $tabIndex = 1;
        foreach ($skills as $category => $skillList) {
            $output .= '<button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-slate-800 text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500' . ($tabIndex === 1 ? ' active' : '') . '" data-hs-tab="#tabs-with-underline-' . $tabIndex . '" aria-controls="tabs-with-underline-' . $tabIndex . '" role="tab">' . ucfirst($category) . '</button>';
            $tabIndex++;
        }
        $output .= '</nav></div><div class="mt-3">';

        $tabIndex = 1;
        foreach ($skills as $category => $skillList) {
            $output .= '<div id="tabs-with-underline-' . $tabIndex . '" role="tabpanel" aria-labelledby="tabs-with-underline-item-' . $tabIndex . '"' . ($tabIndex !== 1 ? ' class="hidden"' : '') . '>';

            $skillIndex = 0;
            foreach ($skillList as $id => $name) {
                if ($category == 'languages') {
                    $value = isset($languages[$id]) ? $languages[$id]['value'] : 0;
                } else {
                    $value = isset($character_skills[$id]) ? $character_skills[$id] : 0;
                }

                $output .= '<div class="flex justify-between w-full p-1.5 pl-2 pr-2' . ($skillIndex % 2 == 0 ? ' bg-slate-800' : '') . '">
                <span class="w-full text-left">' . $name . '</span>
                    <span class="text-right">' . $value . '</span></div>';

                $skillIndex++;
            }
            $output .= '</div>';
            $tabIndex++;
        }
        $output .= '</div>';
        return $output;
    }
}

if (!function_exists('get_class_usable_string')) {
    function get_class_usable_string($val): string {
        $classes = config('everquest.classes_short');
        $result = [];

        // Special case for "ALL"
        if (isset($classes[65535]) && $val == 65535) {
            return $classes[65535];
        }

        foreach ($classes as $key => $short) {
            if (($val & $key) === $key && $key != 65535) {
                $result[] = $short;
            }
        }

        return implode(' ', $result);
    }
}

if (!function_exists('get_race_usable_string')) {
    function get_race_usable_string($val): string {
        $races = config('everquest.races_short');
        $result = [];

        // Special case for "ALL"
        if (isset($races[65535]) && $val == 65535) {
            return $races[65535];
        }

        foreach ($races as $key => $short) {
            if (($val & $key) === $key && $key != 65535) {
                $result[] = $short;
            }
        }

        return implode(' ', $result);
    }
}

if (!function_exists('get_deity_usable_string')) {
    function get_deity_usable_string($val): string {
        $deities = config('everquest.deities_short');
        $result = [];

        foreach ($deities as $bit => $name) {
            if (($val & $bit) === $bit) {
                $result[] = $name;
            }
        }

        return implode(', ', $result);
    }
}

if (!function_exists('get_slots_string')) {
    function get_slots_string($val): string {
        $slots = config('everquest.slots');
        $result = [];

        foreach ($slots as $bit => $name) {
            if (($val & $bit) === $bit) {
                $result[] = $name;
            }
        }

        return implode(', ', $result);
    }
}

if (!function_exists('item_aug_data')) {
    function item_aug_data($item) {
        $augdb = config('everquest.db_aug_restrict');
        $html = '';

        if (($item->itemtype ?? 0) == 54) {
            $html .= '<div class="mt-6 text-sm">';
            // Handle Augmentation Slot Types
            if (($item->augtype ?? 0) > 0) {
                $augType = $item->augtype;
                $augSlots = [];

                for ($i = 1, $bit = 1; $i <= 24; $i++, $bit *= 2) {
                    if ($bit <= $augType && ($augType & $bit)) {
                        $augSlots[] = $i;
                    }
                }

                $slotsText = implode(', ', $augSlots);
                $html .= "<p><strong>Aug Slot Type:</strong> {$slotsText}</p>";
            } else {
                $html .= "<p><strong>Aug Slot Type:</strong> All Slots</p>";
            }

            // Handle Augmentation Restriction
            $augRestrict = $item->augrestrict ?? 0;

            if ($augRestrict > 0) {
                if ($augRestrict > 12 || !isset($augdb[$augRestrict])) {
                    $html .= "<p><strong>Aug Restriction:</strong> Unknown Type</p>";
                } else {
                    $restriction = $augdb[$augRestrict];
                    $html .= "<p><strong>Aug Restriction:</strong> {$restriction}</p>";
                }
            }
            $html .= '</div>';
        }

        return $html;
    }
}

if (!function_exists('calculate_item_price')) {
    function calculate_item_price($price) {
        $platinum = intdiv($price, 1000);
        $price -= $platinum * 1000;

        $gold = intdiv($price, 100);
        $price -= $gold * 100;

        $silver = intdiv($price, 10);
        $price -= $silver * 10;

        $copper = $price;

        return [
            'platinum' => $platinum,
            'gold'     => $gold,
            'silver'   => $silver,
            'copper'   => $copper,
        ];
    }
}

if (!function_exists('get_food_drink_desc')) {
    function get_food_drink_desc(int $key, int $type) {
        if ($key <= 0) {
            return null;
        }

        if ($type == 14) {
            $str = config('everquest.food_types');
        } elseif($type == 15) {
            $str = config('everquest.drink_types');
        }

        if ($key >= 1 && $key <= 5) {
            return $str[0];
        } elseif ($key <= 20) {
            return $str[1];
        } elseif ($key <= 30) {
            return $str[2];
        } elseif ($key <= 40) {
            return $str[3];
        } elseif ($key <= 50) {
            return $str[4];
        } elseif ($key <= 60) {
            return $str[5];
        } else {
            return $str[6];
        }
    }
}

if (!function_exists('price')) {
    function price(int $price): string
    {
        if ($price <= 0) {
            return '0 cp';
        }

        $p = intdiv($price, 1000);
        $price %= 1000;

        $g = intdiv($price, 100);
        $price %= 100;

        $s = intdiv($price, 10);
        $c = $price % 10;

        $parts = [];

        if ($p > 0) {
            $parts[] = "{$p} pp";
        }
        if ($g > 0) {
            $parts[] = "{$g} gp";
        }
        if ($s > 0) {
            $parts[] = "{$s} sp";
        }
        if ($c > 0 || empty($parts)) {
            $parts[] = "{$c} cp";
        }

        return implode(' ', $parts);
    }
}

if (!function_exists('ucRomanNumeral')) {
    function ucRomanNumeral(string $string): string
    {
        return preg_replace_callback('/\b(?=[mdclxvi])([mdclxvi]+)\b/i', function ($matches) {
            $possibleRoman = strtoupper($matches[1]);

            $valid = '/^(M{0,4})(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/';

            if (preg_match($valid, $possibleRoman)) {
                return $possibleRoman;
            }

            return $matches[0];
        }, $string);
    }
}

if (!function_exists('faction_to_string')) {
    function faction_to_string($value)
    {
        if($value >=  1101) return 'Ally';
        if($value >=   701 && $value <= 1100) return 'Warmly';
        if($value >=   401 && $value <=  700) return 'Kindly';
        if($value >=   101 && $value <=  400) return 'Amiable';
        if($value >=     0 && $value <=  100) return 'Indifferent';
        if($value >=  -100 && $value <=   -1) return 'Apprehensive';
        if($value >=  -700 && $value <= -101) return 'Dubious';
        if($value >=  -999 && $value <= -701) return 'Threatenly';
        if($value <= -1000) return 'Scowls';

        return 'Indifferent';
    }
}

if (!function_exists('factionValue')) {
    function factionValue(int $value): string
    {
        return match (true) {
            $value >= 1100 => '<span class="text-blue-600">Ally</span>',
            $value >= 750  => '<span class="text-emerald-600">Warmly</span>',
            $value >= 500  => '<span class="text-green-500">Kindly</span>',
            $value >= 100  => '<span class="text-lime-500">Amiable</span>',
            $value >= 0    => '<span class="text-slate-500">Indifferent</span>',
            $value >= -100 => '<span class="text-amber-400">Apprehensive</span>',
            $value >= -500 => '<span class="text-orange-500">Dubious</span>',
            $value >= -750 => '<span class="text-red-500">Threatening</span>',
            $value < -750  => '<span class="text-rose-700">Scowls</span>',
            default        => 'UNK',
        };
    }
}

if (!function_exists('characterFlagSteps')) {
    function characterFlagSteps($character, $step)
    {
        $keyValue = str_replace('{character_id}', $character->id, $step['value']);

        $data = (!empty($step['type']) && $step['type'] === 'db')
            ? $character->dataBucketsByKey->firstWhere('key', $keyValue)
            : $character->hasQuestGlobal($keyValue);

        $qgValue = $data['value'] ?? null;
        $requiredValues = is_array($step['key']) ? $step['key'] : [$step['key']];

        foreach ($requiredValues as $required) {
            if (is_numeric($required) && is_numeric($qgValue) && ((int)$qgValue & (int)$required) <= (int)$required) {
                return true;
            }

            if ((string)$qgValue === (string)$required) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('sortLink')) {
    function sortLink($field, $label) {
        $currentSort = request('sort');
        $currentDirection = request('direction', 'asc');
        $isActive = $currentSort === $field;
        $nextDirection = $isActive && $currentDirection === 'asc' ? 'desc' : 'asc';
        $arrow = $isActive ? ($currentDirection === 'asc' ? '↑' : '↓') : '';

        $url = request()->fullUrlWithQuery([
            'sort' => $field,
            'direction' => $nextDirection,
            'page' => 1,
        ]);

        return '<a href="' . $url . '" class="link-accent link-hover">' . e($label) . ' ' . $arrow . '</a>';
    }
}
