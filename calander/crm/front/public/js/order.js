;(function($, window, undefined){
    var grandTotal = 0;
    $(function(){
        $(document).on('change', ".fireCommander", function(){
            fireChanged();
        });

        $(document).on('click', '.deleteRow', function(){
            if(confirm("Are you sure you want to remove this item from current Order ?")){
                $(this).closest('tr').remove();
            }
            e.preventDefault();
            return false;
        })
    });


    function fireChanged(){
        $("#orderTable tbody tr").each(function(){
            var qty = parseFloat($(this).find('.qty').val());
            console.log(qty);
            var price = parseFloat($(this).find('.price').val());
            console.log(price);
            var total = qty * price;
            console.log(total);
            $(this).find('.total').text(total.toFixed(2)).addClass('label label-info');
            grandTotal += total;

            $(".grandTotal").text(grandTotal.toFixed(2)).addClass('label label-success');
        });
    }
})(jQuery, window);