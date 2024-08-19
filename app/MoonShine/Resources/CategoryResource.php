<?php

namespace App\MoonShine\Resources;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Model;


use MoonShine\Fields\Number;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class CategoryResource extends Resource
{
	public static string $model = Category::class;

	public static string $title = 'Categories';

//    public string $titleField = 'title';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
            Text::make('Title'),
            Text::make('Slug'),
            SwitchBoolean::make('On Home Page'),
            Number::make('Sorting')
                  ->min(1)->max(999)
        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
