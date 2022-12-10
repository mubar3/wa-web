<?php
    use App\Http\Controllers\UserRetentionController;
?>

<table class="datatable table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            @if($jenis == 'byRegion')
                <th rowspan="2">Region</th>
                <th rowspan="2">#of BP</th>
            @elseif($jenis == 'byArea')
                <th rowspan="2">Kota</th>
                <th rowspan="2">#of BP</th>
            @elseif($jenis == 'byTC')
                <th rowspan="2">TC</th>
                <th rowspan="2">#of BP</th>
            @elseif($jenis == 'byNA')
                <th rowspan="2">TC</th>
                <th rowspan="2">NA</th>
            @endif
            <th colspan="4">New User</th>
            <th colspan="2">Retention M+1</th>
            <th colspan="2">Retention M+2</th>
            <th colspan="2">Retention M+3</th>
            <th colspan="4">SKU</th>
            <th rowspan="2">Subtotal Gramasi</th>
        </tr>
        <tr>
            <th>Target</th>
            <th>Actual Register</th>
            <th>Actual Submission</th>
            <th>%</th>
            <th>Actual</th>
            <th>%</th>
            <th>Actual</th>
            <th>%</th>
            <th>Actual</th>
            <th>%</th>
            <th>200</th>
            <th>400</th>
            <th>800</th>
            <th>1000</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $i=>$row)
    <tr>
        <td>{{$i+1}}</td>
        @if($jenis == 'byRegion')
            <td>{{$row['region']}}</td>
            <td>{{$row['bp']}}</td>
        @elseif($jenis == 'byArea')
            <td>{{$row['area']}}</td>
            <td>{{$row['bp']}}</td>
        @elseif($jenis == 'byTC')
            <td>{{$row['spv']}}</td>
            <td>{{$row['bp']}}</td>
        @elseif($jenis == 'byNA')
            <td>{{$row['spv']}}</td>
            <td>{{$row['nama']}}</td>
        @endif
        <td>{{$row['target']}}</td>
        <td>{{$row['new_user']}}</td>
        <td>{{$row['submission']}}</td>
        <td>{{UserRetentionController::countPercent($row['target'], $row['submission'])}}</td>
        <td>{{$row['m1']}}</td>
        <td>{{UserRetentionController::countPercent($row['submission'], $row['m1'])}}</td>
        <td>{{$row['total_m2']}}</td>
        <td>{{UserRetentionController::countPercent($row['submission'], $row['total_m2'])}}</td>
        @php
        $actual3 = UserRetentionController::countPercent($row['submission'], $row['total_m3']);
        @endphp
        <td>{{$row['total_m3']}}</td>
        <td @if(floatval($actual3) < 35) style="background-color: #FF4444;" @endif>{{UserRetentionController::countPercent($row['submission'], $row['total_m3'])}}</td>
        <td>{{$row['sku_200']}}</td>
        <td>{{$row['sku_400']}}</td>
        <td>{{$row['sku_800']}}</td>
        <td>{{$row['sku_1000']}}</td>
        <td>{{UserRetentionController::countSubTotal($row['sku_200'],$row['sku_400'],$row['sku_800'],$row['sku_1000'])}}</td>
    </tr>
    @endforeach
    </tbody>
</table>