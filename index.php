<?php

/**
 * Given an integer number, return the next greater number.
 * The smallest number that is greater than start integer number,
 * obtained by switching adjacent digits no more than once.
 *
 * Examples:
 * Start:  765;
 * Result: 'Not possible';
 *
 * Start:  2117;
 * Result: 2171;
 *
 * Start:  12896543;
 * Result: 12985634;
 */
function next_bigger_number($number) {
  $changed = FALSE;
  $numbersArray = str_split((string) $number);
  $arrayCount = count($numbersArray);
  for ($count = $arrayCount - 1; $count > 0; $count--) {
    $previousCount = $count - 1;
    if (isset($numbersArray[$previousCount]) && $numbersArray[$count] > $numbersArray[$previousCount]) {
      $current = $numbersArray[$count];
      $numbersArray[$count] = $numbersArray[$previousCount];
      $numbersArray[$previousCount] = $current;
      $changed = TRUE;
      break;
    }
  }
  if (FALSE === $changed) {
    return 'Not possible';
  }
  ++$count;
  foreach ($numbersArray as $key => &$value) {
    if ($count > $key) {
      continue;
    }
    $nextKey = $key + 1;
    if (isset($numbersArray[$nextKey]) && $value > $numbersArray[$nextKey]) {
      $current = $value;
      $value = $numbersArray[$nextKey];
      $numbersArray[$nextKey] = $current;
      $count = $nextKey + 1;
    }
  }
  $result = implode('', $numbersArray);
  if ((int) $result > (int) $number) {
    return "The result is: '{$result}'";
  }
  return 'Not possible';
}

/**
 * Given an integer number, return the next greater number.
 * The smallest number that is greater than, start integer number.
 *
 * Examples:
 * Start:  765;
 * Result: 'Not possible';
 *
 * Start:  2117;
 * Result: 2171;
 *
 * Start:  12896543;
 * Result: 12934568;
 */
function next_bigger_number_optimal_v_one($number) {
  $minimum = $lastCount = NULL;
  $point = -1;
  $numbersArray = str_split((string) $number);
  for ($count = count($numbersArray) - 1; $count > 0; $count--) {
    if ($numbersArray[$count] > $numbersArray[$count - 1]) {
      $point = $count - 1;
      break;
    }
  }
  if ($point == -1) {
    return 'Not possible';
  }
  $digits = array_slice($numbersArray, $point);
  $numbersArray = array_slice($numbersArray, -(count($numbersArray)), $point);
  $digitsFirstElement = $digits[0];
  $digits = array_slice($digits, 1);
  for ($count = 0; $count < count($digits); $count++) {
    if ($digits[$count] > $digitsFirstElement) {
      if ($minimum == NULL || $digits[$count] < $minimum) {
        $minimum = $digits[$count];
        $lastCount = $count;
      }
    }
  }
  if ($lastCount === NULL) {
    return 'Not possible';
  }
  unset($digits[$lastCount]);
  $digits = array_slice($digits, 0);
  array_push($digits, $digitsFirstElement);
  asort($digits);
  $result = implode('', $numbersArray) . $minimum . implode('', $digits);
  if ((int) $result < (int) $number) {
    return 'Not possible';
  }
  return 'The result is: ' . $result;
}

/**
 * Given an integer number, return the next greater number.
 * The smallest number that is greater than, start integer number.
 * It is a more short version of "next_bigger_number_optimal_v_one".
 *
 * Examples:
 * Start:  765;
 * Result: 'Not possible';
 *
 * Start:  2117;
 * Result: 2171;
 *
 * Start:  12896543;
 * Result: 12934568;
 */
function next_bigger_number_optimal_v_two($number) {
  $changed = FALSE;
  $numbersArray = str_split((string) $number);
  $arrayCount = count($numbersArray);
  for ($count = $arrayCount - 1; $count > 0; $count--) {
    $previousCount = $count - 1;
    if (isset($numbersArray[$previousCount]) && $numbersArray[$count] > $numbersArray[$previousCount]) {
      $current = $numbersArray[$count];
      $numbersArray[$count] = $numbersArray[$previousCount];
      $numbersArray[$previousCount] = $current;
      $changed = TRUE;
      break;
    }
  }
  if (FALSE === $changed) {
    return 'Not possible';
  }
  $leftPart = array_slice($numbersArray, -(count($numbersArray)), $count);
  $rightPart = array_slice($numbersArray, $count);
  sort($rightPart, SORT_NUMERIC);
  $result = implode('', array_merge($leftPart, $rightPart));
  if ((int) $result > (int) $number) {
    return "The result is: '{$result}'";
  }
  return 'Not possible';
}

?>
