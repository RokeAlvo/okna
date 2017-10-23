<?php
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