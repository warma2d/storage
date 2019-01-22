# storage
Storage is the class for get serialized data from any storage, (data is multidimensional array) edit the data and save to storage.

# How to use ?
1) Type your class extends Storage.
2) $storage->set('city\coord\y', '5');
3) var_dump($storage->get('city\coord\y'));//string(1) "5"

Read more index.php
