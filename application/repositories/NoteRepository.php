<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:51
 */

namespace Acme\repositories;


use Acme\core\Repository;
use Acme\models\NoteBook;

class NoteRepository implements Repository
{
    protected $noteBook;
    function __construct(NoteBook $noteBook)
    {
        $this->noteBook = $noteBook;
    }
    /**

     * @return mixed
     */
    function all()
    {
        return $this->noteBook->all();
    }

    function find($id)
    {
        return $this->noteBook->find($id);
    }

    function update($id)
    {
        // TODO: Implement update() method.
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }

}