<?
include ('../core.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $result = $userObj->logout();

    echo json_encode($result);
}