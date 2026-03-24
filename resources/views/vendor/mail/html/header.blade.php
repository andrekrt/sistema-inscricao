@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" style="height: 70px;">
</a>
</td>
</tr>
