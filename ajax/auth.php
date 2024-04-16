<?
include ('../core.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_POST['login'] && $_POST['password']) {
    $result = $userObj->auth($_POST['login'], $_POST['password']);

    echo json_encode($result);
}