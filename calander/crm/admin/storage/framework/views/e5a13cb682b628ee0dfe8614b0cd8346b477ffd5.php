<?php $i = 1; ?>
<?php foreach($colors as $color): ?>
    <tr class="deleteBox">
        <td><?php echo e($i); ?></td>
        <td>
            <div style="background: <?php echo e($color->hex_code); ?>; width:20px; height:20px;"></div>

        <td><?php echo e($color->name); ?></td>
        <td><?php echo e($color->hex_code); ?></td>
        <td>
            <a title="Edit" href="<?php echo URL::route('webpanel.colors.edit', array('id' => $color->id)); ?>"
               class="btn btn-xs btn-primary modalFetcher" data-target=".remoteModal"><i class="icon-pencil3"></i></a>
            <a title="Delete"
               href="#"
               class="btn btn-xs btn-danger ajaxdelete"
               data-id="<?php echo $color->id; ?>"
               data-url="<?php echo url('webpanel/colors/delete/' . $color->id); ?>"
               data-token="<?php echo urlencode(md5($color->id)); ?>"><i class="icon-remove3"></i></a>
        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>