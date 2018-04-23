@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('activity::activities.title.create activity') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li>
            <a href="{{ route('admin.activity.activity.index') }}">{{ trans('activity::activities.title.activities') }}</a>
        </li>
        <li class="active">{{ trans('activity::activities.title.create activity') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.activity.activity.store'], 'method' => 'post']) !!}
    <div class="row" id="app">
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('activity::admin.activities.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    @includeIf('activity::admin.activities.partials._events')

                    <div class="box-footer">
                        <button type="submit"
                                class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button"
                                type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat"
                           href="{{ route('admin.activity.activity.index')}}"><i
                                    class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    {!! Form::normalSelect('category_id', trans('activity::activities.form.category_id'), $errors, $categoryLists) !!}

                    {!! Form::normalInput('sorting', trans('activity::activities.form.sorting'), $errors) !!}

                    {!! Form::normalInput('video_url', trans('activity::activities.form.video_url'), $errors) !!}

                    {!! Form::normalCheckbox('status', trans('activity::activities.form.status'), $errors) !!}

                    @mediaSingle('activityCoverImage', null, null, trans('activity::activities.form.cover'))

                    @mediaMultiple('activityImage', null, null, trans('activity::activities.form.image'))
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "<?= route('admin.activity.activity.index') ?>"}
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
