<?php

class Files {

    /**
     * Se recibe el nombre del file para poder extraer su nombre y su extension mediante un arreglo.['nombre] y ['extension']
     * @param string $nombrefile
     * @return array
     */
    public static function getNombreExtensionFile($nombrefile) {
        $array             = explode(".", $nombrefile);
        $total             = count($array);
        $data['nombre']    = substr($nombrefile, 0, -(strlen($array[$total - 1]) + 1));
        $data['extension'] = $array[$total - 1];
        if ($total > 0) {
            return $data;
        } else {
            return array();
        }
    }

    public static function obtenerMimeTypeporExtension($extension) {
        $mimetype = "";
        switch ($extension) {
            case 'pdf':
                $mimetype = "application/pdf";
                break;
            case 'doc':
                $mimetype = "application/msword";
                break;
            case 'docx':
                $mimetype = "application/msword";
                break;
            case 'zip':
                $mimetype = "application/zip";
                break;
        }
        return $mimetype;
    }

    public static function createDir($path) {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public static function preparate($file, $name, $route) {
        $data    = self::getNombreExtensionFile($file->name);
        $ext     = $data['extension'];
        $urlFile = Yii::getPathofAlias('webroot.files.' . $route);
        $ruta    = $urlFile . "/" . $name . "." . $ext;
        self::createDir($urlFile);
        return ['ruta' => $ruta, 'name' => $name . "." . $ext];
    }

}
