3947\. Maximum Number of Items From Sale II

**Difficulty:** Medium

**Topics:** `Staff`, `Array`, `Greedy`, `Sorting`, `Heap (Priority Queue)`, `Weekly Contest 504`

You are given a 2D integer array `items`, where `items[i] = [factorᵢ, priceᵢ]` represents the `iᵗʰ` item. You are also given an integer `budget`.

There are unlimited copies of each item available for purchase. You may buy any number of copies of any items such that the total cost of the purchased copies is at most `budget`.

After buying items, you may receive free copies according to the following rules:

- Each purchased copy of item `i` can give you **at most one** free copy of another item `j`.
- The free item must satisfy `i != j` and `factorᵢ` divides `factorⱼ`.
- For each ordered pair `(i, j)`, you can receive a free copy of item `j` from purchases of item `i` **at most once**, regardless of how many copies of item `i` you buy.
- The same item `j` can be received multiple times for free if it is received from purchases of different item types.

Return the **maximum total number of item copies** you can obtain, including both purchased copies and free copies, while spending at most `budget` on purchased items.

**Example 1:**

- **Input:** items = [[1,6],[2,4],[3,5]], budget = 19
- **Output:** 5
- **Explanation:**
  - You can buy 2 copies of item 0 and 1 copy of item 1 for a total cost of `2 * 6 + 4 = 16`, which is not greater than `budget = 19`.
  - One purchased copy of item 0 gives 1 free copy of item 1, because `factor₀ = 1` divides `factor₁ = 2`.
  - The other purchased copy of item 0 gives 1 free copy of item 2, because `factor₀ = 1` divides `factor₂ = 3`.
  - You leave with 3 purchased copies and 2 free copies, for a total of 5 item copies.


**Example 2:**

- **Input:** items = [[2,8],[1,10],[6,6],[4,12],[5,20],[5,17]], budget = 35
- **Output:** 7
- **Explanation:**
  - You can buy 2 copies of item 0, 1 copy of item 1, and 1 copy of item 2 for a total cost of `2 * 8 + 10 + 6 = 32`, which is not greater than `budget = 35`.
  - One purchased copy of item 0 gives 1 free copy of item 2, because `factor₀ = 2` divides `factor₂ = 6`.
  - The other purchased copy of item 0 gives 1 free copy of item 3, because `factor₀ = 2` divides `factor₃ = 4`.
  - The purchased copy of item 1 gives 1 free copy of item 2, because `factor₁ = 1` divides `factor₂ = 6`.
  - Buying item 2 gives no free copy, because `factor₂ = 6` does not divide the factor of any other item.
  - You leave with 4 purchased copies and 3 free copies, for a total of 7 item copies.
    **Example 3:**

- **Input:** items = [[1,5]], budget = 12
- **Output:** 2

**Example 4:**

- **Input:** items = [[1,5]], budget = 4
- **Output:** 0

**Example 5:**

- **Input:** items = [[1,1],[1,100]], budget = 1
- **Output:** 2

**Example 6:**

- **Input:** items = [[2,3],[2,3]], budget = 3
- **Output:** 2

**Example 7:**

- **Input:** items = [[1,6],[2,100],[3,100]], budget = 18
- **Output:** 5

**Example 8:**

- **Input:** items = [[1,5],[2,10]], budget = 20
- **Output:** 4


**Constraints:**

- `1 <= items.length <= 10⁵`
- `items[i] = [factorᵢ, priceᵢ]`
- `1 <= factorᵢ <= items.length`
- `1 <= pricei <= 10⁹`
- `1 <= budget <= 10⁹`


**Hint:**

1. For each item `i`, compute `gain[i]` = number of other items `j` such that `factor[i]` divides `factor[j]`. This can be done by counting factors and iterating over multiples.
2. If you buy `c` copies of item `i`, it contributes `c + min(c, gain[i])` total copies, because only the first `gain[i]` purchased copies can be matched to distinct free items.
3. View purchases as marginal units: for item `i`, the first `gain[i]` copies have value `2` each, and all later copies have value `1` each.
4. Since extra value-1 copies should always be bought from the cheapest item, the main task is to choose the cheapest useful value-2 marginal units. Sort item types by price and process their `gain[i]` boosted copies in batches rather than expanding them one by one.


**Solution:**

We compute the maximum free-copy gain for each item, split its marginal copies into “double-value” copies and “single-value” copies, greedily buy the cheapest double-value copies first, and then spend any remaining budget on the globally cheapest single-value copies. This matches the provided PHP solution and runs in `O(n log n)` time.

