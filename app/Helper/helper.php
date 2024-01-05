<?php

use App\Models\PlanFeatuers;
use Illuminate\Support\Facades\Auth;

if (! function_exists('serialNumber')) {
    function serialNumber($data, $loop)
    {
        return $data->firstItem() + $loop->index;
    }
}

if (! function_exists('error_exception')) {
    function error_exception($e)
    {
        return response()->json([
            'message' => $e->getMessage(),
            'success' => false,
            'data' => [],
        ], 400);
    }
}

if (! function_exists('getStatus')) {
    function getStatus(): array
    {
        return [
            [
                'label' => 'Active',
                'value' => 1,
            ],
            [
                'label' => 'Inactive',
                'value' => 2,
            ],
        ];
    }
}

if (! function_exists('formatWithComma')) {
    function formatWithComma($number, $limit = null): string
    {
        return number_format($number, $limit, '.', ',');
    }
}

if (! function_exists('numberToWord')) {
    function numberToWord($num = '')
    {
        $num = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words = [];

            $num = str_replace([',', ' '], '', trim($num));

            $list1 = [
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen',
            ];

            $list2 = [
                '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred',
            ];

            $list3 = [
                '', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion',
            ];

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00'.$num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = (int) ($num_part / 100);
                $hundreds = ($hundreds ? ' '.$list1[$hundreds].' Hundred'.($hundreds == 1 ? '' : 's').' ' : '');
                $tens = (int) ($num_part % 100);
                $singles = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' '.$list1[$tens].' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' '.$list2[$tens].' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' '.$list1[$singles].' ';
                }
                $words[] = $hundreds.$tens.$singles.(($levels && (int) ($num_part)) ? ' '.$list3[$levels].' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words = implode(', ', $words);

            $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words = str_replace(',', ' and', $words);
            }

            return $words;
        } elseif (! ((int) $num)) {
            return 'Zero';
        }

        return '';
    }
}
if (! function_exists('hasExceededQuota')) {
    function hasExceededQuota($model)
    {
        $user = Auth::user();
        if (! $user || ! $user->pharmacy || ! $user->pharmacy->expire_date) {
            return false;
        }
        $features = PlanFeatuers::where('plan_id', $user->pharmacy->plan_id)
            ->where('model', $model)
            ->first();
        if ($features) {
            $quota = $features->quote;
            if ($model == 'App\Models\User') {
                $modelCount = $model::where('pharmacy_id', $user->pharmacy->id)->count();
            } else {
                $modelCount = $model::count();
            }

            return $modelCount >= $quota;
        }

        return false;
    }
}
