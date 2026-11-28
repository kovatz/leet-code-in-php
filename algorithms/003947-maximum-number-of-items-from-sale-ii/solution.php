<?php

class Solution {

    /**
     * @param Integer[][] $items
     * @param Integer $budget
     * @return Integer
     */
    function maximumSaleItems(array $items, int $budget): int
    {
        return $this->solve($items, $budget);
    }

    // Alias in case the platform expects the full title as the method name.
    public function maximumNumberOfItems(array $items, int $budget): int {
        return $this->solve($items, $budget);
    }

    private function solve(array $items, int $budget): int {
        $n = count($items);

        $freq = array_fill(0, $n + 1, 0);
        foreach ($items as $item) {
            $freq[$item[0]]++;
        }

        // multiples[f] = number of items whose factor is a multiple of f
        $multiples = array_fill(0, $n + 1, 0);
        for ($f = 1; $f <= $n; ++$f) {
            $count = 0;
            for ($m = $f; $m <= $n; $m += $f) {
                $count += $freq[$m];
            }
            $multiples[$f] = $count;
        }

        $minPrice = PHP_INT_MAX;
        foreach ($items as $item) {
            $minPrice = min($minPrice, $item[1]);
        }

        $limit = 2 * $minPrice;
        $entries = [];

        foreach ($items as $item) {
            [$factor, $price] = $item;

            // Exclude the item itself.
            $gain = $multiples[$factor] - 1;

            // A price-2 marginal copy is useful only if price < 2 * minPrice.
            if ($gain > 0 && $price < $limit) {
                $entries[] = [$price, $gain];
            }
        }

        usort($entries, fn($a, $b) => $a[0] <=> $b[0]);

        $ans = 0;
        $remaining = $budget;

        foreach ($entries as [$price, $gain]) {
            $canBuy = intdiv($remaining, $price);
            $take = min($canBuy, $gain);

            // These copies each give one purchased copy + one free copy.
            $ans += 2 * $take;
            $remaining -= $take * $price;

            if ($take < $gain) {
                break;
            }
        }

        // Remaining budget buys single-value copies from the cheapest item.
        $ans += intdiv($remaining, $minPrice);

        return $ans;
    }
}