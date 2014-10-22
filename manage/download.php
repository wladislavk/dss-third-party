<?php	
    include_once('admin/includes/main_include.php');

    function system_extension_mime_types() {
        # Returns the system MIME type mapping of extensions to MIME types, as defined in /etc/mime.types.
        $out = array();
        $file = fopen('/etc/mime.types', 'r');
        while(($line = fgets($file)) !== false) {
            $line = trim(preg_replace('/#.*/', '', $line));
            if(!$line)
                continue;
            $parts = preg_split('/\s+/', $line);
            if(count($parts) == 1)
                continue;
            $type = array_shift($parts);
            foreach($parts as $part)
                $out[$part] = $type;
        }
        fclose($file);
        return $out;
    }

    function system_extension_mime_type($file) {
        # Returns the system MIME type (as defined in /etc/mime.types) for the filename specified.
        #
        # $file - the filename to examine
        static $types;
        if(!isset($types))
            $types = system_extension_mime_types();
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if(!$ext)
            $ext = $file;
        $ext = strtolower($ext);
        return isset($types[$ext]) ? $types[$ext] : null;
    }

    function system_mime_type_extensions() {
        # Returns the system MIME type mapping of MIME types to extensions, as defined in /etc/mime.types (considering the first
        # extension listed to be canonical).
        $out = array();
        $file = fopen('/etc/mime.types', 'r');
        while(($line = fgets($file)) !== false) {
            $line = trim(preg_replace('/#.*/', '', $line));
            if(!$line)
                continue;
            $parts = preg_split('/\s+/', $line);
            if(count($parts) == 1)
                continue;
            $type = array_shift($parts);
            if(!isset($out[$type]))
                $out[$type] = array_shift($parts);
        }
        fclose($file);
        return $out;
    }

    function system_mime_type_extension($type) {
        # Returns the canonical file extension for the MIME type specified, as defined in /etc/mime.types (considering the first
        # extension listed to be canonical).
        #
        # $type - the MIME type
        static $exts;
        if(!isset($exts))
            $exts = system_mime_type_extensions();
        return isset($exts[$type]) ? $exts[$type] : null;
    }


    $id = $_GET['id'];
    $query = "select id, name, size, type, ext, content from filemanager where id=".$id;

    $results = $db->getResults($query);
    if ($results) foreach ($results as $result){
        $size = $result['size'];
        $type = $result['type'];
        $name = $result['name'];
        $content = $result['content'];
        $ext = $result['ext'];
        $filename = $name;

        header("Content-length: $size");
        header("Content-type: $type");
        header("Content-Disposition: attachment; filename=$filename");
    }
?>