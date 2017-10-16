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
        $ranges[] = ($rStart == $rEnd)
            ? $rStart
            : (($rEnd == $rStart + 1)
                ? ($rStart . ',' . $rEnd)
                : ($rStart . '-' . $rEnd));
    }
    return implode(',', $ranges);
}