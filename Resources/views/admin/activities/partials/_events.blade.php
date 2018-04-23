@php
    $location_id = isset(array_keys($locationLists)[0]) ? array_keys($locationLists)[0] : null;
    if(isset($activity)) {
        $events_data = $activity->events()->get()->map(function($event){
            return [
                'event_id'    => $event->id,
                'location_id' => $event->location_id,
                'event_at'    => $event->event_at->format('d.m.Y H:i'),
                'ticket_url'  => $event->ticket_url
            ];
        });
        $events = is_array(old('events')) && old('events') ? old('events', $events_data) : $events_data;
    } else {
        $events = is_array(old('events')) && old('events') ? old('events') : null;
    }
    if($events) $events = json_encode($events);
@endphp

<div class="box-body row">
    <div v-for="(event, key) in events">
        <input :name="'events['+key+'][event_id]'" type="hidden" :value="event.event_id" v-model="event.event_id" />
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label v-if="key == 0" for="location_id">{{ trans('activity::activities.form.location_id') }}</label>
                        <select :name="'events['+key+'][location_id]'" class="form-control" v-model="event.location_id">
                            @foreach($locationLists as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label v-if="key == 0" for="event_at">{{ trans('activity::activities.form.event_at') }}</label>
                        <date-picker :name="'events['+key+'][event_at]'" v-model="event.event_at" :config="config.datetime" placeholder="{{ trans('activity::activities.form.event_at') }}"></date-picker>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label v-if="key == 0" for="ticket_url">{{ trans('activity::activities.form.ticket_url') }}</label>
                        <input :name="'events['+key+'][ticket_url]'" class="form-control" v-model="event.ticket_url" />
                    </div>
                </div>
                <div class="col-md-1" :style="key == 0 ? 'padding-top:35px' : ''">
                    <a class="btn btn-xs btn-default btn-flat" @click="addRow(key)" v-if="events.length < 10"><i class="fa fa-plus"></i></a>
                    <a class="btn btn-xs btn-default btn-flat" @click="removeRow(key)" v-if="key > 0"><i class="fa fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($errors->get('events.*'))>0)
    <div class="box-body">
        <div class="alert alert-danger">
            @foreach($errors->get('events.*') as $message)
                <p>{{ array_first($message) }}</p>
            @endforeach
        </div>
    </div>
@endif
@push('js-stack')
    <script src="{!! Module::asset('activity:js/moment.min.js') !!}"></script>
    <script src="{!! Module::asset('activity:js/tr.js') !!}"></script>
    <script src="{!! Module::asset('activity:js/bootstrap-datetimepicker.min.js') !!}"></script>
    <link rel="stylesheet" href="{!! Module::asset('activity:css/bootstrap-datetimepicker.min.css') !!}" />
    <script src="{!! Module::asset('activity:js/vue.js') !!}"></script>
    <script src="{!! Module::asset('activity:js/vue-bootstrap-datetimepicker.min.js') !!}"></script>
    <script>
        Vue.component('date-picker', VueBootstrapDatetimePicker.default);
        new Vue({
            el: '#app',
            data: {
                config: {
                    date: {
                        format: 'DD.MM.YYYY',
                        extraFormats: [moment.ISO_8601, 'DD.MM.YYYY']
                    },
                    datetime: {
                        format: 'DD.MM.YYYY HH:mm',
                        sideBySide: true,
                        extraFormats: [moment.ISO_8601, 'DD.MM.YYYY']
                    },
                    year: {
                        format: 'YYYY',
                        extraFormats: [moment.ISO_8601, 'YYYY']
                    },
                    hour: {
                        format: 'HH:mm',
                        stepping: 15,
                        extraFormats: [moment.ISO_8601, 'HH:mm']
                    }
                },
                defaults: {
                  location_id: '{{ $location_id }}'
                },
                events: {!! isset($events) ? $events : '[]' !!}
            },
            mounted: function () {
              if(this.events.length === 0) {
                  this.addRow(0);
              }
            },
            methods: {
                addRow: function (index) {
                    this.events.splice(index + 1, 0, {});
                    this.events[index].location_id = this.defaults.location_id;
                    this.events[index+1].location_id = this.defaults.location_id;
                },
                removeRow: function (index) {
                    this.events.splice(index, 1);
                }
            }
        });
    </script>
@endpush