## Approach

- For each factor `f`, count how many items have a factor multiple of `f` using a harmonic-loop over multiples.
- For an item with factor `f`, its free-copy gain is:
  - `gain = multiples[f] - 1`
  - The `-1` excludes the item itself.
- If we buy `c` copies of item `i`, the total contribution is:
  - `c + min(c, gain[i])`
  - Therefore the first `gain[i]` copies are worth `2` total copies each: `1` purchased + `1` free.
  - Any additional copies are worth `1` total copy each.
- Let `minPrice` be the cheapest item price.
  - All extra “value 1” copies should be bought from the cheapest item.
  - A “value 2” copy with price `p` is useful only if `p < 2 * minPrice`; if `p == 2 * minPrice`, it is equivalent to buying two cheapest value-1 copies.
- Sort useful value-2 entries by price.
- Greedily buy value-2 copies in batches:
  - For each item, buy up to `gain[i]` copies while budget allows.
  - Stop if the current batch cannot be fully exhausted, because remaining budget is less than the current price and later prices are no smaller.
- Finally, use remaining budget to buy value-1 copies from the cheapest item.

Let's implement this solution in PHP: **[3947. Maximum Number of Items From Sale II](https://github.com/mah-shamim/leet-code-in-php/tree/main/algorithms/003947-maximum-number-of-items-from-sale-ii/solution.php)**

```php
<?php
/**
 * @param Integer[][] $items
 * @param Integer $budget
 * @return Integer
 */
function maximumSaleItems(array $items, int $budget): int
{
    ...
    ...
    ...
    /**
     * go to ./solution.php
     */
}

// Alias in case the platform expects the full title as the method name.
function maximumNumberOfItems(array $items, int $budget): int {
    ...
    ...
    ...
    /**
     * go to ./solution.php
     */
}

function solve(array $items, int $budget): int {
    ...
    ...
    ...
    /**
     * go to ./solution.php
     */
}

// Test cases
echo maximumSaleItems([[1,6],[2,4],[3,5]], 19) . "\n";                                 // Output: 5
echo maximumSaleItems([[2,8],[1,10],[6,6],[4,12],[5,20],[5,17]], 35) . "\n";           // Output: 7
echo maximumSaleItems([[1,5]], 12) . "\n";                                             // Output: 2
echo maximumSaleItems([[1,5]], 4) . "\n";                                              // Output: 0
echo maximumSaleItems([[1,1],[1,100]], 1) . "\n";                                      // Output: 2
echo maximumSaleItems([[2,3],[2,3]], 3) . "\n";                                        // Output: 2
echo maximumSaleItems([[1,6],[2,100],[3,100]], 18) . "\n";                             // Output: 5
echo maximumSaleItems([[1,5],[2,10]], 20) . "\n";                                      // Output: 4
?>
```

## Explanation

- Buying one copy of item `i` normally gives `1` item.
- If `i` has at least one valid different multiple item `j`, then one purchased copy can also generate one free copy.
- Since each ordered pair `(i, j)` can be used at most once, buying more than `gain[i]` copies of item `i` no longer creates additional free copies from `i`.
- Thus, the first `gain[i]` purchased copies of item `i` have marginal value `2`, and all further copies have marginal value `1`.
- All value-1 marginal copies are identical in value, so they should always come from the minimum-price item.
- For value-2 marginal copies, cost matters. We sort by price and buy the cheapest boosted copies first.
- Batching avoids expanding up to `gain[i]` copies one by one; each item type is processed in one or two operations.

## Complexity Analysis

- Counting factors and multiples: `O(n log n)` because the harmonic sum over multiples is `n/1 + n/2 + ... + n/n`.
- Sorting useful value-2 entries: `O(n log n)`.
- Greedy purchase pass: `O(n)`.
- Overall time complexity: `O(n log n)`.
- Space complexity: `O(n)` for frequency, multiples, and entry arrays.

**Contact Links**

If you found this series helpful, please consider giving the **[repository](https://github.com/mah-shamim/leet-code-in-php)** a star on GitHub or sharing the post on your favorite social networks 😍. Your support would mean a lot to me[!](https://chaindoorman.com/hzk8jsphf8?key=5ba736283dafd7f94a84865e3cc3d775)
<a href="https://buymeacoffee.com/mah.shamim" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" ></a>

If you want more helpful content like this, feel free to follow me:

- **[LinkedIn](https://www.linkedin.com/in/arifulhaque/)**
- **[GitHub](https://github.com/mah-shamim)**