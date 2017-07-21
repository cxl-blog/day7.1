<?php
/**
 * Created by PhpStorm.
 * User: kuozhi
 * Date: 17-7-11
 * Time: 下午5:23
 */
namespace day7\UserSystemBundle\Controller;

use day7\UserSystemBundle\Service\UserServiceImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public static $users = null;
    private $service;

    function getUserService()
    {
        return new UserServiceImpl();

    }

    function indexAction()
    {//首页

        return $this->render("day7UserSystemBundle:view:inde.html.twig");
    }

    function addUserAction()
    {//添加用户
        $name = $_POST['name'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $comment = $_POST['comment'];
        if ($this->getUserService()->addUser($name, $sex, $age, $comment))
        {
            return new Response(json_encode("ok", JSON_UNESCAPED_UNICODE));
        }
        else{
            return new Response(json_encode("false", JSON_UNESCAPED_UNICODE));
        }
    }
    function getUserAction()
    {//获取用户
        $id = $_POST['id'];
        $users = $this->getUserService()->getUser($id);
        return new Response(json_encode($users, JSON_UNESCAPED_UNICODE));
    }

    function deleteUserAction()
    {//删除用户
        $id = $_POST['id'];
        $page = $_REQUEST['page'];
        if ($this->getUserService()->deleteUser($id)) {
            $array=$this->getUserService()->findUserList('');
            return new Response(json_encode($array, JSON_UNESCAPED_UNICODE));
        }
        else
        {
            return new Response(json_encode("flase", JSON_UNESCAPED_UNICODE));
        }
    }

    function updateUserAction()
    {//更新用户
        $id = $_POST['id'];
        $name = $_POST['name'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $comment = $_POST['comment'];
        if ($this->getUserService()->updateUser($id, $name, $sex, $age, $comment)) {
           return new Response(json_encode("ok", JSON_UNESCAPED_UNICODE));
        }
        else
        {
            return new Response(json_encode("flase", JSON_UNESCAPED_UNICODE));
        }
    }

    function selectUserAction()
    {//查询用户（ｉｄ　ｎａｍｅ）
        $selectdata=urldecode(trim($_GET['selectdata']));
        $array = $this->getUserService()->selectUser($selectdata);
        return $this->render("day7UserSystemBundle:view:sele-view.html.twig", $array);

    }

    function searchUserAction()
    {//条件查询
        $sex = urldecode($_GET['sex']);
        $ageextentl = $_GET['ageextentl'];
        $ageextentr = $_GET['ageextentr'];
       /* if (!isset($_POST['delrequest']))
        {
            $array = $this->getUserService()->paging($sex, $ageextentl, $ageextentr,'');
            $this->render("day7UserSystemBundle:view:serchuser-view.html.twig",$array);
        }
        else
        {
            $array = $this->getUserService()->paging($sex, $ageextentl, $ageextentr,'');
            return new Response(json_encode($array, JSON_UNESCAPED_UNICODE));
        }*/
    }

    function listUserAction()
    {//twig分页
        if(isset($_REQUEST['selectsex'])) {
            $selectsex=urldecode($_REQUEST['selectsex']);
            $array = $this->getUserService()->findUserList($selectsex);
        }
        else
            $array = $this->getUserService()->findUserList('');
        return $this->render("day7UserSystemBundle:view:list-view.html.twig", $array);
    }

}
?>