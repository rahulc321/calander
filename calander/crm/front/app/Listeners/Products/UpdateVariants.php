<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/29/16
 * Time: 5:12 PM
 */

namespace App\Listeners\Products;


use App\Modules\Products\Product;
use App\Modules\Products\Variant;

class UpdateVariants
{
    public function handle(Product $product, $data, $isUpdate = true){
        /*pd($data);*/

        if(isset($data['stock_qty'])){
            foreach($data['stock_qty'] as $variantId => $qty){
                $variant = Variant::find($variantId);
                $variant->qty = $qty;
                $variant->save();
            }
        }

        if(isset($data['colors'])){
            foreach($data['colors'] as $k => $color){
                $variant = $product->variants()->firstOrNew([
                    'color_id' => $color
                ]);
                $variant->qty = $data['stocks'][$k];
                $variant->sku = @$data['sku'][$k];
                $variant->save();
            }
        }
    }

}