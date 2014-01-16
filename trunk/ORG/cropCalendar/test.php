<?
include "../function/functionPHP.php";
	host();
include"../disease/core_disease_period.php";	
getDiseasePerPeriod("ระยะกล้า","ภาคกลาง");	
echo"<hr>";
getDiseasePerPeriod("ระยะแตกกอ","ภาคกลาง");	
echo"<hr>";getDiseasePerPeriod("ระยะตั้งท้อง","ภาคกลาง");	
echo"<hr>";getDiseasePerPeriod("ระยะน้ำนมและข้าวสุก","ภาคกลาง");	
echo"<hr>";
?>