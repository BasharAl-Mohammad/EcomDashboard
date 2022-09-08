<?php

namespace App\Orchid\Screens;


use App\Models\Brand;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\BrandListLayout;


class BrandListScreen extends Screen
{
     /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'brands' => Brand::paginate()
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return 'Brands';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "All brands Available";
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Add a new Brand')
                ->icon('plus')
                ->route('platform.brands.create')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            BrandListLayout::class
        ];
    }
}
