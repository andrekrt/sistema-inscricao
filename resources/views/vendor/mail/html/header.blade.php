@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block; text-align: center;">
            <img src="https://copa-bacaba.innovakode.com.br/logo.png" alt="{{ config('app.name') }}"
                style="height: 70px; margin-bottom: 10px;">
            <div style="font-size: 18px; font-weight: bold; color: #111;">
                {{ config('app.name') }}
            </div>
        </a>
    </td>
</tr>
