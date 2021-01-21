@extends('webpanel.layouts.base')
@section('title')
    Factory Order
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Add Factory Orders</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')

        <form method="post" action="{{ sysRoute('factoryorders.store') }}" class="ajaxForm form-horizontal">
            <div class="table-responsive">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="hpanel">
                            <div class="panel-body">
                                <div class="col-md-3">
                                    <label for="">Factory Name:</label>
                                    <div>
                                        <input type="text" class="form-control" name="factory_name" value="{{ old('factory_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Order Number:</label>
                                    <div>
                                        <input type="text" class="form-control" name="OID" value="{{ old('OID') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Delivery Date:</label>
                                    <div>
                                        <input type="text" class="form-control dp" name="delivery_date"
                                               value="{{ old('delivery_date') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <br/>
                                    <input class="btn btn-warning btn-sm" type="submit" name="save" value="Order">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($products as $product)
                        <input type="hidden" name="buying_price[{{ $product->id }}]" value="{{ $product->price }}">
                        <div class="col-md-4">
                            <div class="product-container" style="margin-bottom:50px;">
                                <a href="#" class="btn btn-xs add-row" style="margin-left:10px;"><i class="icon-plus-circle"></i> </a>

                                <label>{{ $product->name }}</label>
                                <table class="table" style="width:375px;">
                                    <tbody class="variant-container">
                                    <tr>
                                        <td>
                                            <select class="form-control lazySelector blank"
                                                    name="variants[{{ $product->id }}][]">
                                                <option value="">Select Variant</option>
                                                {!! OptionsView($product->variants()->with('color')->get(), 'id', function($item){
                                                    return @$item->color->name;
                                                }) !!}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control blank" placeholder="Quantity"
                                                   name="qty[{{ $product->id }}][]" value=""
                                                   onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                        </td>
                                        <td>
                                            <a class="remove-row text-danger" title="remove"><i class="icon-remove3"></i> </a>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </form>
    </div>

@stop


@section('scripts')
    <script>
        (function ($, window, undefined) {
            $(function () {


                $(".add-row").click(function (e) {
                    var $container = $(this).closest('.product-container').find('.variant-container');
                    var row = $container.find('tr:last').clone(true);
                    row.find('.blank').val('');
                    $container.append(row);

                    e.preventDefault();
                    return false;
                });


                $(document).on('click', '.remove-row', function (e) {
                    var $container = $(this).closest('.product-container').find('.variant-container');
                    if ($container.find('tr').length > 1) {
                        if (confirm("Are you sure you want to remove this varinat?")) {
                            $(this).closest('tr').remove();
                        }
                    }
                })

            });
        })(jQuery, window);

    </script>

@stop