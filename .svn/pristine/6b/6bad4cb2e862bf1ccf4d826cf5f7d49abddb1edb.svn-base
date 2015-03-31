<?php

require_once('extensions/tcpdf/config/lang/eng.php');
require_once('extensions/tcpdf/tcpdf.php');

class SSPDF extends TCPDF
{
	public function Footer()
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$this->SetY(-15);
		$this->SetFont('helvetica', '', 8);
		$this->Cell(0, 10, $url, 0, 0, 'L');
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'R');
	}
}

function sendPdf($object)
{
	$pdf = new SSPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	if($object->author) $pdf->SetAuthor($object->author->name);
	$pdf->SetTitle($object->name);

	$pdf->SetHeaderData('', 0, $object->name, $object->updated);
	$pdf->setHeaderFont(Array('helvetica', '', 10));
	//		$pdf->setFooterFont(Array('helvetica', '', 8));

	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//$pdf->setLanguageArray($pdf->l);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->AddPage();

	$doctext = processDoctext($object, $object->ext->doctext);
	$pdf->writeHTML($doctext);
	
	$pdf->Output();	//'example_001.pdf', 'I');
}

function sendFullPdf($object)
{
	$pdf = new SSPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	if($object->author)
		$pdf->SetAuthor($object->author->name);
	$pdf->SetTitle($object->name);

	$pdf->SetHeaderData('', 0, $object->name, $object->updated);
	$pdf->setHeaderFont(Array('helvetica', '', 10));
	//		$pdf->setFooterFont(Array('helvetica', '', 8));

	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//$pdf->setLanguageArray($pdf->l);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->AddPage();
	
	function BuildObjectDocumentation($object, $level=1)
	{
		$doctext = processDoctext($object, $object->ext->doctext);
		
		if($level == 1)
			$doctext = "<h1>$object->name</h1>".$doctext;
			
		else if($level == 2)
			$doctext = "<h2>$object->name</h2>".$doctext;
		
		else if($level == 3)
			$doctext = "<h3>$object->name</h3>".$doctext;
		
		else
			$doctext = "<h4>$object->name</h4>".$doctext;
		
		$children = getdbosql('Object', "parentid={$object->id} and type=".
		CMDB_OBJECTTYPE_OBJECT." and not deleted and not hidden order by displayorder, name");
				//Object::model()->findAll("parentid={$object->id} and type=".
			//CMDB_OBJECTTYPE_OBJECT." and not deleted and not hidden order by displayorder, name");

		foreach($children as $object1)
			$doctext = $doctext.BuildObjectDocumentation($object1, $level+1);
			
		return $doctext;
	}
	
	$doctext = BuildObjectDocumentation($object);
		
	$pdf->writeHTML($doctext);
	$pdf->Output();	//'example_001.pdf', 'I');
}







