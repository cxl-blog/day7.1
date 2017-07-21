<?php
/**
 * Created by PhpStorm.
 * User: kuozhi
 * Date: 17-7-19
 * Time: 上午8:47
 */

namespace day7\UserSystemBundle\Service;

use day7\UserSystemBundle\Dao\UserDaoImpl;
use day7\UserSystemBundle\Service\UserService;


class UserServiceImpl implements UserService
{
    private $page_Show = 5;

    function getUserDao()
    {
        return new UserDaoImpl();
    }

    function getUser($id)
    {
        $users = $this->getUserDao()->get($id);
        return array('users' => $users);
    }

    function findUserByname($name, $offset, $pagesize)
    {
        return $this->getUserDao()->findByname($name, $offset, $pagesize);
    }

    function findUserList($selectsex)
    {
        $data = $this->paging();
        if (!empty($selectsex)) {
            if ($selectsex == 0) {
                $num = $this->getUserDao()->getCount('', '', '', '');
                $users = $this->getUserDao()->findLimit($data['offset'],$this->page_Show);
            }
            else {
                $users = $this->getUserDao()->findSex($selectsex, $data['offset'], $this->page_Show);
            }

        }
        else {
            $num = $this->getUserDao()->getCount('', '' , '', '');
            $users = $this->getUserDao()->findLimit($data['offset'],$this->page_Show);

        }
        $pagenum = ceil($num / $this->page_Show);
        return array(
            'num' => $num,
            'page' => $data['page'],
            'pagenum' => $pagenum,
            'pagelast' => $data['pagelast'],
            'pagenext' => $data['pagenext'],
            'users' => $users
        );

    }

    function deleteUser($id)
    {
        return $this->getUserDao()->delete($id);
    }

    function addUser($name, $sex, $age, $comment)
    {
        return $this->getUserDao()->add($name, $sex, $age, $comment);
    }

    function updateUser($id, $name, $sex, $age, $comment)
    {
        return $this->getUserDao()->update($id, $name, $sex, $age, $comment);
    }

    function selectUser($seledata)
    {//id name 查询
        $data = $this->paging();
        if (preg_match('/^[0-9]+$/', $seledata)) {
            $users = $this->getUserDao()->get($seledata);
            return array('users' => $users);
        }
        else {
            $num = $this->getUserDao()->getCount($seledata, '', '', '');
            $pagenum = ceil($num / $this->page_Show);
            $users = $this -> getUserDao() -> findByname($seledata,$data['offset'], $this->page_Show);
            return array(
                'num' => $num,
                'page' => $data['page'],
                'pagenum' => $pagenum,
                'pagelast' => $data['pagelast'],
                'pagenext' => $data['pagenext'],
                'users' => $users
            );
        }

    }

    function searchUser($sex, $ageextentl,$ageextentr)
    {
        $data = $this->paging();
        return $this->getUserDao()->search($sex, $ageextentl, $ageextentr);
    }

    function paging()
    {
        if (!isset($_GET['page']))
            $page = 1;
        if (isset($_GET['page']))
            $page = $_GET['page'];
        if ($page <= 1)
            $page = 1;
        $offset = ($page - 1) * $this->page_Show;
        $pagelast = ($page - 1);
        $pagenext = $page + 1;
        return array(
            'offset' => $offset,
            'page' => $page,
            'pagelast' => $pagelast,
            'pagenext' => $pagenext);
    }

}