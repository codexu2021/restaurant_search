<?php
function API_controller($arrReq ,$objShop){
  $data = $objShop->set_data($arrReq);
  $url = $objShop->create_url($data);
  $json = $objShop->get_json($url);
  if(isset($json["results"]["error"])){
    return [$json["results"]["error"][0]["message"],0,0];
  }
  elseif(isset($json["results"]["shop"]))
  {
    $arrShops = $objShop->get_shop_data($json);
    $arrCheckboxList = $objShop->get_checkbox_data($json);
    $strShopTotal = $json["results"]["results_returned"];
    return [$arrShops,$strShopTotal,$arrCheckboxList];
  }
  else
  {
    return ["不明なエラーが発生しました",0,0];
  }
}