<?php
class HotPepperAPI
{
  //デフォルトの検索条件のリスト
    private $search_list_default = 
    array(
      "key=" => "9b7974bbd99acf6a",
      "id=" => "",
      "name=" => "",
      "name_kana=" => "",
      "name_any=" => "",
      "keyword=" => "", 
      "lat=" => "",
      "lng=" => "",
      "range=" => "3",
      "wifi=" => "0",
      "wedding=" => "0",
      "course=" => "0",
      "free_drink=" => "0",
      "free_food=" => "0",
      "private_room=" => "0",
      "horigotatsu=" => "0",
      "tatami=" => "0",
      "cocktail=" => "0",
      "shochu=" => "0",
      "sake=" => "0",
      "wine=" => "0",
      "card=" => "0",
      "non_smoking=" => "0",
      "charter=" => "0",
      "ktai=" => "0",
      "parking=" => "0",
      "barrier_free=" => "0",
      "sommelier=" => "0",
      "night_view=" => "0",
      "open_air=" => "0",
      "show=" => "0",
      "equipment=" => "0",
      "karaoke=" => "0",
      "band=" => "0",
      "tv=" => "0",
      "lunch=" => "0",
      "midnight=" => "0",
      "midnight_meal=" => "0",
      "english=" => "0",
      "pet=" => "0",
      "child=" => "0",
      "type=" => "special",
      "order=" => "1",
      "start=" => "1",
      "count=" => "100",
      "format=" => "json",
    );


    private $checkbox_list =
        array(
          "wifi=" => "WIFI",
          "wedding=" => "ウェディング二次会",
          "course=" => "コース",
          "free_drink=" => "飲み放題",
          "free_food=" => "食べ放題",
          "private_room=" => "個室",
          "horigotatsu=" => "掘りごたつ",
          "tatami=" => "畳",
          "cocktail=" => "カクテル充実",
          "shochu=" => "焼酎充実",
          "sake=" => "日本酒充実",
          "wine=" => "ワイン充実",
          "card=" => "カード",
          "non_smoking=" => "禁煙",
          "charter=" => "貸切",
          "ktai=" => "携帯",
          "parking=" => "駐車場",
          "barrier_free=" => "バリアフリー",
          "sommelier=" => "ソムリエ",
          "night_view=" => "夜景",
          "open_air=" => "オープンエア",
          "show=" => "ライブショー",
          "equipment=" => "エンタメ設備",
          "karaoke=" => "カラオケ",
          "band=" => "バンド演奏",
          "tv=" => "テレビ",
          "lunch=" => "ランチ",
          "midnight=" => "23時以降の営業",
          "midnight_meal=" => "23時以降の食事",
          "english=" => "English Menu",
          "pet=" => "ペット",
          "child=" => "子連れ",
        );
      
  public function get_checkbox_list()
  {
    //チェックボックス(2択)で検索する値のリストを取得する
    return $this->checkbox_list;
  }


  public function set_data(array $search_condition)
    {
      $search_list = $this->search_list_default;
      //配列で値を入力する
      foreach($search_condition as $key=>$value){
        $search_list[$key] = $value;
      }
      return $search_list;
    } 

  public function create_url($search_list)
    {
      //dataをリクエストの形にして渡す
      $length = count($search_list);
      $counter = 0;
      $search_word = "";
      foreach($search_list as $key => $value){
        $counter += 1;
        if (empty($key)){echo("err: invaild_key"); break;}
        if (empty($value)){
          continue;
        }
        $search_word .= $key;
        $search_word .= $value;
        //ループの最後には処理を行わない
        if ($counter !== $length){$search_word .= "&";}
      }
      return $search_word;
    }

  public function get_data($search_word)
  {
    //検索
    $url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/?{$search_word}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res =  curl_exec($ch);
    curl_close($ch);
    $api_data = json_decode($res,JSON_PRETTY_PRINT);
    return $api_data;
  } 

  public function get_data_by_id($store_id)
  {
    //jsonでデータを受け取る
    $key = $this->search_list_default["key="];
    $url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key={$key}&id=$store_id&format=json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res =  curl_exec($ch);
    curl_close($ch);
    $api_data = json_decode($res,JSON_PRETTY_PRINT);
    return $api_data;
  } 

}




?>