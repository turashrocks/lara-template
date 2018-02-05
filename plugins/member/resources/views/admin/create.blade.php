@extends('bases::layouts.master')
@section('content')
    {!! Form::open(['route' => 'member.create']) !!}
    @php do_action(BASE_ACTION_CREATE_CONTENT_NOTIFICATION, MEMBER_MODULE_SCREEN_NAME, request(), null) @endphp
    <div class="row">
        <div class="col-md-9">
            <div class="main-form">
                <div class="form-body">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label for="name" class="control-label required">{{ __('Name') }}</label>
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('Name'), 'data-counter' => 120]) !!}
                        {!! Form::error('name', $errors) !!}
                    </div>
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        <label for="email" class="control-label required">{{ __('Email') }}</label>
                        {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'placeholder' => __('Email'), 'data-counter' => 120]) !!}
                        {!! Form::error('email', $errors) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label required" for="password">{{ __('Password') }}</label>
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'data-counter' => 60]) !!}
                        {!! Form::error('password', $errors) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label required" for="password_confirmation">{{ __('Re-type password') }}</label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'data-counter' => 60]) !!}
                        {!! Form::error('password_confirmation', $errors) !!}
                    </div>
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, MEMBER_MODULE_SCREEN_NAME, 'advanced') @endphp
        </div>
        <div class="col-md-3 right-sidebar">
            @include('bases::elements.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, MEMBER_MODULE_SCREEN_NAME, 'top') @endphp
            @php do_action(BASE_ACTION_META_BOXES, MEMBER_MODULE_SCREEN_NAME, 'side') @endphp
        </div>
    </div>
    {!! Form::close() !!}
@stop

@push('footer')
    @php
        Assets::addAppModule(['form-validation']);
    @endphp
    {!! JsValidator::formRequest(\Botble\Member\Http\Requests\MemberCreateRequest::class) !!}
@endpush
