@if ($flashMessage = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <button class="close" data-dismiss="alert"></button>
        <strong>{{ $flashMessage }}</strong>
    </div>
@endif

@if ($flashMessages = Session::get('successes'))
    @foreach($flashMessages as $flashMessage)
        <div class="alert alert-success" role="alert">
            <button class="close" data-dismiss="alert"></button>
            <strong>{{ $flashMessage }}</strong>
        </div>
    @endforeach
@endif

@if ($flashMessage = Session::get('fail'))
    <div class="alert alert-danger" role="alert">
        <button class="close" data-dismiss="alert"></button>
        <strong>{{ $flashMessage }}</strong>
    </div>
@endif

@if ($flashMessages = Session::get('fails'))
    @foreach($flashMessages as $flashMessage)
        <div class="alert alert-danger" role="alert">
            <button class="close" data-dismiss="alert"></button>
            <strong>{{ $flashMessage }}</strong>
        </div>
    @endforeach
@endif

@if ($flashMessage = Session::get('warning'))
    <div class="alert alert-warning" role="alert">
        <button class="close" data-dismiss="alert"></button>
        <strong>{{ $flashMessage }}</strong>
    </div>
@endif

@if ($flashMessage = Session::get('info'))
    <div class="alert alert-info" role="alert">
        <button class="close" data-dismiss="alert"></button>
        <strong>{{ $flashMessage }}</strong>
    </div>
@endif

@if ($flashMessages = Session::get('errors'))
    @foreach($flashMessages->all() as $flashMessage)
        <div class="alert alert-danger" role="alert">
            <button class="close" data-dismiss="alert"></button>
            <strong>{{ $flashMessage }}</strong>
        </div>
    @endforeach
@endif