<?php

class Solution {

    /**
     * @param Integer[][] $intervals
     * @return Integer[]
     */
    function maximumWeight(array $intervals): array
    {
        $n = count($intervals);

        // Create array with original indices and sort by end time
        $sortedIntervals = [];
        for ($i = 0; $i < $n; $i++) {
            $sortedIntervals[] = [$intervals[$i][0], $intervals[$i][1], $intervals[$i][2], $i];
        }

        // Sort by end time, then by start time, then by original index for consistency
        usort($sortedIntervals, function($a, $b) {
            if ($a[1] != $b[1]) return $a[1] - $b[1];
            if ($a[0] != $b[0]) return $a[0] - $b[0];
            return $a[3] - $b[3];
        });

        // Precompute previous compatible interval for each interval
        $prev = array_fill(0, $n, -1);
        for ($i = 0; $i < $n; $i++) {
            $left = 0;
            $right = $i - 1;
            $best = -1;

            // Find rightmost interval j where end_time < start_time of interval i
            while ($left <= $right) {
                $mid = intval(($left + $right) / 2);
                if ($sortedIntervals[$mid][1] < $sortedIntervals[$i][0]) {
                    $best = $mid;
                    $left = $mid + 1;
                } else {
                    $right = $mid - 1;
                }
            }
            $prev[$i] = $best;
        }

        // DP tables: dp[k][i] = max score using at most k intervals from first i intervals
        // We also need to track the chosen indices for lexicographically smallest
        $dp = array_fill(0, 5, array_fill(0, $n + 1, 0));
        $choice = array_fill(0, 5, array_fill(0, $n + 1, null));

        // Initialize choice arrays
        for ($k = 0; $k <= 4; $k++) {
            for ($i = 0; $i <= $n; $i++) {
                $choice[$k][$i] = [];
            }
        }

        for ($k = 1; $k <= 4; $k++) {
            for ($i = 1; $i <= $n; $i++) {
                $idx = $i - 1;

                // Option 1: Don't take interval i-1
                $dp[$k][$i] = $dp[$k][$i - 1];
                $choice[$k][$i] = $choice[$k][$i - 1];

                // Option 2: Take interval i-1
                $prevIdx = $prev[$idx];
                $prevDP = $prevIdx >= 0 ? $dp[$k - 1][$prevIdx + 1] : 0;
                $prevChoice = $prevIdx >= 0 ? $choice[$k - 1][$prevIdx + 1] : [];

                $takeScore = $sortedIntervals[$idx][2] + $prevDP;
                $takeChoice = array_merge($prevChoice, [$sortedIntervals[$idx][3]]);
                sort($takeChoice);

                // Compare: take if better score, or same score but lexicographically smaller
                if ($takeScore > $dp[$k][$i]) {
                    $dp[$k][$i] = $takeScore;
                    $choice[$k][$i] = $takeChoice;
                } elseif ($takeScore == $dp[$k][$i]) {
                    if ($this->isLexicographicallySmaller($takeChoice, $choice[$k][$i])) {
                        $choice[$k][$i] = $takeChoice;
                    }
                }
            }
        }

        // Find best result among all k from 1 to 4
        $bestScore = 0;
        $bestChoice = [];

        for ($k = 1; $k <= 4; $k++) {
            if ($dp[$k][$n] > $bestScore) {
                $bestScore = $dp[$k][$n];
                $bestChoice = $choice[$k][$n];
            } elseif ($dp[$k][$n] == $bestScore && $dp[$k][$n] > 0) {
                if ($this->isLexicographicallySmaller($choice[$k][$n], $bestChoice)) {
                    $bestChoice = $choice[$k][$n];
                }
            }
        }

        return $bestChoice;
    }

    /**
     * Compare two arrays lexicographically
     *
     * @param $a
     * @param $b
     * @return bool
     */
    private function isLexicographicallySmaller($a, $b): bool
    {
        $minLen = min(count($a), count($b));
        for ($i = 0; $i < $minLen; $i++) {
            if ($a[$i] != $b[$i]) {
                return $a[$i] < $b[$i];
            }
        }
        return count($a) < count($b);
    }
}