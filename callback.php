<?php
header("Content-Type: application/json; encoding=utf-8");

$secret_key = 'yhig1rfmazJTeubGjWSS'; // Защищённый ключ приложения

$input = $_POST;

// Проверка подписи
$sig = $input['sig'];
unset($input['sig']);
ksort($input);
$str = '';
foreach ($input as $k => $v) {
  $str .= $k.'='.$v;
}

if ($sig != md5($str.$secret_key)) {
  $response['error'] = array(
    'error_code' => 10,
    'error_msg' => 'Несовпадение вычисленной и переданной подписи запроса.',
    'critical' => true
  );
} else {
  // Подпись правильная
  switch ($input['notification_type']) {
    case 'get_item':
      // Получение информации о товаре
      $item = $input['item']; // наименование товара

      if ($item == 'coins_pack_1') {
        $response['response'] = array(
          'item_id' => 25,
          'title' => '10,000 монет',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/coin.png',
          'price' => 5
        );
      } elseif ($item == 'coins_pack_2') {
        $response['response'] = array(
          'item_id' => 27,
          'title' => '20,000 монет',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/coin.png',
          'price' => 8
        );
      } elseif ($item == 'coins_pack_3') {
        $response['response'] = array(
          'item_id' => 29,
          'title' => '40,000 монет',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/coin.png',
          'price' => 15
        );
      } elseif ($item == 'premium') {
        $response['response'] = array(
          'item_id' => 30,
          'title' => 'Полная версия',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/full.png',
          'price' => 5
        );
      } else {
        $response['error'] = array(
          'error_code' => 20,
          'error_msg' => 'Товара не существует.',
          'critical' => true
        );
      }
      break;

    case 'get_item_test':
      // Получение информации о товаре в тестовом режиме
      $item = $input['item'];
      if ($item == 'coins_pack_1') {
        $response['response'] = array(
          'item_id' => 125,
          'title' => '10,000 монет (тестовый режим)',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/coin.png',
          'price' => 5
        );
      } elseif ($item == 'coins_pack_2') {
        $response['response'] = array(
          'item_id' => 127,
          'title' => '20,000 монет (тестовый режим)',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/coin.png',
          'price' => 8
        );
      } elseif ($item == 'coins_pack_3') {
        $response['response'] = array(
          'item_id' => 129,
          'title' => '40,000 монет (тестовый режим)',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/coin.png',
          'price' => 15
        );
      } elseif ($item == 'premium') {
        $response['response'] = array(
          'item_id' => 130,
          'title' => 'Полная версия (тестовый режим)',
          'photo_url' => 'https://raw.githubusercontent.com/electricpunch/powertanks/main/full.png',
          'price' => 5
        );
      } else {
        $response['error'] = array(
          'error_code' => 20,
          'error_msg' => 'Товара не существует.',
          'critical' => true
        );
      }
      break;

    case 'order_status_change':
      // Изменение статуса заказа
      if ($input['status'] == 'chargeable') {
        $order_id = intval($input['order_id']);

        // Код проверки товара, включая его стоимость
        $app_order_id = 1; // Получающийся у вас идентификатор заказа.

        $response['response'] = array(
          'order_id' => $order_id,
          'app_order_id' => $app_order_id,
        );
      } else {
        $response['error'] = array(
          'error_code' => 100,
          'error_msg' => 'Передано непонятно что вместо chargeable.',
          'critical' => true
        );
      }
      break;

    case 'order_status_change_test':
      // Изменение статуса заказа в тестовом режиме
      if ($input['status'] == 'chargeable') {
        $order_id = intval($input['order_id']);

        $app_order_id = 1; // Тут фактического заказа может не быть - тестовый режим.

        $response['response'] = array(
          'order_id' => $order_id,
          'app_order_id' => $app_order_id,
        );
      } else {
        $response['error'] = array(
          'error_code' => 100,
          'error_msg' => 'Передано непонятно что вместо chargeable.',
          'critical' => true
        );
      }
      break;
  }
}

echo json_encode($response);
?>