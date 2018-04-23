<div class="box-body">
    {!! Form::i18nInput('title', trans('activity::categories.form.title'), $errors, $lang, $category, ['data-slug'=>'source']) !!}

    {!! Form::i18nInput('slug', trans('activity::categories.form.slug'), $errors, $lang, $category, ['data-slug'=>'target']) !!}
</div>
