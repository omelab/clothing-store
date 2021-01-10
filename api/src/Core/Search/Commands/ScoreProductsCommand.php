<?php

namespace GetCandy\Api\Core\Search\Commands;

use Carbon\Carbon;
use Elastica\Document;
use GetCandy\Api\Core\Products\Models\Product;
use GetCandy\Api\Core\Search\Actions\IndexObjects;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ScoreProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'candy:products:score';

    public function handle()
    {
        $results = DB::table('order_lines')
            ->select(
                'products.id',
                DB::RAW('COUNT(*) score')
            )
            ->whereBetween('placed_at', [
                Carbon::now()->subYear(),
                Carbon::now(),
            ])
            ->where('is_shipping', '=', false)
            ->join('orders', 'order_lines.order_id', '=', 'orders.id')
            ->join('product_variants', 'order_lines.sku', '=', 'product_variants.sku')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->groupBy('products.id')
            ->get();

        $hasher = \Hashids::connection('product');

//        $index = $search->indexer()->against(Product::class)->getCurrentIndex();
//
//        $documents = [];
//
//        foreach ($results as $product) {
//            $encodedId = $hasher->encode($product->id);
//
//            $document = new Document($encodedId);
//            $document->set('popularity', $product->score);
//            $document->setType('products');
//            $documents[] = $document;
//        }
//
//        IndexObjects::run([
//            'documents' => $documents,
//        ]);
//
//        $index->indexObjects($documents);
    }
}
