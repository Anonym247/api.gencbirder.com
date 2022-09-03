<?php

namespace App\Nova;

use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaItemsField\Items;

class FormSectionAttribute extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\FormSectionAttribute::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
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

            BelongsTo::make('Form Section', 'formSection', 'App\Nova\FormSection'),

            Text::make('Name', 'name'),

            Select::make('Type', 'type')->options(config('forms.attribute_types'))->readonlyOnUpdate(),

            Boolean::make('Is required', 'is_required')->default(1),

            NovaDependencyContainer::make([
                Boolean::make('Is email', 'is_email')->default(0),
                Number::make('Minimum', 'min'),
                Number::make('Maximum', 'max'),
            ])->dependsOn('type', 'text'),

            NovaDependencyContainer::make([
                Number::make('Minimum', 'min'),
                Number::make('Maximum', 'max'),
            ])->dependsOn('type', 'number'),

            NovaDependencyContainer::make([
                Items::make('Options', 'options')
            ])->dependsOn('type', 'select'),

            Text::make('Reference API', 'reference_api_url')
                ->hideWhenCreating()
                ->hideFromDetail(function () {
                    return $this->type !== 'reference_select';
                })
                ->hideWhenUpdating(function () {
                    return $this->type !== 'reference_select';
                })->required(),

            BelongsTo::make('Reference Attribute', 'referenceAttribute', 'App\Nova\FormSectionAttribute')
                ->hideWhenCreating()
                ->hideFromDetail(function () {
                    return $this->type !== 'reference_select';
                })
                ->hideWhenUpdating(function () {
                    return $this->type !== 'reference_select';
                })->nullable(),

            Text::make('Reference Attribute Name', 'reference_attribute_name')
                ->hideFromDetail(function () {
                    return $this->type !== 'reference_select';
                })
                ->hideWhenCreating()
                ->hideWhenUpdating(function () {
                    return $this->type !== 'reference_select';
                }),

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
