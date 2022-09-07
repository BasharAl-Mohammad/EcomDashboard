<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;

use App\Models\Brand;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use App\Http\Requests\StoreBrandRequest;

class BrandEditScreen extends Screen
{
        /**
     * @var Brand
     */
    public $brand;

    /**
     * Query data.
     *
     * @param Brand $brand
     *
     * @return array
     */

    public function query(Brand $brand): iterable
    {
        return [
            'brand' => $brand
        ];
    }


    /**
     * The name is displayed on the user's screen and in the headers
     */

    public function name(): ?string
    {
        return 'Available Brands';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */

    public function description(): ?string
    {
        return "All brands";
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Add brand')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->brand->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->brand->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->brand->exists),
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
                Input::make('brand.name')
                    ->title('Name')
                    ->placeholder('What\'s the new brand\'s name'),

                Input::make('brand.website')
                    ->title('Website')
                    ->placeholder('What\'s the new brand\'s website'),

                TextArea::make('brand.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Describe the brand\'s you are adding a bit!'),

                CheckBox::make('brand.status')
                    ->value(1)
                    ->title('Is it an active brand?!')

            ])
        ];
    }

    /**
     * @param Post    $brand
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Brand $brand, StoreBrandRequest $request)
    {
        $validated = $request->validated();
        $brand->fill($validated['brand'])->save();

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.brand.list');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Brand $brand)
    {
        $brand->delete();

        Alert::info('You have successfully deleted the brand.');

        return redirect()->route('platform.brand.list');
    }
}
