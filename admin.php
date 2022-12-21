<?php
    session_start();
    error_reporting(0);

    $dir = "resim/";  //resimlerin kayıt yeri

    $username = 'admin';   //kullanıcı adı
    $password = 'admin';   //şifresi

    if(isset($_POST['username']))
    {
        $fromuser = $_POST['username']; 
        $frompass = $_POST['password']; 
        if($fromuser==$username || $frompass==$password)
        {
            $_SESSION["access"] = 1;
        }
        else
        {
            echo "Invalid Username or Password";
        }
    }

    if(isset($_GET['del']))
    {
        unlink($dir.'/'.$_GET['del']);
    }

    if(isset($_GET['logout']))
    {
        session_destroy();
    }

    if(isset($_POST['fileupload']))
    {
        $dirfile = $dir.basename( $_FILES['file']['name']);     
        if(move_uploaded_file($_FILES['file']['tmp_name'], $dirfile)) {  
            echo "File uploaded successfully!";  
        } else{  
            echo "Sorry, file not uploaded, please try again!";  
        }  
    }

    $useraccess = $_SESSION["access"];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Albums</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/[email protected]/dist/css/bootstrap.min.css">
</head>
<style>
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
margin: 20px;

}
.menu-bar ul{
display:inline-flex;
list-style: none;
}
.menu-bar ul li{
width: 200px;
margin: 10px;
padding: 15px;

}
.menu-bar ul li a{
text-decoration: none;
color: #fff;
text-size-adjust: 15px;
text-align: center;
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
.tablodiv2 {
	border: dashed rgb(0, 0, 2) 2px;
	display: table;
	background-color: rgb(73, 216, 221);
	font-weight: bolder;
	padding: 25px;
	width: 600px;
	top: -1000px;
	margin-left: 300px;
}</style>
<body>
<div class="menu-bar">

        <ul style="text-align: center;">
            <li class=""><a href="index.php"><p id="logo">Foto-Editor</p></a></li>
            <li><a href="a">HAKKIMIZDA</a>
                
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
            
            <li class="active"><a>ADMİN</a></li>
        </ul>
        

    </div><div class="tablodiv2" >
<?php if($useraccess!=1){  ?>

<main class="login-form" style="margin-top: 150px;">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Giriş Paneli</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group row">
                                <label  class="col-md-4 col-form-label text-md-right">Kullanıcı adı</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Şifre</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Giriş
                                </button>
                               
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</div>
<?php } else { ?>


<main class="login-form" style="margin-top: 50px;">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Resim yükle</div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                        	<input type="hidden" value="1" name="fileupload">
                            <div class="form-group row">
                                <label  class="col-md-4 col-form-label text-md-right">Dosya seç</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file" required autofocus>
                                </div>
                            </div>  
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Yükle
                                </button>
                               
                            </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8" style="margin-top:15px;">
                <div class="card">
                    <div class="card-header">Resimlerim</div>
                    <div class="card-body">
                    	 <div class="row">
                           <?php
                            
                            if (is_dir($dir)){
                              if ($dh = opendir($dir)){
                                while (($file = readdir($dh)) !== false){
                                   if($file=="." OR $file==".."){} else {  ?>
                                  	<div class="col-md-3">
                                      <img src="<?php echo $dir; ?>/<?php echo $file; ?>" width="50%" class="img-thumbnail">
                                      <a href="?del=<?php echo $file; ?>" onclick="return confirm('Are you sure you want to delete this item?');"> Delete </a>
                              		</div>
                                	
                                 <?php
                                  }
                                }
                                closedir($dh);}} ?>
       					</div>

                    </div>
                </div>
            </div>

        </div>

        </div>

</main>
 <center> <br> <a href="?logout=1" > ÇIKIŞ YAP </a> </center>

<?php } ?>

</body>
</html>