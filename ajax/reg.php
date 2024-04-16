<?
include ('../core.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_POST)) {
    $result = $userObj->register($_POST);

    echo json_encode($result);
}