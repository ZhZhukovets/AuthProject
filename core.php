<?

session_start();

spl_autoload_register(static function ($namespace) {
    $basePath = __DIR__;

    $rest = str_replace('\\', '/', $namespace);
    $file = $basePath . '/' . trim($rest, '/') . '.php';

    if (file_exists($file)) {
        require_once($file);
    }
});

$userObj = new Auth\User();
