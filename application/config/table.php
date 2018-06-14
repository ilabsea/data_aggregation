<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$config["tables"] = array(		
		"tbladdress" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"House" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Street" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Village" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Commune" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"District" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Province" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Status" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			)
		),       
		// "tblcenter" =>  array(
		// 	"ODname" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"Code" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"Province" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"Disctrict" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// ),       
		"tblconfirm" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Vcctname" => array(
				"mandatory" => true,
				"condition" => "",
				"min_digit" => 6,
				"max_digit" => 9,
				"type" => "text"
			),
			"VcctCode" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Dat" => array(
				"mandatory" => false,
				"condition" => array("operator" => ">=", "table" => "tblpersonal", "field" => "DateReg"),
				"type" => "date"
			),
			"Result" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "text"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)

		),       
		"tblcontact" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Phone" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Status" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			)
		),      
		"tblfirsttest" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"CodeTest" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"PlaceTest" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "text"
			),
			"NamePlace" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "text"
			),
			"TypeClient" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "text"
			),
			"DatTest" => array(
				"mandatory" => false,
				"condition" => array("operator" => "<=", "table" => "tblpersonal", "field" => "DateReg"),
				"type" => "date"
			),
			"OtherPlace" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),     
		"tblhbc" =>  array(
			"Hid" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Hname" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Hphone" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),           
		"tblhbccase" =>  array(
			"Hid" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"caseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DateReg" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),       
		// "tblhealth" =>  array(
		// 	"Hid" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"HealthName" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"ODname" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"Province" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	)
		// ),        
		"tbllabo" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"CD4" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Cd" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DatCD4" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"ViralLoad" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DatViral" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),           
		// "tblnamepreart" =>  array(
		// 	"Code" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"Sevicename" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	)
		// ),    
		"tblnote" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Da" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"Note" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),          
		"tblpac" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"CodePac" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 9,
				"max_digit" => 9,
				"type" => "text",
				"encrypt" => true
			),
			"DaPac" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"Hospital" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"feeding" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DaContrim" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),           
		"tblpactest" =>  array(
			"CodePac" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"typetest" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"result" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"dat" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),       
		"tblpchild" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"ChildStatus" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"MotherStatus" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"McaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"ClinicID" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 7,
				"max_digit" => 7,
				"type" => "text",
				"encrypt" => true
			),
			"ARTnum" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 10,
				"max_digit" => 10,
				"type" => "text",
				"encrypt" => true
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),        
		"tblpersonal" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DateReg" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "date"
			),
			"Name" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Dob" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"Sex" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "text"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
		),      
		"tblppregnancy" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"PregnanStatus" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"ClinicID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"ARTnum" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"Site" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),      
		"tblpwdelivery" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Dhiv" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Ahiv" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Startarv" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Place" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Dadelivery" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "date"
			),
			"Pacsyrup" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"ResultPreg" => array(
				"mandatory" => true,
				"condition" => "",
				"type" => "text"
			),
			"code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),    
		"tblpwpacend" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"CodePac" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 9,
				"max_digit" => 9,
				"type" => "text",
				"encrypt" => true
			),
			"Dat" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"Preart" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 7,
				"max_digit" => 7,
				"type" => "text",
				"encrypt" => true
			),
			"sitecode" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),      
		"tblpwpregant" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"PMcode" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text",
				"encrypt" => true
			),
			"DaPreg" => array(
				"mandatory" => false,
				"condition" => array("operator" => "<", "table" => "tblpwpregant", "field" => "DaExPreg"),
				"type" => "date"
			),
			"AgePreg" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DaExPreg" => array(
				"mandatory" => false,
				"condition" => array("operator" => ">", "table" => "tblpwpregant", "field" => "DaPreg"),
				"type" => "date"
			),
			"Place" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),     
		"tblregoi" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"DatReg" => array(
				"mandatory" => false,
				"condition" => array("operator" => ">", "table" => "tblpersonal", "field" => "DateReg"),
				"type" => "date"
			),
			"Site" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"ClinicID" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 6,
				"max_digit" => 6,
				"type" => "text",
				"encrypt" => true
			),
			"ART" => array(
				"mandatory" => false,
				"condition" => "",
				"min_digit" => 10,
				"max_digit" => 10,
				"type" => "text",
				"encrypt" => true
			),
			"DaART" => array(
				"mandatory" => false,
				"condition" => array("operator" => "<=", "table" => "tblpersonal", "field" => "DateReg"),
				"type" => "date"
			),
			"Code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),         
		"tblstatus" =>  array(
			"CaseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Status" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"da" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "date"
			),
			"code" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		),        
		"tbltempact" =>  array(
			"caseID" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			),
			"Type" => array(
				"mandatory" => false,
				"condition" => "",
				"type" => "text"
			)
		)
		// ,          
		// "tblvcctcode" =>  array(
		// 	"SiteCode" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"SiteName" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	),
		// 	"OdName" => array(
		// 		"mandatory" => false,
		// 		"condition" => "",
		// 		"type" => "text"
		// 	)
		// )
	);
?>
