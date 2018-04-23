<?php

namespace Modules\Activity\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateLocationRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'activity::locations.form';

    public function rules()
    {
        return [
            'county' => 'required',
            'city'   => 'required'
        ];
    }

    public function attributes()
    {
        return trans('activity::locations.form');
    }

    public function translationRules()
    {
        return [
            'title'  => 'required'
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
