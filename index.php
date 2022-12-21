<?php
use function CommonMark\Render\HTML;

include'baglan.php';
error_reporting(0);



if(isset($_POST['resimyukle'])){
$yukleklasor = "resim/";  //yüklenecek klasör
$tmp_name = $_FILES['yukle_resim']['tmp_name'];
$name = $_FILES['yukle_resim']['name'];
$boyut = $_FILES['yukle_resim']['size'];
$tip = $_FILES['yukle_resim']['type'];
$uzanti = substr(  $name, -4, 4   ) ;
$rasgelesayi = rand(10000,50000);
$rasgelesayi2 = rand(10000,50000);
$resimad = $rasgelesayi.$rasgelesayi2.$uzanti;
//dosya varmı kontrol
if(strlen($name)== 0){
    echo "bir dosya seçiniz";
    exit();
}
//size kontrol
if($boyut> (1024*1024*5)){
    echo "dosya boyutunuz 5mb'den büyük olamaz";
    exit();  
}
//tip kontrol
if($tip !='image/jpeg' && $tip !='image/png' && $uzanti !='.jpg'){
        echo ("yanlızca jpeg veya png formatında yükleyebilirsiniz");
        exit();  
}
move_uploaded_file($tmp_name, "$yukleklasor/$resimad");
$resimsor = $db->prepare("insert into resimdata set resim_ad=:ad ");

$resimyukle = $resimsor->execute(array('ad' => $resimad));

}


?>   
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto-Editor</title>
    <link rel="stylesheet" >
    
      <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	  <script src="script.js"></script>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'poppins', sans-serif;
	
}

body {
	
	
	align-items: center;
	justify-content: center;
	background: #ebebeb;
}

.main {
	
	border-radius: 10px;
	background: rgba(221, 31, 31, 0.05);
	overflow: hidden;
	box-shadow: 0.1px 4px 8px 5px rgba(0, 0, 0, 0.1);
}
.main .Tools .option{
   left: 1000px;

   
}
.slider{
   display: none;  
   padding: 20px;
}
.main .Tools :hover .slider{
   display: block;
   margin-left: 175px;
   box-shadow: 0.1px 4px 8px 5px rgba(0, 0, 0, 0.5);
   margin-top: -50px;
}
/*Tools part*/
.Tools {
	height: 100%;
	width: 10%;
	box-shadow: 0.1px 4px 8px 5px rgba(0, 0, 0, 0.1);
	background: rgb(73, 216, 221);
}

.Tools ul {
	list-style: none;
}

.Tools ul li {
	width: 100%;
	height: 80px;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	cursor: pointer;
	transition: 0.4s;
   color: #FF7043;
}
.Tools ul li i {
	color: rgba(255, 255, 255, 0.5);
	margin-top: 10px;
	font-size: 2em;
}

.Tools ul li:hover i {
	color: #FF7043;
}

.Tools ul li:hover {
	background: rgba(255, 255, 255, 0.1);
}

.Tools ul li:hover p {
	opacity: 1;
	margin-top: 8px;
}

.Tools ul li p {
	opacity: 0;
	font-size: 13px;
	color: #FF7043;
}


/*content part */
.content {
	position: relative;
	width: 90%;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 20px;
   top: -100px;
}

.content #logo {
	position: absolute;
	top: 10px;
	right: 20px;
	letter-spacing: 3px;
	font-family: 'Staatliches', cursive;
	color: rgba(255, 255, 255, 0.5);
}

.choose_image {
	width: 70%;
	height: 200px;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}

.upload_img_box {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	height: 100%;
	width: 100%;
	cursor: pointer;
	border: 1px dashed rgba(255, 255, 255, 0.5);
}

p#hint {
	color: rgba(255, 255, 255, 0.5);
	font-size: 1.2em;
}

.upload_img_box i {
	font-size: 2.2em;
	color: rgba(255, 255, 255, 0.5);
}

#selectedImage {
	display: none;
}


/*canvas */
#image_canvas {
	display: none;
}


/*image holder part*/
.image_holder {
	position: relative;
	display: none;
	width: 100%;
	height: 80%;
}

.image_holder img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	border-radius: 15px;
}

.image_holder button {
	position: absolute;
	display: none;
	top: -30px;
	left: 0px;
	outline: none;
	border: none;
	cursor: pointer;
	color: #FF7043;
	font-size: 1.8em;
	background: none;
	transform: rotate(270deg);
}

/*Range slider*/ 
input[type="range"] {
	width: 100%;
	height: 5px;
	cursor: pointer;
	outline: none;
   
}


/*clear or reset btn */
#clearAll {
	position: absolute;
	bottom: 10px;
	right: 20px;
	outline: none;
	border: none;
	cursor: pointer;
	border-radius: 5px;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: 0.5s;
	padding: 10px;
	color: #17202A;
	background: #FF7043;
	transform: translateX(150px);
	box-shadow: 0.1px 4px 8px 5px rgba(0, 0, 0, 0.1);
}

