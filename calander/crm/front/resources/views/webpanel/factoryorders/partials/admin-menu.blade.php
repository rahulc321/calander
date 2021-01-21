@if(!$factoryOrder->isReceived())
    <br>
    {!! btn('Add To Stock') !!}
    <input type="submit" name="close" class="btn btn-primary" value="Add To Stock And Close">
@endif