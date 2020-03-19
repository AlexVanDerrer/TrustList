<?php $vers = 4; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=$this->config->item('app_url')?>css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=$this->config->item('app_url')?>css/style.css?v=<?=$vers?>">
    <script src="https://vk.com/js/api/openapi.js?167" type="text/javascript"></script>
    <title>Список доверия</title>
</head>
<body style="visibility: hidden" onload="setTimeout ('document.body.style.visibility = \'visible\'', 20)">

<!-- <div id="vk_api_transport"></div>
<script type="text/javascript">
  window.vkAsyncInit = function() {
    VK.init({apiId: 7326195});};

  setTimeout(function() {
    var el = document.createElement("script");
    el.type = "text/javascript";
    el.src = "https://vk.com/js/api/openapi.js?166";
    el.async = true;
    document.getElementById("vk_api_transport").appendChild(el);
  }, 0);
</script> -->