#clearAll span {
	margin-right: 10px;
}
.tablodiv {
	border: solid rgb(73, 216, 221) 2px;
	display: table;
	background-color: rgb(73, 216, 221);
	font-weight: bolder;
	padding: 100px;
	width: 1150px;
}
.tablodiv2 {
	border: dashed rgb(0, 0, 2) 2px;
	display: table;
	background-color: rgb(73, 216, 221);
	font-weight: bolder;
	padding: 50px;
	width: 600px;
	height: 300px;
	margin-left: 500px;
	margin-top: -520px;
}
body{
background-image: url();
background-repeat:no-repeat;
background-position: center center;
background-position-y: 80px;
font-family: Georgia, 'Times New Roman', Times, serif;
background-color: rgb(184, 177, 212);
opacity: 0.9;
}
.menu-bar{
background-color: rgb(73, 216, 221);
text-align: left;
cursor: auto;


}
.menu-bar ul{
display:inline-flex;
list-style: none;
}
.menu-bar ul li{
width: 200px;
margin: 25px;
padding: 15px;

}
.menu-bar ul li a{
text-decoration: none;
color: #fff;
text-size-adjust: 15px;
}
.active, .menu-bar ul li:hover{
background-color: black;
border-radius: 10px;
}
.sub-menu1{
display: none;
}
.menu-bar ul li:hover  .sub-menu1{
display: block;
position: absolute;
background-color:rgb(73, 216, 221);
margin-top: 15px;
margin-left: -15px;
font-size: 10px; 
text-align: left;
float: right;
}
.menu-bar ul li:hover  .sub-menu1 ul{
display: block;
text-align: left;
}
.menu-bar ul li:hover  .sub-menu1 ul li{
border-bottom: 3px dotted rgb(250, 250, 250);
background: transparent;
cursor: pointer;
}
.menu-bar ul li:hover  .sub-menu1 ul li a:hover{
color: rgb(0, 0, 0);
}
.sub-menu2{
display: none;
}
.hover-me:hover .sub-menu2{
position: absolute;
display: block;
margin-top: -40px;
margin-left: 140px;
background: rgb(73, 216, 221);
}

    </style>
</head>
<body>
   <div class="menu-bar">

        <ul style="text-align: center;">
            <li class=""><a><p id="logo">Foto-Editor</p></a></li>
            <li><a href="hak.html">HAKKIMIZDA</a>
                
            </li>  
             
            <li><a href="a">SAYFALARIMIZ</a>
                <div class="sub-menu1">    
                    <ul>
                        
                        <li><a href="1">YOUTUBE</a></li>
                        <li><a href="a">İNSTAGRAM</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="iletşim.html">İLETİŞİM</a></li>
            
            <li class="active"><a href="admin.php">ADMİN</a></li>
        </ul>
        

    </div>
    
    <br><br><br>
    <div class="main">
         <div class="Tools">
            <ul>
               <li>
                  <i class='bx bxs-brightness-half'></i>
                  <p>Parlaklık</p>
                  <div class="option">
					
				   <input  type="range" max="200" min="0" $value = "100"
				  id="brightness" class="slider">
                  
               </div>
               
               </li>
               <li>
                  <i class='bx bxs-brush' ></i>
                  <p>Bulanıklık</p>
                  <div class="option">
                  <input type="range" max="40" min="0" value="0" id="blur" class="slider">
                  
               </div>
               </li>
               <li>
                  <i class='bx bxs-collection' ></i>
                  <p>gri tonlama</p>
                  <div class="option">
                  <input type="range" max="100" min="0" value="0" id="greyScale" class="slider">
                  
               </div>
               </li>
               <li>
                  <i class='bx bxs-color-fill' ></i>
                  <p>Ton Döndür</p>
                  <div class="option">
                  <input type="range" max="100" min="0" value="0" id="hue" class="slider">
                  
               </div>
               </li>
               <li>
                  <i class='bx bxs-magic-wand' ></i>
                  <p>Doyma</p>
                  <div class="option">
                  <input type="range" max="100" min="1" value="1" id="saturation" class="slider">
                  
               </div>
               </li>
               <li onclick="Download_btn()">
                  <i class='bx bx-export' ></i>
                  <p>Export</p>
               </li>
               
            </ul>
            
         </div>
         <div class="options">
         </div>
            
         </div>
         
         <div class="content">
         <button id="clearAll"><span>Reset</span><i class='bx bx-reset' ></i></button>
      </div>
      <div class="tablodiv2" >
    <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="yukle_resim" />
    <input type="submit" value="yükle" name="resimyukle" />
     </form>
     

	
     
     <?php
    $dir ="resim/"; // resim klasörü ismi
     if (is_dir($dir)){
         if ($dh = opendir($dir)){
                 while (($file = readdir($dh)) !== false){
                    
                    if($file=="." OR $file==""){} else { 

              ?>                   
                        <img  style="width: 450px;" src="resim/<?php echo $resimad;
                     $file;closedir($dh) ?>"> 
             <?php
             }} 
         }}
       ?>
       
</div>
<div  >
	
    </div>
    
</body>
</html>