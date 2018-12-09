<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 09.12.2018
 * Time: 18:07
 */
$arr = [
    'IMyclass'=>'Acme\testClasses\MyClass',
    'NotebookController'=>[
        'Repository'=>new \Acme\testClasses\AnotherClass()
    ],
    'MobileController'=>[
        'Repository'=>'Acme\repositories\MobileRepository'
    ],
    'TVController'=>[
        'Repository'=>'Acme\repositories\TVRepository'
    ],
    'IView'=>'Acme\views\View',
    'mysql'=>[
        '1'=>1,
        '2'=>1,
        '34'=>1,
        '13'=>1,
    ]
];

/*function get_leafs( $array ) {
    $leafs = array();
    if ( ! is_array( $array ) ) {
        return $leafs;
    }
    $array_iterator = new RecursiveArrayIterator( $array );
    $iterator_iterator = new RecursiveIteratorIterator( $array_iterator, RecursiveIteratorIterator::LEAVES_ONLY );
    foreach ( $iterator_iterator as $key => $value ) {
        $keys = array();
        for ( $i = 0; $i < $iterator_iterator->getDepth(); $i++ ) {
            $keys[] = $iterator_iterator->getSubIterator( $i )->key();
        }
        $keys[] = $key;
        $leaf_key = implode( ' ', $keys );
        $leafs[ $leaf_key ] = $value;
    }
    return $leafs;
}
var_dump(get_leafs($arr));
*/

$iter = new RecursiveIteratorIterator(new RecursiveArrayIterator( $array ),RecursiveIteratorIterator::CHILD_FIRST);
foreach ($iter as $value)
{
    var_dump($value);
}