<?php 
class Swapper {
    static public function swap(&$object1, &$object2 ){
        $temp = clone $object1;
        $object1 =  clone $object2;
        $object2 = clone $temp;
    }
}