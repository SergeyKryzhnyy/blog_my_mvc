<?php
namespace App\Model;

use Src\AbstractModel;
use Src\Db;

class Post extends AbstractModel
{
   public $idMessage;
   public $text;
   public $idUser;
    public $nameUser;
   public $data;

//    public function __construct($data = [])
//    {
//        if ($data) {
//            $this->idMessage = $data['idMessage'];
//            $this->text = $data['text'];
//            $this->idUser = $data['idUser'];
//        }
//    }

    public function getIdMessage($int)
    {
        return $this->idMessage[$int];
    }

    public function setIdMessage($message):int
    {
        return $this->idMessage = $message;
    }

    public function getText($int)
    {
        return $this->text[$int];
    }

    public function setText($text):string
    {
        return $this->text = $text;
    }

    public function getNameUser($int)
    {
        return $this->nameUser[$int];
    }

    public function setIdUser($idUser)
    {
        return $this->idUser = $idUser;
    }

    public function savePost($post, $id_user)//сохраняем пост
    {
        $db = Db::getInstance();
        $insert = "INSERT INTO posts (`text`, `id_user`) VALUES (:post,:id_user)";
        $db->exec($insert, __METHOD__, [':post'=>$post, ':id_user'=>$id_user]);
        $id = $db->lastInsertId();
        $this->id = $id;
        return $id;
    }

    public function showAllPosts()
    {
        $db = Db::getInstance();
        $select = "SELECT name, text, id_message FROM users JOIN posts ON users.id = posts.id_user";
        $data = $db->fetchAll($select, __METHOD__);
        $i=0;

        foreach ($data as $key=>$value)
        {
            $this->nameUser[$i] = $value['name'];
            $this->text[$i] = $value['text'];
            $this->idMessage[$i] = $value['id_message'];
            $i++;
        }
        for ($i=0;$i<20;$i++)
        {
            $array[$i] = 'id:'  . $this->idMessage[$i] . "<br>" .  $this->text[$i] . "<br>" . "Автор-"  . $this->nameUser[$i];
            if  ($this->idMessage  ==  null)
            {
                break;
            }
        }
        return $array;
    }

    public function getAllMessages($user_id)
    {
        $db = Db::getInstance();
        $select = "SELECT `date`, id_message, text FROM posts WHERE id_user=:user_id ORDER BY `date`";
        $rows = $db->fetchAll($select, __METHOD__,[':user_id'=>$user_id]);
        return $rows;
    }

    public function  deletePost($i)
    {
        $db = Db::getInstance();
        $insert = "DELETE FROM posts WHERE id_message=:i";
        $db->exec($insert, __METHOD__,[':i'=>$i]);
    }
}