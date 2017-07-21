<?php
/**
 * Created by PhpStorm.
 * User: kuozhi
 * Date: 17-7-13
 * Time: 上午9:54
 */
namespace day7\UserSystemBundle\Dao;

interface UserDao
{

    function findByname($name,$offset,$pagesize);

    function getCount($name,$sex,$ageextentl,$ageextentr);

    function findSex($sex,$offset,$pagesize);

    function add($name,$sex,$age,$comment);

    function delete($id);

    function update($id,$name,$sex,$age,$comment);

    function get($id);

    function findAll();

    function findLimit($offset,$pagesize);

    function search($sex,$ageextentl,$ageextentr);

}
?>