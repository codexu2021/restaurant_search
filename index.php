<!-- 2021 12/12 金岡雄一郎 作成 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/pagenate.css">
  <title>Document</title>
  <?php //bootstrap 依存パッケージ
  echo <<<EOM
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="paginathing.js"></script>
  EOM;
  ?>
  <?php require('HotPepperAPIclass.php'); ?>
  <?php $res["result"]["shop"] = FALSE ?>
  <?php // HotPepperAPI インスタンスの生成
  $API = new HotPepperAPI;
  if(isset($_POST["search_condition"]))
  {
  $search_condition = $_POST["search_condition"];
  if ($search_condition == NULL){
    echo "検索条件を入力してね";
  }
  else
  {
  $search_list = $API->set_data($search_condition);
  $search_url = $API->create_url($search_list);
  $res = $API->get_data($search_url);
  }
}
?>
  
</head>

<body>
  <header>
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
  <div class="main-contents">
    <div class="search-area form-control form-group">
      <!-- 送信フォーム 送信後に値を保持する処理と最初のアクセス時の値の有無の判定-->
      <form action="index.php" method="post">
        <input class="form-control"type="search" name="search_condition[keyword=]" placeholder="キーワード検索" id = "keyword"
        value="<?php if( !empty($search_condition["keyword="]) ){ echo $search_condition["keyword="]; } ?>">
        <br>
        <input class="form-control" type="text" name="search_condition[lat=]" id="lat" placeholder="緯度:" 
        value="<?php if( !empty($search_condition["lat="]) ){ echo $search_condition["lat="]; } ?>">
        <input class="form-control" type="text" name="search_condition[lng=]" id="lng" placeholder="経度:"
        value="<?php if( !empty($search_condition["lng="]) ){ echo $search_condition["lng="]; } ?>">
        <button class = "btn btn-outline-success"type="button"  onclick="getLocation()">自動場所検索</button>
        <br>
        <select class="form-select" name="search_condition[range=]" id="range" >
          <option value ="1" <?php if(!empty($search_list['range=']) && $search_list['range=']==1) echo"selected"?>>300m以内</option>
          <option value ="2" <?php if(!empty($search_list['range=']) && $search_list['range=']==2) echo"selected"?>>500m以内</option>
          <option value ="3" <?php if(!empty($search_list['range=']) && $search_list['range=']==3) echo"selected"?>>1000m以内</option>
          <option value ="4" <?php if(!empty($search_list['range=']) && $search_list['range=']==4) echo"selected"?>>2000m以内</option>
          <option value ="5" <?php if(!empty($search_list['range=']) && $search_list['range=']==5) echo"selected"?>>3000m以内</option>
        </select>
        <br>
        <div class="checkbox_list d-flex flex-column flex-wrap">
        <?php foreach($API->get_checkbox_list() as $key=>$value) :?>  
          <div>
            <fieldset>
              <input type='checkbox'<?php echo "name='search_condition[$key]' id='$key'"?> value='1'<?php if (!empty($search_condition[$key])) echo "checked"?>> 
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

    </div>
    <!-- 表示一覧 -->
    <div class="store-content flex-d container">
    <?php if (isset($res["results"]["shop"]) ) : ?>
    <?php foreach($res["results"]["shop"] as $key => $info) :?>
      <br>
    <div class="row">
      <div class="col">
      <img src="<?php echo $info["photo"]["pc"]["l"];?>" alt = "NO IMAGE" class="img-fluid"></a>
        </div>
      <div class="col d-flex align-items-center">
      <ul class="store-info list-group">
          <a href=<?php echo ("./detail_screen.php?id=$info[id]");?>><?php echo $info["name"];?></a>
          <a href=<?php echo $info["urls"]["pc"];?>>ホットペッパーで見る</a>
          <p>アクセス:<?php echo $info["access"]?></p>
        </ul>
      </div>
    </div>
    <?php endforeach; ?>
      <?php elseif(isset($res["results"]["error"])) :?>
        <?php echo("<p>".$res["results"]["error"][0]["message"]."</p>");?>
      <?php else :?>
        <?php echo ("ここに検索結果を表示します")?>
      <?php endif ; ?>
  </div>


    <?php
    //ページング設定
      echo <<<EOM
      <script type="text/javascript">
        jQuery(document).ready(function($){
        $('.store-content').paginathing({
          perPage: 20,
          limitPagenation: 10,
          pageNumbers: true
          })
        });
      </script>
      EOM;

      ?>
  </div>
</body>
</html>