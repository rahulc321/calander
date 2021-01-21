<?php if(!$factoryOrder->isReceived()): ?>
    <br>
    <?php echo btn('Add To Stock'); ?>

    <input type="submit" name="close" class="btn btn-primary" value="Add To Stock And Close">
<?php endif; ?>