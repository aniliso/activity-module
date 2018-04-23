<?php

namespace Modules\Activity\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateCategoryRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'activity::categories.form';
    public function rules()
    {
        return [
            'sorting' => 'required'
        ];
    }

    public function translationRules()
    {
        $id = $this->route()->parameter('activityCategory')->id;
        return [
            'title' => 'required',
            'slug'  => "required|unique:activity__category_translations,slug,$id,category_id,locale,$this->localeKey"
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
