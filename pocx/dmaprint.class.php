<?php

/*
 *	Direct Printing POC 
 */

date_default_timezone_set('UTC'); 

 
 require_once('fpdf17/code39.php');
  
 class dmaprint 
 {
 	var $number;	// Bar Code Data
 	var $printer;	// Target Printer
 	var $pdf;		// PDF Engine	

 	function __construct($w, $h, $o)
	{
		$this->pdf = new PDF_Code39($o, "mm", array($h,$w));
		$this->pdf->AddPage();
		//$this->pdf->SetFont('Arial', 'B', 5);

	} 	

	function doPrint()
	{
		$fn = "/tmp/" . md5(date("Y-m-d-h-i-s-u")) . ".pdf";
		$this->pdf->Output($fn, "F");
		system("lp -d " . $this->printer . " " . $fn);
		unlink($fn);
	}
	
 }
 
 class dmaprintid extends dmaprint
 {
 	var $name;		// Name on ID Card
	
	function __construct($name, $number, $printer)
	{
		//parent::__construct(70,150,"L");
		parent::__construct(80,80,"P");
		$this->name = $name;
		$this->number = $number;
		$this->printer = $printer;
	}

	function doPrint() 
	{
		$this->pdf->SetFont('Arial', 'B', 12);
		$this->pdf->setX(1);
		$this->pdf->Write(21, $this->name);
		
		$this->pdf->Ln(17);		
		$this->pdf->Code39(2, $this->pdf->getY(), $this->number);	//Bar Code
		
		parent::doPrint();
	}
	
 }
 
 class dmaprintcoupon extends dmaprint
 {
 	var $text;		// Text on Coupon
 	var $expires;	// Expiration Date

	function __construct($text, $expires, $number, $printer)
	{

		parent::__construct(80,140,"P");
		$this->text = $text;
		$this->expires = $expires;
		$this->number = $number;
		$this->printer = $printer;
	}
// 
	function doPrint() 
	{
		$this->pdf->Image('http://friends.dma.org/wp-content/plugins/badgeos-dma-print/poc/dma_logo.png', 8, 1,-170);
         
        //$this->pdf->SetFont('Arial', 'B', 65); //Use if image above not displaying properly
        //$this->pdf->setX(6);
        //$this->pdf->Write(8, 'DMA'); 
		
		$this->pdf->Ln(14);		

		$this->pdf->SetFont('Arial', 'B', 8);
		$this->pdf->setX(8);
		$this->pdf->Write(4, $this->text);
		
		$this->pdf->Ln(6);		
		$this->pdf->SetFont('Arial', 'B', 8);
		$this->pdf->setY($this->pdf->getY());
		$this->pdf->setX(7);
		$this->pdf->Write(8, "Expires: " . $this->expires); //Expiration Date

		$this->pdf->Ln(7);		
		$this->pdf->setX(8);
		$this->pdf->Code39(8, $this->pdf->getY(), $this->number);	//Bar Code

		$this->pdf->Ln(8);	
		$this->pdf->setX(8);	
		$this->pdf->SetFont('Arial', 'B', 8);
		$this->pdf->setY($this->pdf->getY()+8);		
		
		$this->pdf->setX(8);
		$this->pdf->Write(8, 'Thank you for being a DMA Friend!');
		
		$this->pdf->setX(8);
		$this->pdf->Write(14, '      ');
		

		parent::doPrint();
	}

 }

	
?>
