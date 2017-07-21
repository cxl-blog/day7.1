<?php

/**
 * Created by PhpStorm.
 * User: kuozhi
 * Date: 17-7-13
 * Time: 上午10:48
 */
namespace day7\UserSystemBundle\Service;

interface UserService{

    function findUserByname($name,$offset,$pagesize);

    function findUserList($select);

    function getUser($id);

    function deleteUser($id);

    function addUser($name,$sex,$age,$comment);

    function updateUser($id,$name,$sex,$age,$comment);

    function selectUser($data);

    function searchUser($sex,$ageextentl,$ageextentr);

    function paging();

}

