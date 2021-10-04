@if ($flashMessage = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        {{ $flashMessage }}
    </div>
@endif

@if ($flashMessages = Session::get('successes'))
    @foreach($flashMessages as $flashMessage)
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            {{ $flashMessage }}
        </div>
    @endforeach
@endif

@if ($flashMessage = Session::get('fail'))
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        {{ $flashMessage }}
    </div>
@endif

@if ($flashMessages = Session::get('fails'))
    @foreach($flashMessages as $flashMessage)
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            {{ $flashMessage }}
        </div>
    @endforeach
@endif

@if ($flashMessage = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        {{ $flashMessage }}
    </div>
@endif

@if ($flashMessage = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        {{ $flashMessage }}
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