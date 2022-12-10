<table>
    <thead style="background: rgb(77, 77, 209)">
        <tr>
            <th>NO</th>
            <th>USERNAME</th>
            <th>NAMA</th>
            <th>AREA</th>
            <th>SUBAREA</th>
            <th>JABATAN</th>
            <th>OUTLET</th>
            <th>ALAMAT CHECKIN</th>
            <th>TIME CHECKIN</th>
            <th>PHOTO CHECKIN</th>
            <th>LATITUDE CHECKIN</th>
            <th>LONGITUDE CHECKIN</th>
            <th>ALAMAT CHECKOUT</th>
            <th>PHOTO CHECKOUT</th>
            <th>TIME CHECKOUT</th>
            <th>LATITUDE CHECKOUT</th>
            <th>LONGITUDE CHECKOUT</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($decode as $item)
            <tr>
                <td>{{ $item->nomor }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->area }}</td>
                <td>{{ $item->subarea }}</td>
                <td>{{ $item->jabatan }}</td>
                <td>{{ $item->outlet }}</td>
                <td>{{ $item->alamat_in }}</td>
                <td>{{ $item->time_checkin }}</td>
                <td></td>
                <td>{{ $item->lat_in }}</td>
                <td>{{ $item->long_in }}</td>
                <td>{{ $item->alamat_out }}</td>
                <td></td>
                <td>{{ $item->time_checkout }}</td>
                <td>{{ $item->lat_out }}</td>
                <td>{{ $item->long_out }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
