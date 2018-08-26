<input type="hidden" class="js-callback-code" value="{{ $js_callback_code or $current_routename }}" />
<input type="hidden" class="js-page-title" value="{{{ $title }}} | {{ config('app.name') }}" />
<input type="hidden" class="js-url" value="{{ $current_fullurl }}" />

@if(isset($ga))
    <div class="js-ga" style="display:none">
        {!! json_encode($ga) !!}
    </div>
@endif
