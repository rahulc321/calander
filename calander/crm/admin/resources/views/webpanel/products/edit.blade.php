@extends('webpanel.layouts.base')
@section('title')
    Edit Product
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Update Product1 </h3>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Update</h6>
                    </div>
                    <div class="panel-body">
                        <form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
                              action="<?php echo sysRoute('products.update', $product->id); ?>"
                              data-notification-animation="1"
                              role="form" data-result-container="#notificationArea" id="Product_info">
                            <input type="hidden" name="_method" value="put">

                            <div class="form-group">
                                <label class="col-md-2" for="name">Product Name:</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="collection">Collection:</label>
                                <div class="col-md-5">
                                    <select class="form-control lazySelector" id="collection_id"
                                            name="collection_id"
                                            data-selected="{{ $product->collection_id }}">
                                        <option value="">Select</option>
                                        {!! OptionsView(\App\Modules\Collections\Collection::all(), 'id', 'name') !!}
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="height">Height:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="height" name="height" value="{{ $product->height }}">
                                </div>
                                <label class="col-md-1" for="length">Length:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="length" name="length" value="{{ $product->length }}">
                                </div>
                                <label class="col-md-1" for="depth">Depth:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="depth" name="depth" value="{{ $product->depth }}">
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="number_of_pockets">Number of Pockets:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="number_of_pockets"
                                           name="number_of_pockets" value="{{ $product->number_of_pockets }}">
                                </div>

                                <label class="col-md-1" for="number_of_compartments">Number of <br/>Compartments:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="number_of_compartments" name="number_of_compartments"
                                           value="{{ $product->number_of_compartments }}">
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="price">Price:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
                                </div>
                                <label class="col-md-1" for="buying_price">Buying Price:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="buying_price" name="buying_price" value="{{ $product->buying_price }}">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-2" for="webshop_price">Webshop Price:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="webshop_price" name="webshop_price" value="{{ $product->web_shop_price }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="photo">Photo(s):</label>
                                <div class="col-md-5">
                                    <input type="file" name="photo[]" class="filestyle" multiple>
                                </div>
                            </div>

                            <div class="deleteArena row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="row">
                                        @if($product->photos)
                                            @foreach($product->photos as $photo)
                                                <div class="deleteBox col-md-2" style="padding-bottom: 10px;">
                                                    <img src="{{ $photo->getThumbUrl() }}" class="img-thumbnail"><br>
                                                    <a class="ajaxdelete imgpos"
                                                       data-url="{{ url('attachments/delete/'.encrypt($photo->id)) }}"><i class="icon-remove3"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                       <!--  @if($multi_photo)
                                        @foreach($multi_photo as $value)
                                         <div class="deleteBox col-md-2" style="padding-bottom: 10px;">
                                                    <img src="{{ url('/') }}/webshop_Images/{{$value->image}}" class="img-thumbnail"><br>
                                                    <a class="ajaxdelete imgpos"><i class="icon-remove3"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif   -->
                                    </div>
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
                                
                                <div class="deleteArena row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <!-- @if($product->photos)
                                            @foreach($product->photos as $photo)
                                                <div class="deleteBox col-md-2" style="padding-bottom: 10px;">
                                                    <img src="{{ $photo->getThumbUrl() }}" class="img-thumbnail"><br>
                                                    <a class="ajaxdelete imgpos"
                                                       data-url="{{ url('attachments/delete/'.encrypt($photo->id)) }}"><i class="icon-remove3"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif -->
                                        @if($multi_photo)
                                        @foreach($multi_photo as $value)
                                         <div class="deleteBox col-md-2" id="tt_{{$value->id}}" data="{{$value->id}}" style="padding-bottom: 10px;">
                                                    <img src="{{ url('/') }}/webshop_Images/{{$value->image}}" class="img-thumbnail"><br>
                                                    <a class="imgpos"
                                                    data="{{$value->id}}"><i class="icon-remove3"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif  
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-md-2" for="seo_title">SEO | Title:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $product->seo_title }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="seo_description">SEO | Description:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="seo_description" name="seo_description" value="{{ $product->seo_description }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="seo_keywords">SEO | Keywords:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" value="{{ $product->seo_keywords }}">
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-md-2" for="description">Description:</label>
                                <div class="col-md-5">
                                    <textarea class="form-control" id="description" name="description" style="height: 85px;">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="">Variants:</label>
                                <div class="col-md-6">
                                    <a class="btn btn-primary" id="add-row" title="add new Variant">+ Add</a>
                                    <br/><br/>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width:175px;">Color</th>
                                            <th style="width:175px;">SKU</th>
                                            <th style="width:175px;">QTY</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="variant-container" class="deleteArena">
                                        @if($product->variants->count() > 0)
                                            @foreach($product->variants as $variant)
                                                <tr class="deleteBox">
                                                    <td>
                                                        <select class="form-control lazySelector blank"  disabled
                                                                name="" data-selected="{{ $variant->color_id }}">
                                                            <option value="">Select Color</option>
                                                            {!! OptionsView(\App\Modules\Products\Color::all(), 'id', 'name') !!}
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control blank" disabled name="" value="{{ $variant->sku }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="stock_qty[{{ $variant->id }}]" value="{{ $variant->qty }}">
                                                    </td>
                                                    <td>
                                                        <a class="ajaxdelete text-danger" title="remove"
                                                        data-url="{{ sysUrl('products/delete-variant/'.encryptIt($variant->id)) }}"
                                                        ><i class="icon-remove3"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                            <tr>
                                                <td>
                                                    <select class="form-control lazySelector blank" required name="colors[]">
                                                        <option value="">Select Color</option>
                                                        {!! OptionsView(\App\Modules\Products\Color::all(), 'id', 'name') !!}
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control blank" name="sku[]">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control blank" name="stocks[]">
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
                                    <button type="submit" class="btn btn-warning btn-sm" id="update_product">Update Product</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('scripts')
    <script>
          $(document).ready(function(){
            $('.imgpos').click(function(){
            var id= $(this).attr('data');
            // var data= $('$tt_'+id).attr
             if(confirm("Are you sure you want to delete this image?")){
                $.ajax({
                   method:'post',
                   url:"{{ url('/webpanel/delete-image') }}",
                   data:{"_token":"{{ csrf_token() }}",'id':id},
                   success:function(response){
                      if(response == 1){
                         $('#tt_'+id).remove();
                      }
                   }
                });
             }
            });
              $('#update_product').click(function(){
           
            var formdata = new FormData('#Product_info');
            console.log(formdata);
            $.ajax({
              type:'post',
              url:"{{sysRoute('products.update', $product->id)}}",
              data:{"_token":"{{ csrf_token() }}",'formdata':formdata},
              contentType: false,
              processData: false, 
              success:function(ress){
               alert(url);
              }
            });
        });
               var next= 0;
        $("#add-more").click(function(){          
          
           var newInput = '<div class="form-group"><label class="col-md-2"></label><div class="col-md-5"><input type="file" name="web_photo[]" id="web_photo'+ next +'" class="filestyle"></div></div>';
           $('.ph').append(newInput); 
           next+= 1; 
        });
          });
        (function ($, window, undefined) {
            $(function () {
                var $container = $("#variant-container");
                var $row = $container.find('tr:last').clone(true);

                $container.find('tr:last').remove();

                $("#add-row").click(function (e) {
                    var row = $row.clone(true);
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