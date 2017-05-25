<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td align="center" valign="top" style="padding:0">
                        {{--<img src="{{ $message->embed('assets/img/logo.png') }}">--}}
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        @yield('content')
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding:0; border-top:1px solid #CCC">
                        <a href="{{ config('app.url') }}">{{ str_replace('http://', 'www.', config('app.url')) }}</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
