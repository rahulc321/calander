 <?php 
ob_start();
 header("Content-type: text/css; charset: UTF-8");
 
 
 
$html = ' 
<div class="email_main_div" style="width:700px; margin:auto; background-color:#FFFFFF; min-height:500px;">
<table style="margin-top:14px;color: #333; font-family: sans-serif; font-size: 15px; font-weight: 300; text-align: center; border-collapse: separate; border-spacing: 0; width: 99%;margin: 6px auto;box-shadow:none;">
    <tr>
        <td width="400px;" style="text-align:left; padding:10px;">
            <strong style="font-weight:bold;">https://ansiktsmasker.shop</strong>
        </td>
    </tr>
</table>

<table style="margin-top:14px; margin-top:14px;color: #333; font-family: sans-serif; font-size: 15px; font-weight: 300; text-align: center; border-collapse: separate; border-spacing: 0; width: 99%;margin: 6px auto;box-shadow:none;">
    <tr>
        <td width="350px;" style="text-align:left; padding:10px;">
        <strong style="font-weight:bold;">Faktureingsaddress </strong><br />
        Your shipping address<br />
        Name of the company,<br />
        234, 20th Cross Ejipura, Benglore<br />
        Tel: (+91) 99999 88888<br />
        Email: info@websitename.com<br />
        </td>
        <td style="text-align:left; padding:10px;">
        <strong style="font-weight:bold;">Leveransaddress </strong><br />
        Name of the company,<br />
        234, 20th Cross Ejipura, Benglore<br />
        Tel: (+91) 99999 88888<br />
        Email: info@websitename.com<br />
        </td>
    </tr>
</table>

<table style="margin-top:14px;color: #333; font-family: sans-serif; font-size: 15px; font-weight: 300; text-align: center; border-collapse: separate; border-spacing: 0; width: 99%;margin: 6px auto;box-shadow:none;">
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;">
    <strong style="font-weight:bold;">Kvitto </strong><br />
    </td>
  </tr>
</table>

<table class="item_table" style="border-top: 5px solid #000; color: #333;
  font-family: sans-serif;
  font-size: 15px;
  font-weight: 300;
  /*text-align: center;*/
  border-collapse: separate;
  border-spacing: 0;
  width: 99%;
  margin: 50px auto;text-align:left;">
  
  <tbody style="border-bottom: 1px solid #ccc; padding:10px;">
    <tr>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">Ordernummer</td>
      <td style="border-bottom: 1px solid #ccc; padding:10px;" style="border-bottom: 1px solid #ccc; padding:10px;">55284</td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">Ordernummer</td>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">55284</td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">Ordernummer</td>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">55284</td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">Ordernummer</td>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">55284</td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">Ordernummer</td>
      <td style="border-bottom: 1px solid #ccc; padding:10px;">55284</td>
    </tr>
  </tbody>
</table>
<table style="margin-top:14px;color: #333; font-family: sans-serif; font-size: 15px; font-weight: 300; text-align: center; border-collapse: separate; border-spacing: 0; width: 99%;margin: 6px auto;box-shadow:none; border-bottom: 5px solid #000;">
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <strong style="font-weight:bold;">Produkt </strong><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <strong style="font-weight:bold;">Pris </strong><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <strong style="font-weight:bold;">Antal </strong><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <strong style="font-weight:bold;">Summa </strong><br />
    </td>
  </tr>
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      ABC
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>149Kr </span><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>1 </span><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>149Kr </span><br />
    </td>
  </tr>
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <strong style="font-weight:bold;">Delsumma </strong><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <strong style="font-weight:bold;">149Kr </strong><br />
    </td>
  </tr>
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>Frakt </span><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>49Kr via frakt </span><br />
    </td>
  </tr>
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>Totalt </span><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;border-bottom: 1px solid #ccc; padding:10px;">
      <span>198Kr</span><br />
    </td>
  </tr>
  <tr>
    <td width="350px;" style="text-align:left; padding:10px;">
      <strong style="font-weight:bold;">varav moms </strong><br />
    </td>
    <td width="350px;" style="text-align:left; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;">
    </td>
    <td width="350px;" style="text-align:left; padding:10px;">
      <strong style="font-weight:bold;">39.6 Kr</strong><br />
    </td>
  </tr>
</table>
</div>
 ';
$filename = "newpdffile";

// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
$path=  __DIR__.'/pdf/';
file_put_contents($path.'/'.$filename.".pdf", $dompdf->output());
// Output the generated PDF to Browser
$dompdf->stream($filename,array("Attachment"=>0));


