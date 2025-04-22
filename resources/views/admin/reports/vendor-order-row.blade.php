<tr>
    <td> {{ $row?->vendor?->id }} </td>
    <td> {{ $row?->vendor?->name ?? '-' }} </td>
    <td> {{ $row->code }} </td>
    <td> {{ $row->id }} </td>
    <td> {{ $row->created_at?->toDateString() }} </td>
    {{--  <td> {{ $row->delivered_at?->toDateString() }} </td>  --}}
    <td> {{ customNumberFormat($row->total, 2, '.', '') }} </td>
</tr>
