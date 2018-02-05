@extends('bases::layouts.master')
@section('content')
    <div class="portlet light bordered portlet-no-padding">
        <div class="portlet-title">
            <div class="caption">
                <i class="{{ $icon or 'icon-settings' }} font-dark"></i>
                <span class="caption-subject font-dark">{{ $title }}</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                {!! Form::open(['url' => route('custom-fields.import'), 'class' => 'import-field-group']) !!}
                    <input type="file" accept="application/json" class="hidden" id="import_json">
                    {!! $dataTable->table(['class' => 'table table-striped table-hover vertical-middle'], true) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('javascript')
    {!! $dataTable->scripts() !!}
@stop