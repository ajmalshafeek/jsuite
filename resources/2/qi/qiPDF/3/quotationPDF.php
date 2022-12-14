<?php



$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");

//use Spipu\Html2Pdf\Html2Pdf; //exabyte no support

if(!isset($_SESSION))

{

 	session_name($config['sessionName']);

	session_start();

}





//require $_SERVER['DOCUMENT_ROOT'].$config['appRoot'].'/external/html2pdf/vendor/autoload.php'; //exabyte no support

require $_SERVER['DOCUMENT_ROOT'].$config['appRoot'].'/external/mPDF/vendor/autoload.php';

//require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/query/quotation.php");

//require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/quotation.php");
require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/phpfunctions/configuration.php");



function generateQuotationPDF($myOrgName,$orgPhone,$orgFaxNo,$customerName,$attention,$customerAddress,$myOrgAddress,$quotationNumber,$quotationDate,$dueDate,$quotationTotalAmount,$itemList,$quotConfig,$footerContent){

	$config=parse_ini_file(__DIR__."/../../jsheetconfig.ini");

/*

	$customerName=$_POST['quot_customerName'];





	$myOrgName=$_POST['quot_myOrgName'];

	$myOrgAddress=$_POST['quot_myOrgAddress'];

	$quotationNumber=$_POST['quot_quotationNo'];

	$quotationDate=$_POST['quot_quotationDate'];

	$quotationTotalAmount=$_POST['quot_totalAmount'];

	$maxItemIndex=$_POST['maxItemIndex'];

*/

	//$quotationTotalAmount=$_POST[];





	//$html2pdf = new Html2Pdf('P','A4','en'); //exabyte no support

	$html2pdf=new \Mpdf\Mpdf();



	//$html2pdf->setDefaultFont('dejavusans');

	//$html2pdf->AddFont('dejavusans');



	//$head='<link rel="stylesheet" type="text/css" href="https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/organization/quotation/createQuotation/css/myQuotationStyle.css" />';

	//createQuotation/css/myQuotationStyle.css" />';

	$table="";

	$style='

	<style>

	table{

		margin:10px;

	}

	table.quotation-org-Header{

		width:550pt;

		border-collapse:collapse;





	}

	table.quotation-Header{

		width:550pt;

//		border-collapse:collapse;



	}

	.quotation-Header-Title{

		width:550pt;

		text-align:center;

		background-color:black;

		color:white;

		font-size:20px;



	}

	.myOrgName{

		text-align:right;

		width:40%;

		font-weight:bold;

		font-size:16px;

	}

	.myOrgAddress{

		//width:27pt;

		text-align:right;



	}



	.myOrgLogo{

		width:60%;

		height:100px;

		//border:1px solid red;

	}

	.contact{

		text-align:right;

	}

	.customerName{

		width:50%;

		font-weight:bold;

		font-size:24px;

	}



	.meta-head{

		border:1px solid black;

		//border-bottom:1px solid black;

		font-weight:bold;

		padding: 5px;

		text-align:left;



		background-color:#eee;

		font-size:15px;



	}

	.meta-body{

		border:1px solid black;

		padding: 5px;

		text-align:right;

	}

	td{

	//	border:1px solid black;

	}

	th{

		border:1px solid black;

	}



	.quotation-Content{

    margin-left:25px;

		width:525pt;

		border-collapse:collapse;

    font-size:14px;

	}



	.th-Item,.th-Description,.th-UnitCost,.th-Quantity,.th-Price{

		background-color:#eee;

		border:1px solid black;

		padding: 5px;

	}



  .th-Item,.th-Description,.th-UnitCost,.th-Quantity,.th-Price{

    background:#47668F;

    border:1px solid #47668F;

    color:white;

  }



	.th-Item{

		width:25%;

	}

	.th-Description{

		width:40%;

	}

	.th-UnitCost{

		width:10%;

	}

	.th-Quantity{

		width:8%

		text-align:center;



	}

	.th-Price{

		width:15%;

	}



	.td-Item,.td-Description,.td-UnitCost,.td-Quantity,.td-Price{

		//border-bottom:1px solid black;

		padding: 10px;

		border:1px solid black;



	}

	.td-Item{

		width:15%;

		border-left:0px;

	}

	.td-Description{

		width:40%;

	}

	.td-UnitCost{

		width:15%;

	}

	.td-Quantity{

		width:8%;

		text-align:center;

	}

	.td-Price{

		width:15%;

		border-right:0px;

	}



	.blank{

		//border-right:1px solid black;

	}

	.footer-head-TOTAL{

		padding: 10px;

		border:1px solid black;

    border-right:0px;

		font-weight:bold;

		text-align:right;

	}

	.footer-body-TOTAL{

		padding: 10px;

    border-left:1px solid black;

		border-bottom:1px solid black;

	}



	.page_Footer{

		text-align:center;

		font-weight:bold;

	}

	td{

	//	border:1px solid black;

	}



	</style>';

	$quotTable="";

	//$quot.=$head;

//	$quotTable.=$style;

$myOrLogo="";

$orgLogoSrc='./../resources/'.$_SESSION['orgLogo'].'.png';

	if($quotConfig['isLogo']){

		$LogoSrc='./../resources/'.$quotConfig['orgId'].'/myOrg/'.$quotConfig['logoName'].'.png';

		if (@file_exists($LogoSrc)) {

			$myOrLogo='<img style="max-height:100px;max-width:200px" src="'.$LogoSrc.'" alt="logo" />';
		}
	}	else {

		if (@file_exists($orgLogoSrc)) {
			//$myOrLogo='	<img  style="height:150px;max-width:550px"  src="'.$orgLogoSrc.'" alt="logo" />';
			$myOrLogo = '	<img  style="max-height:100px;max-width:200px"  src="' . $orgLogoSrc . '" alt="logo" />';
		}

		$pdfConf = getPdfConfiguration($_SESSION['orgId']);
		if ($pdfConf['replaceLogo']) {
			$myOrLogo = $pdfConf['headerNote'];
		}
	}

$quotTableOrgHeader='

  <table class="quotation-org-Header" style="z-index:-100;position: absolute;margin-top:0px">

    <tbody>

      <tr>

        <td style="width:733px;">'.$myOrLogo.'</td>

      </tr>

    </tbody>

  </table>

';
	$quotationNumber="SMU".substr($quotationNumber,6);
	$quotTableHeader='

  <table  class="quotation-Header" style="margin: 0px 0px 0px 0px !important;padding: 0px 0px 0px 0px !important">

    <tbody>

      <tr>

        <td style="width:50%;padding:10px"><table style="width:110px;margin-left:10px;padding:15px;font-size:25px"><tbody><tr><td></td></tr><tbody></table></td>

        <td style="width:50%">

          <table style="border:2px solid black;border-radius:25px !important;padding:5px;background:white;margin-left:150px;margin-bottom:0px;margin-top:0px;">

            <tbody>

              <tr>

                <td style="font-size:12px"><b>Date</b></td>

                <td style="font-size:12px"><b>:';
	$quotationDate=date_create($quotationDate);
	$quotTableHeader.=date_format($quotationDate,"d/m/Y").'</b></td>

              </tr>

              <tr>

                <td style="font-size:12px"><b>Quote#</b></td>

                <td style="font-size:12px"><b>:'.$quotationNumber.'</b></td>

              </tr>

            </tbody>

          </table>

        </td>

      </tr>

    </tbody>

  </table>';

  $quotTableHeader.='

  <table  class="quotation-Header" style="margin-bottom:0px;margin-top:0px">

    <tbody>

      <tr>

        <td style="width:60%">

        <table style="font-size:14px;">

          <tr><td style="color:#47668F"><b>Customer Details</b></td></tr>

          <tr><td style="color:#47668F"><b>Recipient Name:</b></td><td><b>'.$attention.'</b></td></tr>

          <tr><td style="color:#47668F"><b>Company Name:</b></td><td><b>'.$customerName.'</b></td></tr>

        </table>

        </td>

        <td style="width:40%">

        <table style="font-size:14px;">

          <tr><td style="color:#47668F"><b>Quote / Project Description :</b></td></tr>

          <tr>

            <td>

              Work out side normal working hour @<br>

              RM27.00 per hour per person.

            </td>

          </tr>

          <tr><td></td></tr>

          <tr>

            <td>

              Saturday & Public Holiday  @ RM36.50 per<br>

              hour person.

            </td>

          </tr>

        </table>

        </td>

      </tr>

    </tbody>

  </table>';

  $quotTableHeader.='

  <table style="margin:-12px 22px 0px 22px;">

    <tbody>

      <tr><td style="font-size:12px;color:#47668F"><b>INSTRUCTIONS</b></td></tr>

      <tr>

        <td style="font-size:12px;">

          Term of Payment:30-45 days<br>

          We trust the above will need your requirement and if you still require furthur information or clarification,<br>

          please do not hesitate to contact us  immediately

        </td>

      </tr>

    </tbody>

  </table>';

	$quotTableContent='

	<table class="quotation-Content">

		

			<tr>

				<th class="th-Item">

					ITEM

				</th>

				<th class="th-Description">

					DESCRIPTION

				</th>

				<th class="th-UnitCost">

					UNIT COST

				</th>

				<th class="th-Quantity">

					QTY

				</th>

				<th class="th-Price">

					PRICE

				</th>



			</tr>

		

		<tbody>

		';

		$quotItemList='';

		//for( $i=0; $i<$maxItemIndex; $i++ )

		foreach($itemList as $item){

			$itemName=$item['itemName'];

			$itemDescription=$item['itemDescription'];

			$itemCost=$item['itemCost'];

			$itemQty=$item['itemQty'];

			$price=$item['price'];



			$quotItemList.='

			<tr>

				<td class="td-Item" valign="top">

				'.$itemName.'

				</td>



				<td class="td-Description" valign="top">

				'.nl2br($itemDescription).'

				</td>



				<td class="td-UnitCost" valign="top">

				'.$itemCost.'

				</td>



				<td class="td-Quantity" valign="top">

				'.$itemQty.'

				</td>



				<td class="td-Price" valign="top">

				'.$price.'

				</td>

			</tr>

			';

		}

	$quotTableContent.=$quotItemList;

/*	<tr>

	<td colspan="2" class="blank">



	</td>



	<td colspan="2" class="meta-head">

		Subtotal

	</td>



	<td style="border:1px solid black">

		RM 875.00

	</td>



</tr>*/



$stamp="";

if($quotConfig['isStamp']){

	$stampSrc='./../resources/'.$quotConfig['orgId'].'/myOrg/'.$quotConfig['stampName'].'.png';

	if (@file_exists($stampSrc)) {

		$stamp='<img style="height:100px;max-width:100px" src="'.$stampSrc.'" alt="logo" />';

	}

}

	$sign="";
	if($quotConfig['isSign']){

		$signSrc='./../resources/'.$quotConfig['orgId'].'/myOrg/'.$quotConfig['signName'].'.png';

		//$stampSrc='https://'.$_SERVER['HTTP_HOST'].$config['appRoot'].'/resources/'.$quotConfig['orgId'].'/myOrg/'.$quotConfig['stampName'].'.png';

		if (@file_exists($signSrc)) {

			$sign='<img style="max-width:100px" src="'.$signSrc.'" alt="logo" />';

		}

	}



$extraNote=$footerContent;

	$quotTableContent.='

				<tr>

					<td colspan="2"  class="blank" style="border-right:1px solid black;">





					</td>



					<td colspan="2" class="footer-head-TOTAL" >

						TOTAL

					</td>



					<td class="footer-body-TOTAL" >

						'.$quotationTotalAmount.'

					</td>



				</tr>

				<tr>

					<td class="blank" colspan="5" style="padding:0px;font-weight:bold">

			<table style="width:100%;margin:0px;">

			<tr>
				<td  style="width:50%;color:#47668F;font-size:14px;padding-left:130px;text-align:center"><b>We hereby confirm of the above,<br/>

				'.$stamp.'<br>
				'.$sign.'
				<br>
 			AUTHORIZED BY</td></b>

			</tr>';

	$quotTableContent.='		<tr>

				<td style="width:50%;color:#47668F;font-size:14px;">'.$extraNote.'<br>

			</tr>

			</table>

					</td>

				</tr>

			</tbody>



		</table>

		';


	/*
		$quotTableContent.='

			<table class="quotation-org-Header">

			<tbody>

				<tr>

				<td style="width:733px;"><img src="../resources/'.$_SESSION['orgId'].'/myOrg/footerQuot.png" style="width:100%"></td>

				</tr>

			</tbody>

			</table>

		';
	*/
	/*

	<page_footer class="page_Footer">

		This is computer generated document no signature required

	</page_footer>



	removed as html2pdf not supported by exabyte

	*/

	$html2pdf->SetFooter('|This is computer generated document no signature required|');



	$quotTable.=$style;

	$quotTable.=$quotTableOrgHeader;

	$quotTable.=$quotTableHeader;

	$quotTable.=$quotTableContent;



	$html2pdf->writeHTML($quotTable);





	//$html2pdf->output();

	return $html2pdf;



}

?>