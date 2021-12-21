<?php require('shopModel.php'); ?>
<?php require('searchModel.php'); ?>
<?php require_once('controller.php'); ?>
  <!-- ストアIDによるデータの取得 -->
  <?php if(isset($_GET['id'])) 
  {
    $objShopDetail = new shopModel;
    $arrStoreId = $_GET['id']; 
    $arrStoreId = array(
      "id=" => $arrStoreId
    );
    $res = API_controller($arrStoreId, $objShopDetail);
    $arrShops = $res[0][0];
    $checkbox_data = $res[2];

  } ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <?php //bootstrap 依存パッケージ
  echo <<<EOM
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="paginathing.js"></script>
  EOM;
  ?>
  <title>Document</title>
</head>
<body>

<header class = "fixed-top ">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">ここ食べ!</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" 
      id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="http://webservice.recruit.co.jp/"><img src="http://webservice.recruit.co.jp/banner/hotpepper-s.gif" alt="ホットペッパー Webサービス" width="135" height="17" border="0" title="ホットペッパー Webサービス"></a>
          </li>  
        </ul>
        <form class="d-flex" action="index.php" method="post">
          <input class="form-control me-2" type="search" name="search_condition[keyword=]" placeholder="Search" aria-label="Search" value="<?php if( !empty($search_condition["keyword="]) ){ echo $search_condition["keyword="]; } ?>">
          <button class="btn btn-outline-success" type = "submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  </header>

  <div class="flex-d container mt-5 pt-5">
    <div class="row">
      <div class="col">
        <img src="<?php echo $arrShops["photo"];?>" alt = "NO IMAGE" class="img-main"></a>
      </div>
      <div class="col d-flex align-items-center store-content">
        <ul class="store-info list-group">
          <h1><?php echo $arrShops["name"]; echo "<br>" . $arrShops["name_kana"] ?></h1>
          <p>アクセス:<br><?php echo $arrShops["access"]?></p>
          <p>営業時間:<br><?php echo $arrShops["open"]; ?></p>
          <p>住所:<br><?php echo $arrShops["address"];?></p>
          <a href=<?php echo $arrShops["url"];?>>ホットペッパーでみる</a>
          <br>
          <p>詳細情報</p>
          <ul>
            <!-- 文字整形の処理  --> 
            <?php foreach($checkbox_data as $key=>$value) :?>
            <li><?php echo  $value ?></li>
            <?php endforeach; ?>
          </ul>
        </ul>
      </div>
    </div>
  </div>
  <?php
  echo <<<EOM
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>"
  EOM;
  ?>

  
  
</body>
</html>