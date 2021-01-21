<?php $i = 1; ?>
@foreach($withdraws as $k => $withdraw)
    <tr class="deleteBox">
        <td>{{ $k + 1  }}</td>
        <td>{{ $withdraw->WID }}</td>
        <td>
            {{ $withdraw->createdDate('d/m/Y') }}
        </td>
        <td>
            {!! @\App\Modules\Withdraws\Withdraw::$statusLabel[$withdraw->status] !!}
        </td>
        <td>{{ $withdraw->remarks }}</td>
        <td>{{ currency(@$withdraw->amount) }}</td>
        @if(auth()->user()->isAdmin())
            <td>{{ @$withdraw->creator ? $withdraw->creator->fullName() : '' }}</td>
            <td>
                @if($withdraw->isPending())
                    <a class="changeStatus"
                       data-id="{{ encryptIt($withdraw->id) }}"
                       data-status="{{ $withdraw->status }}"><i class="icon-wrench2"></i> </a>
                @endif
            </td>
        @endif
    </tr>
    <?php $i++; ?>
@endforeach