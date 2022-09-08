<?php

namespace App\Nova;

use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use NovaItemsField\Items;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class FormSection extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\FormSection::class;

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

            BelongsTo::make('Form', 'form', 'App\Nova\Form'),

            Text::make('Title', 'title'),

            Select::make('Type', 'type')->options(config('forms.section_types'))->required(),

            Text::make('Description', 'description')->nullable()->hideFromIndex(),

            HasMany::make('Attributes', 'attributes', 'App\Nova\FormSectionAttribute')->showOnDetail(function () {
                return $this->type === 'attributes';
            }),

            NovaDependencyContainer::make([
                Text::make('Agreement Title', 'agreement_title')
            ])->dependsOn('type', 'agreement'),

            NovaDependencyContainer::make([
                CKEditor5Classic::make('Agreement Content', 'agreement_content')
            ])->dependsOn('type', 'agreement'),

            NovaDependencyContainer::make([
                Text::make('Acceptance Title', 'acceptance_title')
            ])->dependsOn('type', 'agreement'),

            NovaDependencyContainer::make([
                Text::make('Donation Title', 'donation_title'),
                Boolean::make('Is fixed donation price', 'is_fixed_donation_price'),

                NovaDependencyContainer::make([
                    Number::make('Donation Price', 'fixed_donation_price'),
                ])->dependsOn('is_fixed_donation_price', 1),

                NovaDependencyContainer::make([
                    Text::make('Donation Price Checking API', 'donation_price_checking_api_url'),
                    Items::make('Donation Price Checking Attributes', 'donation_price_checking_attributes')
                ])->dependsOn('is_fixed_donation_price', 0),

            ])->dependsOn('type', 'donation'),

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
