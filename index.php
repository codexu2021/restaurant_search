<!-- 2021 12/12 金岡雄一郎 作成 -->
<?php require_once('shopModel.php'); ?>
<?php require_once('searchModel.php'); ?>
<?php require_once('controller.php'); ?>
  <?php // モデルの読み込み
  $objSearch = new searchModel;
  $objShop = new shopModel;
  if(isset($_POST["arrSearchCondition"]))
  {
  $arrSearchCondition = $_POST["arrSearchCondition"];
  $res = API_controller($arrSearchCondition, $objShop);
  $arrShops = $res[0];
  $strShopTotal = $res[1];
  }

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <?php //bootstrap 依存パッケージ
  echo <<<EOM
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="paginathing.js"></script>
  EOM;
  ?>
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/pagenate.css">
  <title>Document</title>
  
</head>

<body>
  <header> <!--class = "fixed-top"-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">RestaurantSearchWEB</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="http://webservice.recruit.co.jp/"><img src="http://webservice.recruit.co.jp/banner/hotpepper-s.gif" alt="ホットペッパー Webサービス" width="135" height="17" border="0" title="ホットペッパー Webサービス"></a>
            </li>  
          </ul>
          <form class="d-flex" action="index.php" method="post">
            <input class="form-control me-2" type="search" name="arrSearchCondition[keyword=]" placeholder="Search" aria-label="Search" value="<?php if( !empty($arrSearchCondition["keyword="]) ){ echo $arrSearchCondition["keyword="]; } ?>">
            <button class="btn btn-outline-success" type = "submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </header>

  <div class="main-contents my-3 pt-5"> 
    <div class="search-near-area form-control form-group mx-5 container">
      <p>近くで検索</p>
      <!-- 送信フォーム 送信後に値を保持する処理と最初のアクセス時の値の有無の判定-->
      <form action="index.php" method="post">
        <input class="form-control" type="text" name="arrSearchCondition[lat=]" id="lat" placeholder="緯度:" 
        value="<?php if( !empty($arrSearchCondition["lat="]) ){ echo $arrSearchCondition["lat="]; } ?>" readonly>
        <input class="form-control" type="text" name="arrSearchCondition[lng=]" id="lng" placeholder="経度:"
        value="<?php if( !empty($arrSearchCondition["lng="]) ){ echo $arrSearchCondition["lng="]; } ?>" readonly>
        <div class="text-center my-3">
          <button class = "btn btn-outline-success"type="button"  onclick="getLocation()">自動場所検索</button>
        </div>
      <?php if(!empty($arrSearchCondition['range='])) :?>
        <select class="form-select" name="arrSearchCondition[range=]" id="range" >
          <option value ="1" <?php if($arrSearchCondition['range=']==1) echo"selected"?>>300m以内</option>
          <option value ="2" <?php if($arrSearchCondition['range=']==2) echo"selected"?>>500m以内</option>
          <option value ="3" <?php if($arrSearchCondition['range=']==3) echo"selected"?>>1000m以内</option>
          <option value ="4" <?php if($arrSearchCondition['range=']==4) echo"selected"?>>2000m以内</option>
          <option value ="5" <?php if($arrSearchCondition['range=']==5) echo"selected"?>>3000m以内</option>
        </select>
        <?php else :?>
          <select class="form-select" name="arrSearchCondition[range=]" id="range" >
          <option value ="1">300m以内</option>
          <option value ="2">500m以内</option>
          <option value ="3">1000m以内</option>
          <option value ="4">2000m以内</option>
          <option value ="5">3000m以内</option>
        </select>
        <?php endif ?>
        <select class="form-select" name="arrSearchCondition[budget=]" id="budget">
          <?php foreach($objSearch->get_master_code("budget") as $value ) :?>
            <option value="<?php echo $value["code"];?>"><?php echo $value["name"];?></option>
          <?php endforeach ?>
        </select>
        <div class="text-center">
          <input class = "btn btn-outline-success center-text btn-lg" type="submit" value="検索">
        </div>
      </form>
    </div>
    <br>
    <div class="search-all-area form-control form-group mx-5 container">
      <p>遠くで検索</p>
      <form action="index.php" method="post">
        <input class="form-control"type="search" name="arrSearchCondition[keyword=]" placeholder="キーワード検索" id = "keyword"
        value="<?php if( !empty($arrSearchCondition["keyword="]) ){ echo $arrSearchCondition["keyword="]; } ?>">
        <br>
        <select class="form-select" name="arrSearchCondition[budget=]" id="budget">
          <?php foreach($objSearch->get_master_code("budget") as $value ) :?>
            <option value="<?php echo $value["code"];?>"><?php echo $value["name"];?></option>
          <?php endforeach ?>
        </select>
        <select class="form-select" name="arrSearchCondition[service_area=]" id="service_area">
          <?php foreach($objSearch->get_master_code("service_area") as $value ) :?>
            <option value="<?php echo $value["code"];?>"><?php echo $value["name"];?></option>
          <?php endforeach ?>
        </select>
        <br>
        <div class="checkbox_list d-flex flex-column flex-wrap">
        <?php foreach($objShop->get_checkbox_list() as $key=>$value) :?>  
          <div>
            <fieldset>
              <input type='checkbox'<?php echo "name='arrSearchCondition[$key]' id='$key'"?> value='1'<?php if (!empty($arrSearchCondition[$key])) echo "checked"?>> 
              <?php echo "<label for='$key'>".$value."</label>"; ?>    
            </fieldset>
          </div>
        <?php endforeach;?>
        </div>
        <br>
        <div class="text-center">
          <input class = "btn btn-outline-success center-text btn-lg" type="submit" value="検索">
        </div>
      </form>
      <p id = "err"></p>
    </div>

    <!-- 表示一覧 -->
    <div class="info-area container mx-5">
    <?php if(!empty($arrShops) && !is_string($arrShops) ) : ?>
      <p>検索結果:<?php echo $strShopTotal?> 件</p>
    <?php foreach($arrShops as $arrShop ) :?>
      <br>
    <div class="row store-content">
      <div class="col">
      <img src="<?php echo $arrShop['photo'];?>" alt = "NO IMAGE" class="img-fluid"></a>
        </div>
      <div class="col d-flex align-items-center">
        <ul class="store-info list-group">
          <small>予算:<?php echo $arrShop["budget"]?></small>
          <a href=<?php echo ("./detail_view.php?id=$arrShop[id]");?>><?php echo $arrShop["name"];?></a>
          <small><a href=<?php echo $arrShop["url"];?>>ホットペッパー</a></small>
          <p>アクセス:<?php echo $arrShop["access"]?></p>
        </ul>
      </div>
    </div>
    <?php endforeach; ?>
      <?php elseif(!empty($arrShops)) :?>
        <?php echo("<p>".$arrShops."</p>");?>
      <?php else :?>
        <?php echo ("ここに検索結果を表示します")?>
      <?php endif ; ?>
    </div>
  </div>

</body>

<?php
    //位置情報の取得
      echo <<<EOM
      <script>
      var err = document.getElementById("err");
      var lat = document.getElementById("lat");
      var lng = document.getElementById("lng");
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else {
          err.innerHTML = "Geolocation is not supported by this browser.";
        }
      }

      function showPosition(position) {
        lat.value =  position.coords.latitude;
        lng.value =  position.coords.longitude;
      }
      </script>
      EOM;
  ?>

    <?php
    //ページング設定
      echo <<<EOM
      <script type="text/javascript">
        jQuery(document).ready(function($){
        $('.info-area').paginathing({
          perPage: 20,
          limitPagenation: 10,
          pageNumbers: true
          })
        });
      </script>
      EOM;
      ?>

</html>