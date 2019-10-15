<?php
use App\Helpers\SplitTesting;

function getRanges($nums)
{
    $nums = array_unique($nums);
    sort($nums);
    $ranges = [];
    for ($i = 0, $len = count($nums); $i < $len; $i++) {
        $rStart = $nums[$i];
        $rEnd = $rStart;
        while (isset($nums[$i + 1]) && $nums[$i + 1] - $nums[$i] == 1) {
            $rEnd = $nums[++$i];
        }
        if ($rStart == $rEnd) {
            $ranges[] = $rStart;
        } elseif ($rEnd == $rStart + 1) {
            $ranges[] = $rStart;
            $ranges[] = $rEnd;
        } else {
            $ranges[] = $rStart . '-' . $rEnd;
        }
        /*$ranges[] = ($rStart == $rEnd)
            ? $rStart
            : (($rEnd == $rStart + 1)
                ? ($rStart . ',' . $rEnd)
                : ($rStart . '-' . $rEnd));*/
    }
    return $ranges;
}

function number($n, $titles)
{
    $cases = array(2, 0, 1, 1, 1, 2);
    return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
}

function getUrlPathFirstPart($shortName = false)
{
    $url = url()->current();
    $urlParts = parse_url($url);
    if ($shortName) {
        $city = isset($urlParts['path']) ? implode('/', array_slice(explode('/', $urlParts['path']), 1, 1)) : '';
        \Illuminate\Support\Facades\Log::debug("city in functions is: $city");
        if(empty(\Config::get('database.connections')[$city])) {
            return 'nsk';
        }
        return \Config::get('database.connections')[$city]['shortName'];
    } else
        return isset($urlParts['path']) ? implode('/', array_slice(explode('/', $urlParts['path']), 1, 1)) : '';
    //return 'nsk/';
}

function getRequestStoreRoute()
{
    return app()->environment('production')
      ? 'http://' . getUrlPathFirstPart(true) . '.smartcrm.pro/api/requests'
      : 'http://' . getUrlPathFirstPart(true) . '.crm.localhost/api/requests';
    //return 'http://127.0.0.1/crm/public/api/requests';
}

function getMangoWidgetId()
{
    if(\Schema::hasTable('config')) {
        return \DB::table('config')->where('code_name', 'mango_widget')->pluck('value')->first();
    }
    return null;
}

function isBuilt(\Carbon\Carbon $now, $year, $quarter)
{
    $now = now();
    return $now->year > $year || ($now->year == $year && $now->quarter > $quarter);
}

function getQuarter($quarter)
{
    return in_array($quarter, [1, 2, 3, 4]) ? QUARTERS['short'][$quarter] : '';
}

function getCompletionDeadlineFormatted($deadline)
{
    if($deadline === -1) {
        return 'Сдан';
    }
    if(!preg_match('/[\d]{5}/', $deadline)) {
        return false;
    }

    $completionYear = substr($deadline, 0, 4);
    $completionDecade = substr($deadline, 4, 1);
    return (!isBuilt(now(), $completionYear, $completionDecade))
        ? getQuarter($completionDecade) . ' ' . $completionYear
        : 'Сдан';
}

function moveKeyToValue(array $array)
{
    foreach ($array as $key => &$item) {
        $item = ['key' => $key, 'value' => $item];
    }
    return array_values($array);
}

function runSplitTesting(array $methods = []): SplitTesting
{
    $splitTesting = SplitTesting::getInstance();
    foreach($methods as $method) {
        $splitTesting->{$method}();
    }
    return $splitTesting;
}