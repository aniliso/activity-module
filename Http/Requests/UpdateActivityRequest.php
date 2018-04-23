<?php

namespace Modules\Activity\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateActivityRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'activity::activities.form';
    public function rules()
    {
        return [
            'category_id'          => 'required',
            'events.*.location_id' => 'required|required_with:events.*.event_at',
            'events.*.event_at'    => 'required_with:events.*.location_id',
            'sorting'              => 'required'
        ];
    }

    public function attributes()
    {
        return trans('activity::activities.form');
    }

    public function translationRules()
    {
        $id = $this->route()->parameter('activity')->id;
        return [
            'title' => 'required',
            'slug'  => "required|unique:activity__activity_translations,slug,$id,activity_id,locale,$this->localeKey"
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
