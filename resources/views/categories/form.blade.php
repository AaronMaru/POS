<div class="row">
    <div class="col-md-6">
        {!! Form::file('image', null) !!}
    </div>

    <div class="col-md-6">
        {!! BootForm::text('name') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! BootForm::text('slug') !!}
    </div>
    <div class="col-md-6">
        {!! BootForm::text('parent_id') !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {!! link_to_route($route_prefix . '.index', 'Back to list', [], ['class' => 'btn btn-default']) !!}
        {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}
    </div>
</div>
