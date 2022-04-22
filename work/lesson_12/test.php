<?php
// このプログラムは、self::は自クラスを表し、$thisは自身のオブジェクトを表すことを確認できます。
// self::who()の場合はParentClass自身のwho()メソッドを実行し、ChildClassをインスタンス化しているため、
// $this->who()は、ChildClassのwho()メソッドを実行します。
class ParentClass
{
    function test()
    {
        self::who(); // output 'parent'
        $this->who(); // output 'child'
    }

    function who()
    {
        echo 'parent ';
    }
}

class ChildClass extends ParentClass
{
    function who()
    {
        echo 'child ';
    }
}

$obj = new ChildClass();
$obj->test();
