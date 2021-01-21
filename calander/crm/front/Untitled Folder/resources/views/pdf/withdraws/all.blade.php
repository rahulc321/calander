@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <h4 style="text-align: center">WITHDRAW</h4>

    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>SN</td>
            <td>ID</td>
            <td>Date</td>
            <td>Status</td>
            <td>Remarks</td>
            <td>Amount</td>
            @if(auth()->user()->isAdmin())
                <td>Requested By</td>
            @endif
        </tr>
        <tbody>
        <?php $i = 1; ?>
        @foreach($withdraws as $k => $withdraw)
            <tr class="deleteBox">
                <td>{{ $k + 1  }}</td>
                <td>{{ $withdraw->WID }}</td>
                <td>
                    {{ $withdraw->createdDate() }}
                </td>
                <td>
                    {!! @\App\Modules\Withdraws\Withdraw::$statusLabel[$withdraw->status] !!}
                </td>
                <td>{{ $withdraw->remarks }}</td>
                <td>{{ currency(@$withdraw->amount) }}</td>
                @if(auth()->user()->isAdmin())
                    <td>{{ @$withdraw->creator ? $withdraw->creator->fullName() : '' }}</td>
                @endif
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

@stop