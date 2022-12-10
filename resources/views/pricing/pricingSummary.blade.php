<table>
    <tr>
        <td colspan="4" style="text-align: center;"><b>DANCOW</b></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;"><b>SKUs</b></td>
        <td style="text-align: center;"><b>{{$tgl_ambil}}</b></td>
    </tr>
    @foreach ($records as $item)
    @if ($item->kategori == 'DANCOW')
        <tr>
            <td>{{ $item->alias }}</td>
            <td>{{ $item->varian }}</td>
            <td>{{ $item->gramasi }}</td>
            <td>{{ $item->harga }}</td>
        </tr>
    @endif
    @endforeach

    {{-- Spasi --}}
    <tr><td colspan="4"></td></tr>

    <tr>
        <td colspan="4" style="text-align: center;"><b>SGM</b></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;"><b>SKUs</b></td>
        <td style="text-align: center;"><b>{{$tgl_ambil}}</b></td>
    </tr>
    @foreach ($records as $item)
    @if ($item->kategori == 'SGM')
        <tr>
            <td>{{ $item->alias }}</td>
            <td>{{ $item->varian }}</td>
            <td>{{ $item->gramasi }}</td>
            <td>{{ $item->harga }}</td>
        </tr>
    @endif
    @endforeach

    {{-- Spasi --}}
    <tr><td colspan="4"></td></tr>

    <tr>
        <td colspan="4" style="text-align: center;"><b>BEBELAC</b></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;"><b>SKUs</b></td>
        <td style="text-align: center;"><b>{{$tgl_ambil}}</b></td>
    </tr>
    @foreach ($records as $item)
    @if ($item->kategori == 'BEBELAC')
        <tr>
            <td>{{ $item->alias }}</td>
            <td>{{ $item->varian }}</td>
            <td>{{ $item->gramasi }}</td>
            <td>{{ $item->harga }}</td>
        </tr>
    @endif
    @endforeach

    {{-- Spasi --}}
    <tr><td colspan="4"></td></tr>

    <tr>
        <td colspan="4" style="text-align: center;"><b>FRISIAN FLAG</b></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;"><b>SKUs</b></td>
        <td style="text-align: center;"><b>{{$tgl_ambil}}</b></td>
    </tr>
    @foreach ($records as $item)
    @if ($item->kategori == 'FRISIAN FLAG')
        <tr>
            <td>{{ $item->alias }}</td>
            <td>{{ $item->varian }}</td>
            <td>{{ $item->gramasi }}</td>
            <td>{{ $item->harga }}</td>
        </tr>
    @endif
    @endforeach
</table>
