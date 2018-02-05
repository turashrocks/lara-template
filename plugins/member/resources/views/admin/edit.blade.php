@extends('bases::layouts.master')
@section('content')
    {!! Form::open(['route' => ['member.edit', $member->id]]) !!}
    @php do_action(BASE_ACTION_CREATE_CONTENT_NOTIFICATION, MEMBER_MODULE_SCREEN_NAME, request(), $member) @endphp
    <div class="row">
        <div class="col-md-9">
            <div class="main-form">
                <div class="form-body">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label for="name" class="control-label required">{{ __('Name') }}</label>
                        {!! Form::text('name', $member->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('Name'), 'data-counter' => 120]) !!}
                        {!! Form::error('name', $errors) !!}
                    </div>
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        <label for="email" class="control-label required">{{ __('Email') }}</label>
                        {!! Form::text('email', $member->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => __('Email'), 'data-counter' => 120]) !!}
                        {!! Form::error('email', $errors) !!}
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="styled" name="is_change_password" id="is_change_password" value="1" @if (old('is_change_password') == 1) checked="checked" @endif>
                        <label for="is_change_password">{{ __('Change password?') }}</label>
                    </div>
                    <div class="password-group @if (!$errors->has('password') && !$errors->has('password_confirmation')) hidden @endif">
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
            </div>
            @php do_action(BASE_ACTION_META_BOXES, MEMBER_MODULE_SCREEN_NAME, 'advanced', $member) @endphp
        </div>
        <div class="col-md-3 right-sidebar">
            @include('bases::elements.form-actions')
            @php do_action(BASE_ACTION_META_BOXES, MEMBER_MODULE_SCREEN_NAME, 'top', $member) @endphp
            @php do_action(BASE_ACTION_META_BOXES, MEMBER_MODULE_SCREEN_NAME, 'side', $member) @endphp
        </div>
    </div>
    {!! Form::close() !!}
@stop

@push('footer')
    @php
        Assets::addAppModule(['form-validation']);
    @endphp
    {!! JsValidator::formRequest(\Botble\Member\Http\Requests\MemberEditRequest::class) !!}
    <script>
        $(document).ready(function () {
            $(document).on('click', '#is_change_password', function () {
                if ($(this).is(':checked')) {
                    $('.password-group').fadeIn();
                    $('.password-group').removeClass('hidden');
                } else {
                    $('.password-group').fadeOut();
                    $('.password-group').addClass('hidden');
                }
            });
        });
    </script>
@endpush
