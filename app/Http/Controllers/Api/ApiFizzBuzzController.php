<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="BUKUKU API",
 *     version="1.0.0"
 * )
 */
class ApiFizzBuzzController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/fizzbuzz",
     *     summary="Generate FizzBuzz sequence",
     *     description="Returns FizzBuzz sequence up to the number n",
     *     operationId="codingtest",
     *     tags={"CodingTest"},
     *     @OA\Parameter(
     *         name="n",
     *         in="query",
     *         description="Maximum number of ones",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function fizzbuzz(Request $request)
    {
        $validatedData = $request->validate([
            'n' => 'required|integer|min:1',
        ]);

        $n = $validatedData['n'];
        $result = [];
        for ($i = 1; $i <= $n; $i++) {
            if ($i % 3 === 0 && $i % 5 === 0 && $i % 7 === 0) {
                $result[] = "FizzBuzz";
            } elseif ($i % 3 === 0 && $i % 5 === 0) {
                $result[] = "Fizz1";
            } elseif ($i % 3 === 0 && $i % 7 === 0) {
                $result[] = "Fizz2";
            } elseif ($i % 5 === 0 && $i % 7 === 0) {
                $result[] = "Fizz3";
            } elseif ($i % 3 === 0) {
                $result[] = "Buzz1";
            } elseif ($i % 5 === 0) {
                $result[] = "Buzz2";
            } elseif ($i % 7 === 0) {
                $result[] = "Buzz3";
            } else {
                $result[] = (string)$i;
            }
        }
        return response()->json($result, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/findMaxForm",
     *     summary="Find the maximum subset of binary strings",
     *     description="Given an array of binary strings and two integers, returns the largest subset with at most m zeros and n ones.",
     *     tags={"CodingTest"},
     *     @OA\Parameter(
     *         name="strs[]",
     *         in="query",
     *         description="Array of binary strings",
     *         required=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="string"),
     *             example={"10", "0001", "111001", "1", "0"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="m",
     *         in="query",
     *         description="Maximum number of zeros",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=5
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="n",
     *         in="query",
     *         description="Maximum number of ones",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="maxSubsetSize", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function findMaxForm(Request $request)
    {
        // Validasi manual untuk array dalam query string
        $strs = $request->query('strs');
        $m = $request->query('m');
        $n = $request->query('n');

        if (!is_array($strs)) {
            return response()->json([
                'message' => 'The strs field must be an array.',
            ], 400);
        }

        $validatedData = $request->validate([
            'm' => 'required|integer|min:1',
            'n' => 'required|integer|min:1',
        ]);

        $m = $validatedData['m'];
        $n = $validatedData['n'];

        // Fungsi untuk menghitung subset terbesar
        $maxSubsetSize = $this->findMaxSubset($strs, $m, $n);

        return response()->json([
            'maxSubsetSize' => $maxSubsetSize,
        ], 200);
    }

    // Fungsi untuk menghitung subkumpulan terbesar yang memenuhi syarat
    private function findMaxSubset($strs, $m, $n)
    {
        $dp = array_fill(0, $m + 1, array_fill(0, $n + 1, 0));

        foreach ($strs as $str) {
            $zeroes = substr_count($str, '0');
            $ones = substr_count($str, '1');

            for ($i = $m; $i >= $zeroes; $i--) {
                for ($j = $n; $j >= $ones; $j--) {
                    $dp[$i][$j] = max($dp[$i][$j], 1 + $dp[$i - $zeroes][$j - $ones]);
                }
            }
        }

        return $dp[$m][$n];
    }

    /**
     * @OA\Post(
     *     path="/api/min-largest-sum",
     *     summary="Get the minimum largest sum of splitting array into k subarrays",
     *     description="Given an array of integers and an integer k, this endpoint returns the minimum largest sum of any of the k subarrays into which the array can be divided.",
     *     tags={"CodingTest"},
     *     @OA\Parameter(
     *         name="nums[]",
     *         in="query",
     *         description="Array of integer",
     *         required=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="integer"),
     *             example={1,2,3,4,5}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="k",
     *         in="query",
     *         description="Minimum number 2",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="minLargestSum", type="integer", example=9)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function minLargestSum(Request $request)
    {
        $request->validate([
            'nums' => 'required|array',
            'nums.*' => 'integer',
            'k' => 'required|integer|min:1'
        ]);

        $nums = $request->input('nums');
        $k = $request->input('k');

        $left = max($nums); // Maximum single element
        $right = array_sum($nums); // Sum of all elements

        while ($left < $right) {
            $mid = $left + (int)(($right - $left) / 2);
            if ($this->canDivide($nums, $k, $mid)) {
                $right = $mid;
            } else {
                $left = $mid + 1;
            }
        }

        return response()->json(['minLargestSum' => $left]);
    }

    private function canDivide($nums, $k, $maxSum)
    {
        $count = 1; // Start with one subarray
        $currentSum = 0;

        foreach ($nums as $num) {
            if ($currentSum + $num > $maxSum) {
                $count++;
                $currentSum = $num;
                if ($count > $k) {
                    return false;
                }
            } else {
                $currentSum += $num;
            }
        }

        return true;
    }
}