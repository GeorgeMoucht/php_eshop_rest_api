<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;


class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of example product lines.
        $productLines = [
            'Electronics',
            'Clothing',
            'Home & Garden',
            'Toys',
            'Books',
            'Kitchen & Dining',
            'Pt Supplies',
            'Office Supplies',
            'Music & Instruments',
            'Automotive',
            'Furniture'
        ];

        foreach($productLines as $lineName) {
            $productLine = new ProductCategory([
                'name' => $lineName
            ]);
            $productLine->save();
        }
    }
}
