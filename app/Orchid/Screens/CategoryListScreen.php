<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Attachment\File;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Illuminate\Http\UploadedFile;
use Orchid\Screen\Actions\Button;
use App\Orchid\Layouts\CategoryListLayout;

class CategoryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */

    public function query(Category $category): array
    {
        $category->load('attachment');

        return [
            'categories' => Category::paginate()
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return 'Category';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "All Categories";
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.categories.create'),
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
            CategoryListLayout::class
        ];
    }
}
