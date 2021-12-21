<?php
class searchModel{


  public function getURL($strMaster){
    $strURL = "https://webservice.recruit.co.jp/hotpepper/$strMaster/v1/?key=9b7974bbd99acf6a&format=json";
    return $strURL;
  }

  public function get_master_code($strMaster)
  {
    $strURL = $this->getURL($strMaster);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res =  curl_exec($ch);
    curl_close($ch);
    $json = json_decode($res,JSON_PRETTY_PRINT);
    $json = $json["results"][$strMaster];
    echo $json;
    return $json;
  } 

}