<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Menu', 'menu')->nullable(),

            Boolean::make('Is for menu ?', 'is_for_menu')->default(1),

            Select::make('Type')->options([
                'Info' => 'info',
                'Form' => 'form',
                'Team' => 'team',
                'Reports' => 'reports',
                'Banner' => 'banner',
            ])->required(),

            Text::make('Title', 'title'),

            Text::make('Slug', 'slug')->hideWhenUpdating()->hideWhenCreating()->readonly(),

            Image::make('Photo', 'photo')->nullable(),

            CKEditor5Classic::make('content')->withFiles('public'),

            Text::make('Video', 'video')->nullable(),

            Image::make('Banner Photo', 'banner_photo')->nullable(),

            Image::make('Attachment Photo', 'attachment_photo')->nullable(),

            Text::make('Attachment Url', 'attachment_url')->nullable(),

            BelongsToMany::make('Related Pages', 'relatedPages', 'App\Nova\Page'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
