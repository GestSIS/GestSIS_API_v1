@if(!Request::ajax())
    @include('layouts.no-ajax')
@else
	@include('layouts.ajax')
@endif