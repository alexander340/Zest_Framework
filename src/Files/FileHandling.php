<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Files;

class FileHandling
{
    /*
     * resource
    */
    private $resource;
    /*
     * Mode of files
    */
    private $modes = [
        'readOnly'        => 'r',
        'readWrite'       => 'r+',
        'writeOnly'       => 'w',
        'writeMaster'     => 'w+',
        'writeAppend'     => 'a',
        'readWriteAppend' => 'a+',
    ];

    /**
     * Open the file.
     *
     * @param $name => name of file
     *        $mode => mode of file
     *
     * @return resource
     */
    public function open($name, $mode)
    {
        if (!empty(escape($name))) {
            $this->resource = fopen($name, $this->modes[$mode]);

            return $this;
        }
    }

    /**
     * Read the file.
     *
     * @param $file file that to be read
     *
     * @return file
     */
    public function read($file)
    {
        return fread($this->resource, filesize($file));
    }

    /**
     * Write on file.
     *
     * @param $data data that you want write on file
     *
     * @return bool
     */
    public function write($data)
    {
        return (!empty($data)) ? fwrite($this->resource, $data) : false;
    }

    /**
     * Delete the file.
     *
     * @param $file file to be deleted
     *
     * @return bool
     */
    public function delete($file)
    {
        return (file_exists($file)) ? unlink($file) : false;
    }
}