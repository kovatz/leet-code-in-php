3414\. Maximum Score of Non-overlapping Intervals

**Difficulty:** Hard

**Topics:** `Senior Staff`, `Array`, `Binary Search`, `Dynamic Programming`, `Sorting`, `Weekly Contest 431`

You are given a 2D integer array `intervals`, where `intervals[i] = [lᵢ, rᵢ, weightᵢ]`. Interval `i` starts at position `lᵢ` and ends at `rᵢ`, and has a weight of `weightᵢ`. You can choose up to 4 **non-overlapping** intervals. The **score** of the chosen intervals is defined as the total sum of their weights.

Return the **lexicographically smallest[^1]** array of at most 4 indices from `intervals` with **maximum** score, representing your choice of non-overlapping intervals.

Two intervals are said to be **non-overlapping** if they do not share any points. In particular, intervals sharing a left or right boundary are considered overlapping.

[^1]: **Lexicographically Smaller:** An array `a` is **lexicographically smaller** than an array `b` if in the first position where `a` and `b` differ, array `a` has an element that is less than the corresponding element in `b`. If the first `min(a.length, b.length)` elements do not differ, then the shorter array is the lexicographically smaller one.

**Example 1:**

- **Input:** intervals = [[1,3,2],[4,5,2],[1,5,5],[6,9,3],[6,7,1],[8,9,1]]
- **Output:** [2,3]
- **Explanation:** You can choose the intervals with indices 2, and 3 with respective weights of 5, and 3.

**Example 2:**

- **Input:** intervals = [[5,8,1],[6,7,7],[4,7,3],[9,10,6],[7,8,2],[11,14,3],[3,5,5]]
- **Output:** [1,3,5,6]
- **Explanation:** You can choose the intervals with indices 1, 3, 5, and 6 with respective weights of 7, 6, 3, and 5.

**Example 3:**

- **Input:** intervals = [[1,2,10]]
- **Output:** [0]

**Example 4:**

- **Input:** intervals = [[1,2,5],[2,3,5]]
- **Output:** [0]

**Example 5:**

- **Input:** intervals = [[1,2,10],[2,3,10],[3,4,10]]
- **Output:** [0,2]

**Example 6:**

- **Input:** intervals = [[1,10,5],[2,3,4],[4,5,6]]
- **Output:** [1,2]

**Example 7:**

- **Input:** intervals = [[1,2,1],[1,2,2],[1,2,3]]
- **Output:** [2]

**Example 8:**

- **Input:** intervals = [[1,2,5],[1,2,5]]
- **Output:** [0]

**Example 9:**

- **Input:** intervals = [[1,5,3],[6,10,4],[11,15,5],[16,20,6],[21,25,7]]
- **Output:** [0,1,2,3]

**Example 10:**

- **Input:** intervals = [[1,100,1],[2,3,2],[4,5,2],[6,7,2],[8,9,2]]
- **Output:** [1,2,3,4]

**Example 11:**

- **Input:** intervals = [[1,2,0],[1,2,0]]
- **Output:** [0]

**Example 12:**

- **Input:** intervals = [[1,10,100],[2,3,1],[4,5,1],[6,7,1],[8,9,1]]
- **Output:** [0]

**Example 13:**

- **Input:** intervals = [[1,2,10],[2,3,10],[3,4,10],[4,5,10],[5,6,10]]
- **Output:** [0,2,4]

**Example 14:**

- **Input:** intervals = [[1,3,2],[2,4,3],[3,5,4],[4,6,5]]
- **Output:** [0,3]

**Example 15:**

- **Input:** intervals = [[1,1000000000,1000000000]]
- **Output:** [0]

**Constraints:**

- `1 <= intevals.length <= 5 * 10⁴`
- `intervals[i].length == 3`
- `intervals[i] = [lᵢ, ᵢi, weightᵢ]`
- `1 <= lᵢ <= rᵢ <= 10⁹`
- `1 <= weighti <= 10⁹`


**Hint:**
1. Use Dynamic Programming.
2. Sort `intervals` by right boundary.
3. Let `dp[r][i]` denote the maximum score having picked `r` intervals from the prefix of `intervals` ending at index `i`.
4. `dp[r][i] = max(dp[r][i - 1], intervals[i][2] + dp[r][j])` where `j` is the largest index such that `intervals[j][1] < intervals[i][0]`.
5. Since `intervals` is sorted by right boundary, we can find index `j` using binary search.


