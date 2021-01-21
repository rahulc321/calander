@extends('webpanel.layouts.base')
@section('title')
    Add Product
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Add Product</h3>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Add</h6>
                    </div>
                    <div class="panel-body">
                        <form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
                              action="<?php echo URL::route('webpanel.products.store'); ?>"
                              data-notification-animation="1"
                              role="form" data-result-container="#notificationArea" id="Product_info">

                            <div class="form-group">
                                <label class="col-md-2" for="name">Product Name:</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ Input::get('name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="collection">Collection:</label>
                                <div class="col-md-5">
                                    <select class="form-control" id="collection" name="collection_id"
                                            data-selected="{{ Input::get('collection') }}">
                                        <option value="">Select</option>
                                        {!! OptionsView(\App\Modules\Collections\Collection::all(), 'id', 'name') !!}
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="height">Height:</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" id="height" name="height" value="{{ Input::get('height') }}">
                                </div>
                                <label class="col-md-1" for="length">Length:</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" id="length" name="length" value="{{ Input::get('length') }}">
                                </div>
                                <label class="col-md-1" for="depth">Depth:</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" id="depth" name="depth" value="{{ Input::get('depth') }}">
                                </div>

                            </div>

                            <div class="form-group">
                                <label class=" col-md-2" for="number_of_pockets">Number of Pockets:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="number_of_pockets"
                                           name="number_of_pockets" value="{{ Input::get('number_of_pockets') }}">
                                </div>
                                <label class=" col-md-1" for="number_of_compartments">Number of<br/>Compartments:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="number_of_compartments" name="number_of_compartments" value="{{ Input::get('number_of_compartments') }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2" for="price">Price:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="price" name="price" value="{{ Input::get('price') }}">
                                </div>
                                <label class=" col-md-2" for="buying_price">Buying Price:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="buying_price" name="buying_price" value="{{ Input::get('buying_price') }}">
                                </div>
                            </div>  

                            <div class="form-group">
                                <label class="col-md-2" for="webshop_price">Webshop Price € :</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="webshop_price" name="webshop_price" value="{{Input::get('webshop_price') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="photo">Photo(s):</label>
                                <div class="col-md-5">
                                    <input type="file" name="photo[]" class="filestyle" multiple>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="web_photo">Webshop Photo:</label>
                                <div class="col-md-5">
                                    <input type="file" name="web_photo[]" id="web_photo" class="filestyle">
                                </div>
                            </div>
                             <div class="ph"></div>
                            <div class="form-group">
                                <div class="col-md-6" style="float: right;">
                                <input type="button" id="add-more" name="add-more" class="btn btn-primary" value="Add More">
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-md-2" for="seo_title">SEO | Title:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{Input::get('seo_title') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="seo_description">SEO | Description:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="seo_description" name="seo_description" value="{{Input::get('seo_description') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="seo_keywords">SEO | Keywords:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" value="{{Input::get('seo_keywords') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2" for="description">Description:</label>
                                <div class="col-md-5">
                                <textarea class="form-control" id="description" name="description" style="height: 80px;">{{ Input::get('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2">Variants:</label>
                                <div class="col-md-6">
                                    <a class="btn btn-primary" id="add-row" title="add new Variant">+ Add</a>
                                    <br/><br/>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th style="width:200px;">SKU</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="variant-container">
                                        <tr>
                                            <td>
                                                <select class="form-control lazySelector blank" required
                                                        name="colors[]">
                                                    <option value="">Select Color</option>
                                                    {!! OptionsView(\App\Modules\Products\Color::all(), 'id', 'name') !!}
                                                </select>
                                            </td>

                                            <td>
                                                <input type="hidden" name="stocks[]" value="0">
                                                <input type="text" class="form-control blank" name="sku[]">
                                            </td>
                                            <td>
                                                <a class="remove-row text-danger" title="remove"><i class="icon-remove3"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <button type="submit" id="add_product" class="btn btn-warning btn-sm waves-effect">Add Product
                                    </button>
                                </div>
                            </div>

                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            
            var url= ""{{ URL::route('webpanel.products.store') }}";
            alert(url);
            
            $('#add_product').click(function(){
           
            var formdata = new FormData(document.getElementById('Product_info'));
            //console.log(formdata);
            $.ajax({
              type:'post',
              url:"{{ URL::route('webpanel.products.store') }}",
              data:{"_token":"{{ csrf_token() }}",'formdata':formdata},
              contentType: false,
              processData: false, 
              success:function(ress){
               //alert(url);
              }
            });
        });
        });

         var next= 0;
        $("#add-more").click(function(){          
          
           var newInput = '<div class="form-group"><label class="col-md-2" for="web_photo"></label><div class="col-md-5"><input type="file" name="web_photo[]" id="web_photo'+ next +'" class="filestyle"></div></div>';
           $('.ph').append(newInput); 
           next+= 1; 
        });
        
        (function ($, window, undefined) {
            $(function () {
                var $container = $("#variant-container");

                $("#add-row").click(function (e) {
                    var row = $container.find('tr:last').clone(true);
                    row.find('.blank').val('');
                    $container.append(row);

                    e.preventDefault();
                    return false;
                });


                $container.on('click', '.remove-row', function (e) {
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