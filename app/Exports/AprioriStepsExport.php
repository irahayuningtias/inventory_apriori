<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AprioriStepsExport implements WithMultipleSheets
{
    protected $steps;

    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet untuk frekuensi k-itemset
        $sheets[] = new KItemsetSheet($this->steps);

        // Sheet untuk aturan asosiasi
        $sheets[] = new AssociationRulesSheet($this->steps);

        return $sheets;
    }
}

// KItemsetSheet Class
class KItemsetSheet implements FromArray, WithHeadings
{
    protected $steps;

    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->steps as $step) {
            if (strpos($step['description'], 'Frekuensi') !== false) {
                foreach ($step['data'] as $item) {
                    $data[] = [
                        'step' => $step['description'],
                        'product_name' => $item['product_name'],
                        'frekuensi' => $item['count'],
                        'support' => $item['support'],
                    ];
                }
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Step',
            'Product Name',
            'Frekuensi',
            'Support',
        ];
    }
}

// AssociationRulesSheet Class
class AssociationRulesSheet implements FromArray, WithHeadings
{
    protected $steps;

    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->steps as $step) {
            if ($step['description'] === 'Aturan asosiasi') {
                foreach ($step['data'] as $rule) {
                    $data[] = [
                        'rule' => $rule['rule'],
                        'confidence' => $rule['confidence'],
                        'support' => $rule['support'],
                    ];
                }
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Rule',
            'Confidence',
            'Support'
        ];
    }
}
