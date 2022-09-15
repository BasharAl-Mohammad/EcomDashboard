<?php

namespace App\Orchid\Screens\Product;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Orchid\Screen\Fields\Cropper;

class ProductEditScreen extends Screen
{
    /**
     * @var Product
     */
    public $product;

    /**
     * Query data.
     *
     * @param Product $product
     *
     * @return array
     */

    public function query(Product $product): iterable
    {
        return [
            'product' => $product
        ];
    }

     /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return $this->product->exists ? 'Edit product' : 'Creating a new product';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Products";
    }


    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create product')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->product->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->product->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->product->exists),
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
                Input::make('product.name')
                    ->title('Products Name')
                    ->placeholder('2.5" SSD compac. with desktops and laptops'),

                TextArea::make('product.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Input::make('product.cost_price')
                    ->title('Cost Price')
                    ->type('number'),

                Input::make('product.price')
                    ->title('Price')
                    ->type('number'),

                Input::make('product.sale_price')
                    ->title('Sale Price')
                    ->type('number'),

                Input::make('product.sku')
                    ->title('Stock Keeping Unit')
                    ->type('number'),

                Input::make('product.quantity')
                    ->title('Number of products available in stock')
                    ->type('number'),

                Cropper::make('product.featured_image')
                    ->title('Upload a featured image for your product')
                    ->targetRelativeUrl(),

                Upload::make('product.attachment')
                    ->title('Upload more pictures of your product (10 uploads are permissible)')
                    ->maxFiles(10)
                    ->acceptedFiles('image/*')
                    ->targetRelativeUrl(),


                Relation::make('product.category_id')
                    ->title('Category')
                    ->fromModel(Category::class, 'name'),

                Relation::make('product.brand_id')
                    ->title('Brand')
                    ->fromModel(Brand::class, 'name'),

                CheckBox::make('product.status')
                    ->value(1)
                    ->title('Is it an active product?!')

            ])
        ];
    }

    /**
     * @param Product    $product
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Product $product, StoreProductRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        $product->fill($validated['product'])->save();

        $product->attachment()->syncWithoutDetaching(
            $request->input('product.attachment', [])
        );

        Alert::info('You have successfully created a product.');

        return redirect()->route('platform.products');
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        $product->fill($validated['product'])->save();

        $product->attachment()->syncWithoutDetaching(
            $request->input('product.attachment', [])
        );

        Alert::info('You have successfully updated your product.');

        return redirect()->route('platform.products');
    }

    /**
     * @param Product $product
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Product $product)
    {
        
        $product->delete();

        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.products');
    }
}
