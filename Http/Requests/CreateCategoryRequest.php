<?php

namespace Modules\Activity\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'activity::categories.form';
    public function rules()
    {
        return [
            'sorting' => 'required'
        ];
    }

    public function attributes()
    {
        return trans('activity::categories.form');
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
            'slug'  => "required|unique:activity__category_translations,slug,null,category_id,locale,$this->localeKey"
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
