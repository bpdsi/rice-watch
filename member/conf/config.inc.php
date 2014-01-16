<?php
	
	$host = "localhost";
 	$user = "rwii";
	$password= "1234";
	$dbname="crop_calendar";

//---------- webboard
//(3) ตั้งค่าความต่างของเวลา Server กับ ประเทศไทย
	$p_hour = 0; 
	$p_min = 0; 

//(4) ตั้งค่าจำนวนคำถามต่อหน้า
	$list_page = 15;

//(5) ตั้งค่าให้แสดงหมายเลข IP Address 
	// ALL - แสดงหมดทุกหลัก , BAN - แสดง 3 หลักแรก , NONE - ไม่แสดง IP Address
	$showIP = "NONE";

//(6) เลือกระบบส่งอีเมล์
	// 1 - ส่งเมล์จาก Script ของเว็บบอร์ด , 2 - ส่งเมล์จาก MS Outlook Express
	$s_mail = "1";

//(7) กำหนดขนาดของภาพที่อนุญาตให้ upload ได้ (หน่วยเป็น byte)
	$Image_size = 50240;	// 10240 = 10 kbytes

//(8) กำหนดรูปแบบของตัวแสดงสถานะ ICQ (1-17)
	$ICQ_Image_Type = 5;

//(9) แสดงลำดับของคำตอบ
	// ASC - เรียงลำดับข้อมูลจากน้อยไปมาก , DESC - เรียงลำดับข้อมูลจากมากไปน้อย
	$order = "ASC"; 
?>
