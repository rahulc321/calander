<?php $i = 1; ?>
<?php foreach($currencies as $currency): ?>
    <tr class="deleteBox">
        <td><?php echo e($i); ?></td>
        <td><?php echo e($currency->name); ?></td>
        <td><?php echo e($currency->symbol); ?></td>
        <td><?php echo e($currency->conversion); ?></td>
        <td>
            <?php if($currency->symbol !== 'kr'): ?>
                <a title="Edit" href="<?php echo sysRoute('currencies.edit', array('id' => $currency->id)); ?>"
                   class="btn btn-xs btn-primary modalFetcher" data-target=".remoteModal"><i
                            class="icon-pencil3"></i></a>
                <a title="Delete"
                   href="#"
                   class="btn btn-xs btn-danger ajaxdelete"
                   data-id="<?php echo $currency->id; ?>"
                   data-url="<?php echo url('webpanel/currencies/delete/' . $currency->id); ?>"
                   data-token="<?php echo urlencode(md5($currency->id)); ?>"><i class="icon-remove3"></i></a>
            <?php endif; ?>
        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>