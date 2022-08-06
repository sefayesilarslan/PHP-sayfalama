<?php
$db = new PDO("mysql:host=localhost;dbname=veritabanı_adi;charset=utf8","kullanici_adi","şifre");
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

        <title>SAYFALAMA SİSTEMİ ÖRNEK</title>

</head>
<body>
<?php
// yazilar adında tablomuz için sql sorgusu
  $veri=$db->prepare("select COUNT(*) AS toplam from yazilar"); //sorgudan dönecek degere toplam diye hitap etmek için AS kullandık
  $veri->execute();
  $urunlerson=$veri->fetch(PDO::FETCH_ASSOC);


  $gosterilecekadet=5;
  $toplamicerik=$urunlerson["toplam"];

  $toplamsayfa=ceil($toplamicerik/$gosterilecekadet);//küsüratlı  çıkarsa ceil ile yukarıya yuvarladık

  $sayfa=isset($_GET["hareket"]) ? (int) $_GET["hareket"]:1;

  if($sayfa<1){
        $sayfa=1;
  }
  if($sayfa>$toplamsayfa){
        $sayfa=$toplamsayfa;
  }
$limit=($sayfa-1) *   $gosterilecekadet;
//       0   5
//       1  10 
//       2   15       
$veri2=$db->prepare("select * from yazilar LIMIT $limit, $gosterilecekadet");
$veri2->execute();


?>
<div class="container">
		<div class="row">
                    <div class="col-md-12" id="yinele">
                    
                    <table class="table table-bordered mt-2 text-center ">
                    <tbody>
                     <tr>
                    <td  class="text-left bg-light">
                    
                    <!-- <select id="sayi" class="form-control">
                        <?php
                        $sayilar=array(5,10,20,30);
                        foreach($sayilar as $deger){
                                echo'  <option value="'.$deger.'">'.$deger.'</option>';


                        }
                        ?> -->
                      
                    
                    </td>
                     <td  class="text-left bg-light">
                     <div class="alert alert-info col-md-3 float-right">Toplam veri sayısı: <?php echo $urunlerson["toplam"]; ?></div>
                    <!-- toplam adet gelecek -->
                   
                   </td>
                    </tr>
                    
                    <tr>
                    <th style="width:100px;" >Konu no</th>
                    <th >Konu İçerik</th>
                    </tr>
                    </tbody>
                    <tbody>
                <?php
                // $veri=$db->prepare("select * from yazilar");
                // $veri->execute(); yukarıda var
                while($sonuc=$veri2->fetch(PDO::FETCH_ASSOC)){
                        echo'<tr>
                        <td>'.$sonuc["id"].'</td>
                        <td>'.$sonuc["icerik"].'</td>
                        </tr>';
                }

                ?>
        
                    
                    
                    <tr>
                    <td colspan="2"  class="text-center bg-light" >
                        <!-- bootstrap ın hazır tasarımı -->
                        <nav aria-label="Page navigation example">
                        <ul class="pagination mx-auto">
                                <?php
                                        for($i=1; $i<=$toplamsayfa;$i++){
                                                echo'<li class="page-item">
                                                <a class="page-link" href="?hareket='.$i.'">'.$i.'</a>
                                                </li>';
                                        }
                                ?>

                        </ul>


                    </nav>
                    
                    
                    </td>
                    
                    
                    </tr>
                   
                    
                    
                    </tbody>
                    
                    
                    
                    
                    </table>
                    
                    
                    
                    </div>
        
        
        </div>
	


</div>





</body>
</html>