<?php
function adminer_object() {
    class AdminerSoftware extends Adminer {
        function login($login, $password) {
            // Cho phép đăng nhập không cần mật khẩu với SQLite
            return true;
        }
    }
    return new AdminerSoftware;
}
include './adminer-raw.php';
