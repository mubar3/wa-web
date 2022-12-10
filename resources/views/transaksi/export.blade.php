<table>
    <thead>
        <tr>
            <th width="20"  rowspan="2"><b>TC</b></th>
            <th width="24" rowspan="2"><b>NAMA NA</b></th>
            <th width="15" rowspan="2"><b>NIK</b></th>
            <th width="12" rowspan="2"><b>PERIODE</b></th>
            @for ($i = 1; $i <= 31; $i++)
                <th colspan="3" style="text-align:center;"><b>{{ $i }}</b></th>
            @endfor
            <th colspan="3" style="text-align:center;"><b>TOTAL</b></th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 31; $i++)
                <th width="6" style="text-align:center;"><b>NW</b></th>
                <th width="6" style="text-align:center;"><b>FS</b></th>
                <th width="6" style="text-align:center;"><b>ST</b></th>
            @endfor
            <th width="6" style="text-align:center;"><b>NW</b></th>
            <th width="6" style="text-align:center;"><b>FS</b></th>
            <th width="6" style="text-align:center;"><b>ST</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $item)
        <tr>
            <td>{{ $item->spv }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->periode }}</td>

            @for ($i = 0; $i <= 30; $i++)
            <td style="text-align:center;">{{ $item->nw[$i] }}</td>
            <td style="text-align:center;">{{ $item->fs[$i] }}</td>
            <td style="text-align:center;">{{ $item->st[$i] }}</td>
            @endfor

            <td style="text-align:center;">{{ $item->total_nw }}</td>
            <td style="text-align:center;">{{ $item->total_fs }}</td>
            <td style="text-align:center;">{{ $item->total_st }}</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="97"></td>
            <td style="text-align:center;"><b>{{ $grand_nw }}</b></td>
            <td style="text-align:center;"><b>{{ $grand_fs }}</b></td>
            <td style="text-align:center;"><b>{{ $grand_st }}</b></td>
        </tr>
    </tbody>
</table>
