<?php $i = 1; ?>
@foreach($currencies as $currency)
    <tr class="deleteBox">
        <td>{{ $i }}</td>
        <td>{{ $currency->name }}</td>
        <td>{{ $currency->symbol }}</td>
        <td>{{ $currency->conversion }}</td>
        <td>
            @if($currency->symbol !== 'kr')
                <a title="Edit" href="<?php echo sysRoute('currencies.edit', array('id' => $currency->id)); ?>"
                   class="btn btn-xs btn-primary modalFetcher" data-target=".remoteModal"><i
                            class="icon-pencil3"></i></a>
                <a title="Delete"
                   href="#"
                   class="btn btn-xs btn-danger ajaxdelete"
                   data-id="<?php echo $currency->id; ?>"
                   data-url="<?php echo url('webpanel/currencies/delete/' . $currency->id); ?>"
                   data-token="<?php echo urlencode(md5($currency->id)); ?>"><i class="icon-remove3"></i></a>
            @endif
        </td>
    </tr>
    <?php $i++; ?>
@endforeach