<?php

namespace App\Orchid\Layouts\ListLayouts;

use App\Models\Brand;
use Orchid\Screen\TD;
use App\Models\Product;
use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'products';

    /**
     * @return TD[]
     */
    public function columns(): array
    {

        return [
            TD::make('id', '#'),
            TD::make('', 'Image')
                ->width('70')
                ->render(function (Product $product) {
                        // $s = explode("http://localhost/", $product->attachment[0]->url);
                        // unset($s[0]);
                        // $s = implode("", $s);
                    return "<img src='{$product->featured_image}' class='mw-100 d-block img-fluid'>";
                }),
            TD::make('name', 'Name')
                ->render(function (Product $product) {
                    return Link::make($product->name)
                        ->route('platform.products.edit', $product);
                }),
                
            TD::make('', 'Images')
                ->width('70')
                ->render(function (Product $product) {
                    $sFinal='';
                    $openingTag="<div style='display: flex;'>";
                    $closingTag="</div>";
                    if(count($product->attachment)!=0)
                    {
                        foreach ($product->attachment as $value) {
                            $s = explode("http://localhost/", $value->url);
                            unset($s[0]);
                            $s = implode("", $s);
                            $sFinal.="<div style='padding:5px;'><img src='/$s' style='width:50px'></div>";
                        }
                    return $openingTag.$sFinal.$closingTag;
                    } else {
                        return "<span></span>";
                    }
                        
                }),

            TD::make('cost_price', 'Cost Price')
                ->render(function (Product $product) {
                    return $product->cost_price.'$';
                }),

            TD::make('price', 'Price')
                ->render(function (Product $product) {
                    return $product->price.'$';
                }),

            TD::make('sale_price', 'Sale Price')
                ->render(function (Product $product) {
                    return $product->sale_price.'$';
                }),
            
            TD::make('sku', 'SKU')
                ->render(function (Product $product) {
                    return $product->sku;
                }),

            TD::make('quantity', 'Quantity')
                ->render(function (Product $product) {
                    return $product->quantity;
                }),

            TD::make('category_id', 'Category')
                ->render(function (Product $product) {
                    return Category::find($product->category_id)->name;
                }),

            TD::make('brand_id', 'Brand')
                ->render(function (Product $product) {
                    return Brand::find($product->brand_id)->name;
                }),

            TD::make('status', 'Status')
                ->render(function (Product $product) {
                    if($product->status){
                        return "Active";
                    }else{
                        return "Not Active";
                    }
                }),
        ];
    }
}
