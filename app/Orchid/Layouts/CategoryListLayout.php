<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use App\Models\Category;
use Orchid\Attachment\File;
use Orchid\Screen\Repository;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Illuminate\Http\UploadedFile;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'categories';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', '#'),
            TD::make('', 'Image')
                ->width('70')
                ->render(function (Category $category) {
                    return "<img src='{$category->attachment[0]->url}' class='mw-100 d-block img-fluid'>";
                }),
            TD::make('name', 'Name')
                ->render(function (Category $category) {
                    return Link::make($category->name)
                        ->route('platform.categories.edit', $category);
                }),
            TD::make('created_at', 'Created At')
                ->render(function (Category $category) {
                    return $category->created_at->toDateString();
                }),
            TD::make('updated_at', 'Updated At')
                ->render(function (Category $category) {
                    return $category->updated_at->toDateString();
                }),
        ];
    }
}