**Similar Questions:**
1. [2054. Two Best Non-Overlapping Events](https://github.com/mah-shamim/leet-code-in-php/tree/main/algorithms/002054-two-best-non-overlapping-events)


**Solution:**

We solve the "Maximum Score of Non-overlapping Intervals" problem by combining dynamic programming with binary search. After sorting intervals by their right boundary, we compute for each interval the nearest compatible predecessor (the rightmost interval ending before the current one starts). We then use DP to track the maximum achievable score when selecting up to 4 non-overlapping intervals, while simultaneously maintaining the lexicographically smallest set of original indices that achieves that score.

## Approach

- **Augment intervals with original indices:** Each interval is stored as `[start, end, weight, original_index]` so we can return indices instead of values.
- **Sort by end time:** Sort intervals by `end`, then by `start`, then by original index. This ordering guarantees that compatible predecessors appear earlier.
- **Precompute predecessor array:** For each interval `i`, binary search among intervals `0..i-1` to find the largest index `j` such that `end[j] < start[i]`. Store this in `prev[i]` (or `-1` if none).
- **DP over count and prefix:** Define `dp[k][i]` = maximum total weight using at most `k` intervals from the first `i` sorted intervals.
- **State transition:**
    - Skip interval `i-1`: `dp[k][i] = dp[k][i-1]`.
    - Take interval `i-1`: `weight + dp[k-1][prev[i-1]+1]`.
    - Keep the option with the larger score; if tied, keep the lexicographically smaller index list.
- **Track chosen indices:** Alongside `dp`, maintain `choice[k][i]` — the sorted list of original indices that achieves `dp[k][i]`.
- **Final answer:** Among `k = 1..4`, pick the maximum score; on ties, choose the lexicographically smallest index array.

Let's implement this solution in PHP: **[3414. Maximum Score of Non-overlapping Intervals](https://github.com/mah-shamim/leet-code-in-php/tree/main/algorithms/003414-maximum-score-of-non-overlapping-intervals/solution.php)**

```php
<?php
/**
 * @param Integer[][] $intervals
 * @return Integer[]
 */
function maximumWeight(array $intervals): array
{
    ...
    ...
    ...
    /**
     * go to ./solution.php
     */
}

/**
 * Compare two arrays lexicographically
 *
 * @param $a
 * @param $b
 * @return bool
 */
function isLexicographicallySmaller($a, $b): bool
{
    ...
    ...
    ...
    /**
     * go to ./solution.php
     */
}

// Test cases
echo maximumWeight([[1,3,2],[4,5,2],[1,5,5],[6,9,3],[6,7,1],[8,9,1]]) .  "\n";                  // Output: [2,3]
echo maximumWeight([[5,8,1],[6,7,7],[4,7,3],[9,10,6],[7,8,2],[11,14,3],[3,5,5]]) .  "\n";       // Output: [1,3,5,6]
echo maximumWeight([[1,2,10]]) .  "\n";                                                         // Output: [0]
echo maximumWeight([[1,2,5],[2,3,5]]) .  "\n";                                                  // Output: [0]
echo maximumWeight([[1,2,10],[2,3,10],[3,4,10]]) .  "\n";                                       // Output: [0, 2]
echo maximumWeight([[1,10,5],[2,3,4],[4,5,6]]) .  "\n";                                         // Output: [1, 2]
echo maximumWeight([[1,2,1],[1,2,2],[1,2,3]]) .  "\n";                                          // Output: [2]
echo maximumWeight([[1,2,5],[1,2,5]]) .  "\n";                                                  // Output: [0]
echo maximumWeight([[1,5,3],[6,10,4],[11,15,5],[16,20,6],[21,25,7]]) .  "\n";                   // Output: [0,1,2,3]
echo maximumWeight([[1,100,1],[2,3,2],[4,5,2],[6,7,2],[8,9,2]]) .  "\n";                        // Output: [1,2,3,4]
echo maximumWeight([[1,2,0],[1,2,0]]) .  "\n";                                                  // Output: [0]
echo maximumWeight([[1,10,100],[2,3,1],[4,5,1],[6,7,1],[8,9,1]]) .  "\n";                       // Output: [0]
echo maximumWeight([[1,2,10],[2,3,10],[3,4,10],[4,5,10],[5,6,10]]) .  "\n";                     // Output: [0,2,4]
echo maximumWeight([[1,3,2],[2,4,3],[3,5,4],[4,6,5]]) .  "\n";                                  // Output: [0, 3]
echo maximumWeight([[1,1000000000,1000000000]]) .  "\n";                                        // Output: [0]
?>
```

### Explanation:

- **Why sort by end time?** It ensures that any interval compatible with the current one (i.e., ends before the current starts) appears earlier in the array, enabling binary search over a monotonic property.
- **Why use `prev[i]`?** It reduces the transition to O(1) lookup after O(n log n) preprocessing, avoiding an O(n²) scan.
- **Why DP dimension `k` up to 4?** The problem allows at most 4 intervals. We compute all `k` values so we can compare scores across different counts.
- **Lexicographic tie-breaking:** When two choices yield the same score, we compare the sorted index arrays element by element. If one is a prefix of the other, the shorter array wins.
- **Correctness of non-overlap:** Since intervals are sorted by end time and we only transition from `prev[i]` (where `end < start`), chosen intervals never share a boundary.
- **Returning indices:** The DP stores original indices, so the final result is directly the required array of indices.

## Complexity Analysis

- **Time Complexity:**
    - Sorting: `O(n log n)`
    - Predecessor binary search for each interval: `O(n log n)`
    - DP transitions: `O(4 * n)` = `O(n)`
    - Lexicographic comparisons during DP: each `choice` list has at most 4 elements, so `O(1)` per comparison.
    - **Total: `O(n log n)`**
- **Space Complexity:**
    - `sortedIntervals`: `O(n)`
    - `prev`: `O(n)`
    - `dp`: `5 × (n+1)` integers = `O(n)`
    - `choice`: `5 × (n+1)` arrays, each up to 4 elements = `O(n)`
    - **Total: `O(n)`**

**Contact Links**

If you found this series helpful, please consider giving the **[repository](https://github.com/mah-shamim/leet-code-in-php)** a star on GitHub or sharing the post on your favorite social networks 😍. Your support would mean a lot to me[!](https://chaindoorman.com/hzk8jsphf8?key=5ba736283dafd7f94a84865e3cc3d775)
<a href="https://buymeacoffee.com/mah.shamim" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" ></a>

If you want more helpful content like this, feel free to follow me:

- **[LinkedIn](https://www.linkedin.com/in/arifulhaque/)**
- **[GitHub](https://github.com/mah-shamim)**