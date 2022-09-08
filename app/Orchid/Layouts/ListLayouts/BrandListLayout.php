<?php

namespace App\Orchid\Layouts\ListLayouts;

use App\Models\Brand;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class BrandListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'brands';

    /**
     * @return TD[]
     */

    public function columns(): array
    {
        return [
            TD::make('name', 'Name')
                ->render(function (Brand $brand) {
                    return Link::make($brand->name)
                        ->route('platform.brands.edit', $brand);
                }),

            TD::make('website', 'Website')
                ->render(function (Brand $brand) {
                    return Link::make($brand->website);
                }),
                
            TD::make('status', 'Status')
                ->render(function (Brand $brand) {
                    return Link::make(($brand->status) ? 'Active' : 'Not Active');
                }),
        ];
    }
}
