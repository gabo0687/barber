<?php
class EncryptComponent extends Component {

    function encrypt($textToEncrypt) {

        $encryptPass = '494GT5Rrx8mJKGkmdskjsh';
        $pass_encrypt1 = md5($textToEncrypt);
        $pass_encrypt2 = sha1($encryptPass.$pass_encrypt1);

        return $pass_encrypt2;
    }

}
?>