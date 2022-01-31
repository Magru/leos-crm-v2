<table style="text-align: center; direction: rtl;">
    @foreach($data as $d)
    <tr>
        <td style="text-align: center; direction: rtl;">
            {{ $d->value }}
        </td>
        <td style="text-align: center; direction: rtl;">
            {{ $d->title }}
        </td>
    </tr>
    @endforeach
</table>
