<?php

/**
 * Storage is the class for get serialized data from a storage,
 * (data is multidimensional array) edit the data and save to storage.
 * @author warma2d <warma2d@ya.ru>
 */
abstract class Storage
{

    /**
     * save serialized storage somewhere (for example, in file)
     * @param string $serializedStorage
     * @return void
     */
    abstract function save($serializedStorage);

    /**
     * load serialized storage from somewhere (for example, from file)
     * @return string
     */
    abstract function load();

    /**
     * @var array multidimensional array data.
     */
    private static $storage = '';

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        if ($value != $this->get($key)) {
            $this->edit(self::$storage, $key, $value);
            $serializedStorage = self::serialize(self::$storage);
            $this->save($serializedStorage);
        }
    }

    /**
     * @param string $key
     * @return string|array|null
     */
    public function get($key)
    {
        $keys = explode('\\', $key);
        $item = self::$storage;

        while ($key = array_shift($keys)) {
            $item = $item[$key];
        }
        return $item;
    }

    /**
     * @return void
     */
    public function __construct()
    {
        $serializedStorage = $this->load();
        self::$storage = self::unSerialize($serializedStorage);
    }

    /**
     * @param array $array
     * @param string $multikey
     * @param mixed $value
     * @return void
     */
    private function edit(&$array, $multikey, $value)
    {
        $i = null;
        foreach (explode('\\', $multikey) as $key) {
            if (!$i) {
                if (isset($array[$key]))
                    $i = &$array[$key];
                else {
                    $array[$key] = array(0);
                    unset($array[0]);
                    $i = &$array[$key];
                }
            } else {
                if (isset($i[$key]))
                    $i = &$i[$key];
                else {
                    $i[$key] = array(0); //must set not null or empty
                    unset($i[0]);
                    $i = &$i[$key];
                }
            }
        }
        unset($i[0]);
        if (is_array($value))
            $i = array_merge($i, $value);
        else
            $i = $value;
    }

    /**
     * @param array $storage
     * @return void
     */
    private static function unSerialize($storage)
    {
        return unserialize($storage);
    }

    /**
     * @param array $storage
     * @return array
     */
    private static function serialize($storage)
    {
        return serialize(self::prepareSerialization($storage));
    }

    /**
     * @param array $storage
     * @return array
     */
    private static function prepareSerialization($storage)
    {
        array_walk_recursive($storage, function(&$value) {
            $value = stripslashes(htmlspecialchars(trim($value), ENT_QUOTES));
        });

        return $storage;
    }
}
