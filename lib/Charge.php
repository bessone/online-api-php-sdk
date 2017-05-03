<?php
namespace Satispay;

use Satispay\Satispay;

class Charge {
  public static function create($params = null) {
    $result = Satispay::request('/online/v1/charges', 'POST', $params);
    $body = $result['body'];
    if (!empty($body->code)) {
      switch($body->code) {
        case 36:
          throw new \Exception('Body validation error');
          break;
        case 45:
          throw new \Exception('Trying to create a Charge for another user');
          break;
        case 52:
          throw new \Exception('Beneficiary validation');
          break;
      }
    }
    return $body;
  }

  public static function all($params = null) {
    $queryString = '';
    if (!empty($params))
      $queryString = http_build_query($params);
    $result = Satispay::request('/online/v1/charges?'.$queryString);
    $body = $result['body'];
    if (!empty($body->code)) {
      switch($body->code) {
        case 45:
          throw new \Exception('Try to get a Charge of another shop');
          break;
        case 52:
          throw new \Exception('Beneficiary validation');
          break;
      }
    }
    return $body;
  }

  public static function get($id) {
    $result = Satispay::request('/online/v1/charges/'.$id);
    $body = $result['body'];
    if (!empty($body->code)) {
      switch($body->code) {
        case 41:
          throw new \Exception('Charge does not exist');
          break;
        case 45:
          throw new \Exception('Try to get a Charge of another shop');
          break;
        case 52:
          throw new \Exception('Shop validation error');
          break;
      }
    }
    return $body;
  }

  public static function update($id, $params = null) {
    $result = Satispay::request('/online/v1/charges/'.$id, 'PUT', $params);
    $body = $result['body'];
    if (!empty($body->code)) {
      switch($body->code) {
        case 45:
          throw new \Exception('Try to update a Charge of another user');
          break;
        case 44:
          throw new \Exception('Try to cancel a Charge which is already in state SUCCESS');
          break;
        case 52:
          throw new \Exception('Beneficiary validation');
          break;
        case 36:
          throw new \Exception('Body validation error');
          break;
        case 41:
          throw new \Exception('Charge don’t exist');
          break;
      }
    }
    return $body;
  }
}