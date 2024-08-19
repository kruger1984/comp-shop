<?php

namespace App\MoonShine\Resources;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;


use MoonShine\Actions\ExportAction;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class ProductResource extends Resource
{
	public static string $model = Product::class;

	public static string $title = 'Products';

    public static array $with = [
        'brand', 'categories', 'properties', 'optionValues'
    ];


	public function fields(): array
	{
		return [

            Tab::make('Basic', [
                ID::make()->sortable(),
                Text::make('Title')->sortable(),
                Number::make('Price', resource: function ($item) {
                    return $item->price->raw();
                }),
                Number::make('Quantity'),

                Image::make('Thumbnail')
                     ->disk('images'),
                BelongsTo::make('Brands', 'brand'),
                Text::make('Slug'),
                SwitchBoolean::make('On Home Page'),
                Number::make('Sorting')
                      ->min(1)->max(999)
            ]),
            Tab::make('Categories', [
                BelongsToMany::make('Categories', resource: 'title')
                    ->hideOnIndex()
            ]),
            Tab::make('Properties', [
                BelongsToMany::make('Properties', resource: 'title')
                ->fields([
                    Text::make('Value')
                ])->hideOnIndex()
            ]),
            Tab::make('Options', [
                BelongsToMany::make('OptionValues', resource: 'title')
                             ->fields([
                                 Text::make('Value')
                             ])->hideOnIndex()
            ]),

        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id', 'title'];
    }

    public function filters(): array
    {
        return [
            BelongsToFilter::make('Brand')
            ->searchable()
        ];
    }

    public function actions(): array
    {
        return [
            ExportAction::make('Export'),
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
