<?php
/**
 * Прокси (Proxy, Заместитель) относиться к классу структурных паттернов. Является суррогатом другого объекта и контролирует доступ к нему.

Наиболее частым применением паттерна прокси является ленивая загрузка (lazy load). "Тяжелые" объекты не всегда разумно загружать в момент инициализации. Более правильным решением будет загрузить его по первому требованию.
 */

class RemoteFile
{
    protected $_fileId = 0;
    protected $_filepath = "";
    protected $_filesize = 0;
    protected $_filename = "";
    protected $_filedata = null;
    /**
     * Load file by file id
     *
     * @param int $fileId
     */
    public function loadById($fileId)
    {
        $this -> _fileId = $fileId;
        $this -> _loadFromDatabase($fileId);
        $this -> _filedata = file_get_contents($this -> _filepath);
    }
    /**
     * некоторый код для загрузки информации о файле из БД
     *
     * @param int $fileId
     */
    public function _loadFromDatabase($fileId)
    {
        $fileinfo = DbAdapter::loadFileInfo($fileId);
        $this -> _filepath = $fileinfo['path'];
        $this -> _filesize = $fileinfo['size'];
        $this -> _filename = $fileinfo['name'];
    }
    /**
     * @return int
     */
    public function getFileId()
    {
        return $this -> _fileId;
    }
    /**
     * @return string
     */
    public function getFileContents()
    {
        return $this -> _filedata;
    }
    /**
     * @return int
     */
    public function getFileSize()
    {
        return $this -> _filesize;
    }
    /**
     * @return string
     */
    public function getFileName()
    {
        return $this -> _filename;
    }
}

$file = new RemoteFile();
$file->loadById(1);
var_dump( $file -> getFileSize() );

/**
 * В примере мы хотим получить только размер файла, а в итоге весь файл загружается в память, хотя он нам абсолютно не нужен. Как можно решить эту проблему, не изменяя исходный класс? В таких случаях удобно использовать паттерн прокси
 */
// Наш прокси будет наследовать исходный класс и, как следствие, реализовывать
// его интерфейс.
class RemoteFileProxy extends RemoteFile
{
    /**
     * Load file by file id
     *
     * @param int $fileId
     */
    public function loadById($fileId)
    {
        // Мы загружаем информацию только из БД, а сам файл не грузим
        $this -> _loadFromDatabase($fileId);
    }
    /**
     * @return string
     */
    public function getFileContents()
    {
        if (null === $this -> _filedata) {
            $this -> _filedata = file_get_contents($this -> _filepath);
        }
        return $this -> _filedata;
    }
}

/**
 * Попробуем усовершенствовать наш прокси так, чтобы он загружал данные из базы данных только по запросу:
 */

class RemoteFileExtendedProxy extends RemoteFileProxy
{
    /**
     * @var RemoteFile
     */
    protected $_realRemoteFile = null;
    /**
     * @var int
     */
    protected $_fileId = 0;
    /**
     * Load file by file id
     *
     * @param int $fileId
     */
    public function loadById($fileId)
    {
        $this -> _fileId = $fileId;
    }
    public function getFileId()
    {
        return $this -> _getRealRemoteFile() -> getFileId();
    }
    public function getFileName()
    {
        return $this -> _getRealRemoteFile() -> getFileName();
    }
    public function getFileSize()
    {
        return $this -> _getRealRemoteFile() -> getFileSize();
    }
    public function getFileContents()
    {
        return $this -> _getRealRemoteFile() -> getFileContents();
    }
    /**
     * @return RemoteFileProxy
     */
    public function _getRealRemoteFile()
    {
        if (null == $this -> _realRemoteFile) {
            $this -> _realRemoteFile = new RemoteFileProxy();
            $this -> _realRemoteFile -> loadById($this -> _fileId);
        }
        return $this -> _realRemoteFile;
    }
}