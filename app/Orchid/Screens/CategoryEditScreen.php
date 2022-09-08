<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use App\Http\Requests\StoreCategoryRequest;

class CategoryEditScreen extends Screen
{
    /**
     * @var Category
     */
    public $category;

    /**
     * Query data.
     *
     * @param Category $category
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $category->load('attachment');

        return [
            'category' => $category
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Edit Category' : 'Creating a new category';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Categories";
    }


    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create category')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->category->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),
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
            Layout::rows([
                Input::make('category.name')
                    ->title('Category Name')
                    ->placeholder('What category is that!'),

                TextArea::make('category.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('What products will be fit in this category!'),

                Upload::make('category.attachment')
                    ->maxFiles(1)
                    ->acceptedFiles('image/*'),

                Relation::make('category.parent_id')
                    ->title('Parent Category')
                    ->fromModel(Category::class, 'name'),

                CheckBox::make('category.status')
                    ->value(1)
                    ->title('Is it an active category?!')

            ])
        ];
    }

    /**
     * @param Category $category
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function createOrUpdate(Category $category, StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $category->fill($validated['category'])->save();

        $category->attachment()->syncWithoutDetaching(
            $request->input('category.attachment', [])
        );

        Alert::info('You have successfully created a category.');

        return redirect()->route('platform.categories');
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Category $category)
    {
        $category->delete();

        Alert::info('You have successfully deleted the category.');

        return redirect()->route('platform.categories');
    }
}
