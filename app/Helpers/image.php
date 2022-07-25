<?php

if (!function_exists('fileUpload')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function fileUpload($new_file, $path, $old_file_name = null, $imgheight = null, $imgwidth = null)
    {
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        $file_name = time() . $new_file->getClientOriginalName();
        $destinationPath = public_path($path);

        if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
            unlink($path . $old_file_name);
        }

        # resize image
        if ($new_file->getClientOriginalExtension() != 'pdf') {
            #original image upload
            $new_file->move($destinationPath, $file_name);
        } else {
            $new_file->move($destinationPath, $file_name);
        }
        return $file_name;
    }
}

function removeImage($path, $old_file_name)
{
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {

        unlink($path . $old_file_name);
    }

    return true;
}

//*************************************Image Path**************************

function path_file()
{
    return 'uploaded_file/files/pdf/';
}
