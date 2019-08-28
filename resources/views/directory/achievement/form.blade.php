<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
    {!! Form::label('category', 'Category', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('category', ['gold', 'silver', 'bronze'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('cash') ? 'has-error' : ''}}">
    {!! Form::label('cash', 'Cash', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('cash', null, ['class' => 'form-control']) !!}
        {!! $errors->first('cash', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('coin') ? 'has-error' : ''}}">
    {!! Form::label('coin', 'Coin', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('coin', null, ['class' => 'form-control']) !!}
        {!! $errors->first('coin', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('target') ? 'has-error' : ''}}">
    {!! Form::label('target', 'Target', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('target', null, ['class' => 'form-control']) !!}
        {!! $errors->first('target', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('status', ['enable', 'disable'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
