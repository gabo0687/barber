<?php
class ResizeComponent extends Component{

    function resize($filename_original, $filename_resized, $new_w, $new_h = 5000){

        $extension = pathinfo($filename_original, PATHINFO_EXTENSION);

        if (preg_match("/png/", $extension) ) $src_img=@imagecreatefrompng($filename_original);

        if (preg_match("/jpg|jpeg/", $extension) ) $src_img=@imagecreatefromjpeg($filename_original);

        if (preg_match("/gif/", $extension) ) $src_img=@imagecreatefromgif($filename_original);

        if(!$src_img) return false;

        $old_w = imageSX($src_img);
        $old_h = imageSY($src_img);

        $x_ratio = $new_w / $old_w;
        $y_ratio = $new_h / $old_h;

        if ( ($old_w <= $new_w) && ($old_h <= $new_h) ) {
        $thumb_w = $old_w;
        $thumb_h = $old_h;
        }
        elseif ( $y_ratio <= $x_ratio ) {
        $thumb_w = round($old_w * $y_ratio);
        $thumb_h = round($old_h * $y_ratio);
        }
        else {
        $thumb_w = round($old_w * $x_ratio);
        $thumb_h = round($old_h * $x_ratio);
        }

        $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

        if (preg_match("/png/", $extension) ){
            imagealphablending( $dst_img, false );
            imagesavealpha( $dst_img, true );
        }

        imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_w,$old_h);

        if (preg_match("/png/",$extension)) imagepng($dst_img,$filename_resized,9);
        else if (preg_match("/jpg|jpeg/",$extension)) imagejpeg($dst_img,$filename_resized,90);
        else if (preg_match("/gif/",$extension)) imagegif($dst_img,$filename_resized,90);

        imagedestroy($dst_img);
        imagedestroy($src_img);

    }

    function resizeCrop($img,$ancho,$alto,$salida){

        $extension = pathinfo($img, PATHINFO_EXTENSION);

        $ruta_imagen    = $img;
        $ancho_recorte  = $ancho;
        $alto_recorte   = $alto;

        $info_fuente    = getimagesize($ruta_imagen);
        $tipo_mime      = $info_fuente['mime'];

        if (preg_match("/png/",$extension)) $recurso_fuente = imagecreatefrompng($ruta_imagen);
        else if (preg_match("/jpg|jpeg/",$extension)) $recurso_fuente = imagecreatefromjpeg($ruta_imagen);
        else if (preg_match("/gif/",$extension)) $recurso_fuente = imagecreatefromgif($ruta_imagen);

        $centro_x  = round($info_fuente[0] / 2);
        $x_recorte = $centro_x - ($ancho_recorte / 2);
        $centro_y  = 0;
        $y_recorte = 0;

        $recurso_copia  = imagecreatetruecolor($ancho_recorte, $alto_recorte);

        if (preg_match("/png/",$extension)){
            imagealphablending( $recurso_copia, false );
            imagesavealpha( $recurso_copia, true );
        }

        imagecopyresampled($recurso_copia, $recurso_fuente, 0, 0, $x_recorte, $y_recorte,
                           $ancho_recorte, $alto_recorte,
                           $ancho_recorte, $alto_recorte);

        if (preg_match("/png/",$extension)) imagepng($recurso_copia,$salida,9);
        else if (preg_match("/jpg|jpeg/",$extension)) imagejpeg($recurso_copia,$salida,90);
        else if (preg_match("/gif/",$extension)) imagegif($recurso_copia,$salida,90);

    }

}
?>