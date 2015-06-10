<div class="form-group{!! ($errors->has('name')) ? " has-error" : "" !!}">
    {!! Form::label('name', trans('exposia-navigation::navigations.fields.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    @if($errors->has('name'))
    <div class="help-block">
        {!! $errors->first('name') !!}
    </div>
    @endif
</div>

        <button type="submit" class="btn btn-primary">@lang('exposia::global.save')</button>