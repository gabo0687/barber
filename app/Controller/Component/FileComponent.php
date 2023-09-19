<?php
    class FileComponent extends Component { 
        public $components = array('Image');
        
        //Elimina del nombre de archivo los caracteres especiales ej: (ÁáÉéÍíÓóÚúÑñ), en el parametro ($fileName)
        function removeSpecialChars($fileName) {
            $value = preg_replace('/[^a-zA-Z0-9_.]/', '', strtolower(basename($fileName)));
            return $value;
        }
    
        function clear($url){
            $tildes = array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ');
            $vocales = array('a','e','i','o','u','n','A','E','I','O','U','N');
            $url = str_replace($tildes,$vocales,$url);
            $simbolos = array("=","¿","?","¡","!","'","%","$","€","(",")","[","]","{","}","*","+","·",".","&lt; ","&gt;");
            $simbolosClear = array("","","","","","","","","","","","","","","","","","","","","");
            $url = str_replace($simbolos,$simbolosClear,$url);
            //Quitar espacios
            $url = str_replace(" ","-",$url);
            //Pasar a minúsculas
            $url = strtolower($url);
            return $url;
        }
        
        
        
        
        
    }
?>