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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common;

class FTP
{
    /**
     * Connection.
     *
     * @since 3.0.0
     *
     * @var resource
     */
    private $connection;

    /**
     * connectionString.
     *
     * @since 3.0.0
     *
     * @var resource
     */
    private $connectionString;

    /**
     * Instantiate the FTP object.
     *
     * @param (string) $host server host
     *                       (string) $user username
     *                       (string) $pass password
     *                       (string) $secured ftp or sftp
     *
     * @since 3.0.0
     */
    public function __construct($host, $user, $pass, $secured)
    {
        if ($secured === false) {
            $conn = ftp_connect($host);
            $login_result = ftp_login($conn, $user, $pass);
            $this->connection = $conn;
            $this->connectionString = 'ftp://'.$user.':'.$pass.'@'.$host;
        } elseif ($secured === true) {
            $conn = ftp_ssl_connect($host);
            $login_result = ftp_login($conn, $user, $pass);
            $this->connection = $conn;
            $this->connectionString = 'sftp://'.$user.':'.$pass.'@'.$host;
        } else {
            $this->connection = null;
            $this->connectionString = null;
        }
    }

    /**
     * get the connection.
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * check whether the ftp is connected.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isConnected()
    {
             return (is_resource($this->getConnection())) ? true : false;
    }

    /**
     * get the list of files.
     *
     * @param (string) $dir directory
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function ftpFiles($dir)
    {
        return ($this->isConnected() === true) ? ftp_nlist($this->getConnection(), $dir) : false;
    }

    /**
     * get the current working directory.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function pwd()
    {
        return ($this->isConnected() === true) ? ftp_pwd($this->getConnection()) : false;
    }

    /**
     * Change directories.
     *
     * @param (string) $dir directory
     *                      (string) $new naw name
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function chdir($dir)
    {
        return ($this->isConnected() === true) ? ftp_chdir($this->getConnection(), $dir) : false;
    }

    /**
     * Make directory.
     *
     * @param (string) $dir directory name
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function mkdir($dir)
    {
        return ($this->isConnected() === true) ? ftp_mkdir($this->getConnection(), $dir) : false;
    }

    /**
     * Make nested sub-directories.
     *
     * @param (array) $dirs
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function mkdirs($dirs)
    {
        if (substr($dirs, 0, 1) == '/') {
            $dirs = substr($dirs, 1);
        }
        if (substr($dirs, -1) == '/') {
            $dirs = substr($dirs, 0, -1);
        }
        $dirs = explode('/', $dirs);
        $curDir = $this->connectionString;
        foreach ($dirs as $dir) {
            $curDir .= '/'.$dir;
            if (!is_dir($curDir)) {
                $this->mkdir($dir);
            }
            $this->chdir($dir);
        }

        return $this;
    }

    /**
     * Remove directory.
     *
     * @param (string) $dir directory
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function rmdir($dir)
    {
        return ($this->isConnected() === true) ? ftp_rmdir($this->getConnection(), $dir) : false;
    }

    /**
     * Check if file exists.
     *
     * @param (string) $file
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function fileExists($file)
    {
        return ($this->isConnected() === true) ? ftp_rmdir($this->connectionString.$file) : false;
    }

    /**
     * Check is the dir is exists.
     *
     * @param (string) $dir directory
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function dirExists($dir)
    {
        return ($this->isConnected() === true) ? ftp_rmdir($this->connectionString.$dir) : false;
    }

    /**
     * Get the file.
     *
     * @param (mixed) $local local
     *                       (mixed)$remote remote
     *                       (mixed) $mode mode
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function get($local, $remote, $mode = FTP_BINARY)
    {
        return ($this->isConnected() === true) ? ftp_get($this->getConnection(), $local, $remote, $mode) : false;
    }

    /**
     * Rename file.
     *
     * @param (string) $old old
     *                      (string) $new naw name
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function rename($old, $new)
    {
        return ($this->isConnected() === true) ? ftp_rename($this->getConnection(), $old, $new) : false;
    }

    /**
     * Change premission.
     *
     * @param (string) $file file
     *                       (mixed) $mode mode
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function chmod($file, $mode)
    {
        return ($this->isConnected() === true) ? ftp_chmod($this->getConnection(), $mode, $file) : false;
    }

    /**
     * Delete the files.
     *
     * @param (string) $file file you want to delete
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function delete($file)
    {
        return ($this->isConnected() === true) ? ftp_delete($this->getConnection(), $file) : false;
    }

    /**
     * Switch the passive mod.
     *
     * @param (bool) $flag flag
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function pasv($flag = true)
    {
        return ($this->isConnected() === true) ? ftp_pasv($this->getConnection(), $flag) : false;
    }

    /**
     * Close the FTP connection.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            ftp_close($this->connection);
        }
    }

    /**
     * Upload the files.
     *
     * @param (array) $files number of files you want to uplaod
     *                       (string) $root Server root directory or sub
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function put($files, $root = 'public_html')
    {
        if ($this->isConnected() === true) {
            foreach ($files as $key => $value) {
                ftp_put($this->getConnection(), $server_root.'/'.$value, $value, FTP_ASCII);
            }
        } else {
            return false;
        }
    }
}
