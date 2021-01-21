;
(function ($, window, undefined) {
    $(function () {
        $(".bulkActionForm").submit(function (e) {

            /*check if atleast 1 item is checked*/
            var selectedItems = $(".itemId:checked");
            if (selectedItems.length == 0) {
                alert('Please select at least one item');
                e.preventDefault();
                return false;
            }
            processBulkAction($(".bulkAction option:selected"), selectedItems, e);

            /*console.log($(".bulkAction option:selected").attr('data-action'));
             console.log($(".bulkAction option:selected").data('action'));*/
            /*e.preventDefault();*/
        });
    });


    function processBulkAction($action, $selectedItems, event) {
        if ($action.data('itemsContainer')) {
            console.log($action.data('itemsContainer'));
            inflateIdsTo($($action.data('itemsContainer')), $selectedItems);
        }
        if ($action.data('action')) {
            console.log($action.data('action'));
            $($action.data('action')).modal();

            event.preventDefault();
        }
    }


    function inflateIdsTo($container, $ids){
        $container.empty();
        $ids.each(function(){
            $container.append('<input type="hidden" name="id[]" value="'+$(this).val()+'">');
        });
    }
})(jQuery, window);