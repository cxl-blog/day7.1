<?php
/**
 * Created by PhpStorm.
 * User: kuozhi
 * Date: 17-7-19
 * Time: 上午8:41
 */

namespace day7\UserSystemBundle\Dao;

use day7\UserSystemBundle\Dao\UserDao;
use day7\UserSystemBundle\Connection\Sql;

class UserDaoImpl implements UserDao
{
    private $mysql;

    function __construct()
    {
        $this->mysql=Sql::connect();
    }

    function get($id)
    {//id查询单行
        $sql="SELECT * FROM `user` WHERE  id= ? ";
        $stmt=$this->mysql->prepare($sql);
        $stmt->execute(
            array($id)
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    function findByName($name, $offset, $pagesize)
    {//多行查询(名字查询多行)

        $sql="SELECT * FROM `user` WHERE  name='$name'  LIMIT $offset,$pagesize";
        $stmt=$this->mysql->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getCount($name, $sex, $ageextentl, $ageextentr)
    {//分页获取数据的总条数
        if ((!empty($sex))&&(!empty($ageextentr))&&(!empty($ageextentl))) {
            $sql="SELECT count(*) FROM `user` WHERE sex= ? and ? =<age  and age<= ?";
            $stmt = $this->mysql->prepare($sql);
            $stmt->execute(array($sex,$ageextentl,$ageextentr));
            $result=$stmt->fetch();
            return $result[0];
        }
        if (!empty($sex)&& $ageextentr==null && $ageextentl==null) {
            $sql="SELECT count(*) FROM `user` WHERE sex= '$sex'";
            $result = $this->mysql->query($sql)->fetch();
            return $result[0];
        }

        if (!empty($name)) {
            $sql="SELECT count(*) FROM `user` WHERE name= '$name'";
            $result = $this->mysql->query($sql)->fetch();
            return $result[0];
        }
        $sql="SELECT count(*) FROM `user`";
        $result = $this->mysql->query($sql)->fetch();
        return $result[0];

    }

    function findSex($sex, $offset, $pagesize)
    {  //性别显示
        $sql="SELECT * FROM `user` WHERE  sex= '$sex' LIMIT $offset,$pagesize";
        return $this->mysql->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    function add($name,$sex,$age,$comment)
    {//添加用户
        $sql="INSERT INTO `user` ( `name`,`sex`, `age`,`comment`) VALUES (?,?,?,?)";
        $a=$this->mysql->prepare($sql);
        if($a->execute(array($name,$sex,$age,$comment,)))
            return 1;
        else
            return 0;
    }

    function delete($id)
    {//删除功能
        $sql="DELETE FROM `user` WHERE id= ? ";
        $stmt=$this->mysql->prepare($sql);
        if($stmt->execute(array($id)))
            return 1;
        else
            return 0;
    }

    function update($id,$name,$sex,$age,$comment)
    {//更新用户
        $sql="UPDATE `user` SET `name`=?,`sex`=?,`age`=?,`comment`=? WHERE id=?";
        $a=$this->mysql->prepare($sql);
        if($a->execute(array($name,$sex,$age,$comment,$id)))
            return 1;
        else
            return 0;
    }


    function findAll()
    {//查询所有用户
        $sql="SELECT * FROM `user`";
        return $this->mysql->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    function findLimit($offset, $pagesize)
    {//分页查询所有
        $sql = "SELECT * FROM `user` LIMIT $offset,$pagesize";
        return $this->mysql->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    function search($sex,$ageextentl,$ageextentr)
    {//条件查询
        $sql="SELECT * FROM `user` WHERE  sex= ? and ? <=age and age<= ? ";
        $stmt=$this->mysql->prepare($sql);
        $stmt->execute(
            array($sex,$ageextentl,$ageextentr)
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}