<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class AprioriController extends Controller
{
    public function index()
    {
        return view('apriori.apriori');
    }
    
    public function process(Request $request)
    {
        // Validasi input user
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'support' => 'required|numeric|min:0|max:1',
            'confidence' => 'required|numeric|min:0|max:1',
            'k' => 'required|integer|min:1'
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $support = $request->input('support');
        $confidence = $request->input('confidence');
        $maxK = $request->input('k');

        // Ambil data transaksi sesuai rentang tanggal
        $transactions = Transaction::with('details')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->get();

        // Proses Apriori dan dapatkan langkah-langkahnya
        $steps = $this->apriori($transactions, $support, $confidence, $maxK);

        // Return hasil atau tampilkan di view
        return view('apriori.apriori_result', ['steps' => $steps]);
    }


    private function apriori($transactions, $support, $confidence, $maxK)
    {
        $steps = [];
        $transactionCount = count($transactions);
        $minSupportCount = $support * $transactionCount;

        // Langkah 1: Hitung 1-itemset
        $itemset = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction->details as $detail) {
                $productId = $detail->id_product;
                $productName = $detail->product->product_name;
                if (!isset($itemset[$productId])) {
                    $itemset[$productId] = ['count' => 1, 'product_name' => $productName];
                } else {
                    $itemset[$productId]['count']++;
                }
            }
        }

        // Menghitung support untuk 1-itemset
        $itemsetWithSupport = [];
        foreach ($itemset as $item => $data) {
            $itemsetWithSupport[$item] = [
                'count' => $data['count'],
                'support' => $data['count'] / $transactionCount,
                'product_name' => $data['product_name']
            ];
        }
        $steps[] = ['description' => 'Frekuensi 1-itemset', 'data' => $itemsetWithSupport];


        $frequentItemsets = array_filter($itemsetWithSupport, function($item) use ($minSupportCount) {
            return $item['count'] >= $minSupportCount;
        });

        $allFrequentItemsets = [$frequentItemsets];

        $k = 2;
        while (!empty($frequentItemsets) && $k <= $maxK ) {
            // Generate candidate k-itemsets from frequent (k-1)-itemsets
            $candidateItemsets = $this->generateCandidates(array_keys($frequentItemsets), $k);

            // Count support for candidate k-itemsets
            $candidateItemsetsCount = [];
            foreach ($transactions as $transaction) {
                $transactionItems = $transaction->details->pluck('id_product')->toArray();
                foreach ($candidateItemsets as $candidate) {
                    if ($this->isSubset($candidate, $transactionItems)) {
                        $candidateKey = implode(', ', $candidate);
                        if (!isset($candidateItemsetsCount[$candidateKey])) {
                            $candidateItemsetsCount[$candidateKey] = 1;
                        } else {
                            $candidateItemsetsCount[$candidateKey]++;
                        }
                    }
                }
            }

            // Menghitung support untuk k-itemsets
            $candidateItemsetsWithSupport = [];
            foreach ($candidateItemsetsCount as $candidate => $count) {
                $candidateNames = array_map(function($id) use ($itemsetWithSupport) {
                    return $itemsetWithSupport[$id]['product_name'];
                }, explode(', ', $candidate));
                
                $candidateItemsetsWithSupport[$candidate] = [
                    'count' => $count,
                    'support' => $count / $transactionCount,
                    'product_name' => implode(', ', $candidateNames)
                ];
            }
            $steps[] = ['description' => "Frekuensi $k-itemset", 'data' => $candidateItemsetsWithSupport];

            
            // Filter candidate k-itemsets by support
            $frequentItemsets = array_filter($candidateItemsetsWithSupport, function($item) use ($minSupportCount) {
                return $item['count'] >= $minSupportCount;
            });

            if (!empty($frequentItemsets)) {
                $allFrequentItemsets[] = $frequentItemsets;
            }

            $k++;
        }

        // Generate association rules from all frequent itemsets
        $rules = [];
        foreach ($allFrequentItemsets as $frequentItemsets) {
            foreach ($frequentItemsets as $itemset => $item) {
                $items = explode(', ', $itemset);
                if (count($items) > 1) {
                    foreach ($items as $itemPart) {
                        $remainingItems = array_diff($items, [$itemPart]);
                        $remainingKey = implode(', ', $remainingItems);
                        if (isset($allFrequentItemsets[count($remainingItems) - 1][$remainingKey])) {
                            $remainingCount = $allFrequentItemsets[count($remainingItems) - 1][$remainingKey]['count'];
                            $confidenceValue = $item['count'] / $remainingCount;
                            if ($confidenceValue >= $confidence) {
                                $remainingNames = array_map(function($id) use ($itemsetWithSupport) {
                                    return $itemsetWithSupport[$id]['product_name'];
                                }, $remainingItems);

                                $rules[] = [
                                    'rule' =>  "Jika pelanggan membeli " . implode(' dan ', $remainingNames) . ", maka mereka juga cenderung membeli  " . $itemsetWithSupport[$itemPart]['product_name'],
                                    'confidence' => $confidenceValue,
                                    'support' => $item['support']
                                ];
                            }
                        }
                    }
                }
            }
        }
        $steps[] = ['description' => 'Aturan asosiasi', 'data' => $rules];

        return $steps;
    }

    private function generateCandidates($frequentItemsets, $k)
    {
        $items = $frequentItemsets;
        $candidates = [];
        foreach ($items as $i => $item1) {
            for ($j = $i + 1; $j < count($items); $j++) {
                $item2 = $items[$j];
                $candidate = array_unique(array_merge(explode(',', $item1), explode(',', $item2)));
                sort($candidate);
                if (count($candidate) == $k && !in_array($candidate, $candidates)) {
                    $candidates[] = $candidate;
                }
            }
        }
        return $candidates;
    }

    private function isSubset($subset, $set)
    {
        return count(array_diff($subset, $set)) == 0;
    }
}
