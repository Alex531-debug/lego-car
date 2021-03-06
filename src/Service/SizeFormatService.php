<?php


namespace App\Service;


class SizeFormatService
{
    public static function getSize( $bytes )
    {
        if ( $bytes < 1000 * 1024 ) {
            return number_format( $bytes / 1024, 2 ) . " KB";
        }
        elseif ( $bytes < 1000 * 1048576 ) {
            return number_format( $bytes / 1048576, 2 ) . " MB";
        }
        elseif ( $bytes < 1000 * 1073741824 ) {
            return number_format( $bytes / 1073741824, 2 ) . " GB";
        }
        else {
            return number_format( $bytes / 1099511627776, 2 ) . " TB";
        }
    }
}