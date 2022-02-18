<!DOCTYPE html>
<html>
<body>

<?php
class greeting {
    public static function welcome() {
        echo "Hello World!";
    }
    public function __construct() {
        $this->welcome();
    }
}

new greeting();
?>

</body>
</html>