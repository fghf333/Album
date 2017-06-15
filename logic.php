<?php
//"{\"folder_id\":\"59425cfc007791089f5d6e79\",\"skip\":0,\"limit\":0,\"access_token\":\"QzAz6O3MyZV8j6xQqodXQYvFfiRXlV\"}")
function getContentAttr($dir, $attrType, $num){
  $URL = 'https://api.monosnap.com/folder/content';
  $res = cURL($URL);
  //$length = count($res['content_items']);
  //$Link = 'https://www.monosnap.com/file/' . $res['content_items'][0]['id'] . '.png';
  //$attr = $res['content_items'][$num][$attrType];
  switch ($dir){
    case 'folder':
      return $attr = $res['folder'][$attrType];
      break;
    case 'content_items':
      return $attr = $res['content_items'][$num][$attrType];
      break;
    case 'result':
      return $attr = $res['result'];
      break;
    }
}
function cURL($URL){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $URL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, "{\"folder_id\":\"59425cfc007791089f5d6e79\",\"skip\":0,\"access_token\":\"QzAz6O3MyZV8j6xQqodXQYvFfiRXlV\"}");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "content-type: application/json"
    ));
    $res = json_decode(curl_exec($curl), true);
    return($res);
    curl_close($curl);
}
function PageGenerator(){
  $count = getContentAttr('folder', 'items_count');
  for($i=0; $i<$count; $i++)
  {
    $PrewURL = 'https://api.monosnap.com/rpc/file/download?id=' . getContentAttr('content_items', 'id', $i) . '&type=preview';
    $ImgURL = 'https://www.monosnap.com/file/' . getContentAttr('content_items', 'id', $i) . '.png';
    $body .= '  <div class="col"><div class="imgPrev" data-toggle="modal" data-target="#myModal"><img src="' . $PrewURL . '" alt="' . getContentAttr('content_items', 'title', $i) . '"></div></div>';
  }
  return $body;
}
function GetContentModal(){
  $ImgURL = 'https://www.monosnap.com/file/' . getContentAttr('content_items', 'id', 0) . '.png';
  return $ImgURL;
}
?>
