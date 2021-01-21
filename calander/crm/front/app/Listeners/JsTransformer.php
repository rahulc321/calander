<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 4/17/2016
 * Time: 11:34 AM
 */

namespace App\Listeners;


class JsTransformer
{
    public function handle($data)
    {

        echo '<script type="text/javascript">
	    /* <![CDATA[ */';

        foreach ($data as $k => $v) {
            echo 'var ' . $k . '= ' . json_encode($v) . ';';
        }
        echo '/* ]]> */
	    </script>';
    }
}