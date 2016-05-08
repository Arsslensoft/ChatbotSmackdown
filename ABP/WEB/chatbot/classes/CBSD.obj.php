<?php
require_once(dirname(__FILE__)."/JsonSerializer/JsonSerializer.php");
require_once(dirname(__FILE__)."/Enum.obj.php");


class UserRole extends Enum
{
    const __default = self::User;
    const User = 0;
    const Administrator = 1;
}
class CompetitionStatus extends Enum
    {
     const __default = self::Ready;
      const  Ready = 0;
        const Started = 1;
        const Completed = 2;
    }
class GameStatus extends Enum
{
const Pending=0;
const Playing=1;
const Voting=2;
const Completed=3;
}


abstract class SerializableModel  {

    public function serialize() {
        $serializer = new JsonSerializer();
        return $serializer->serialize($this);
    }


    public static function deserialize($json, $typename = null) {
        $serializer = new JsonSerializer();
        if($typename != null)
              return  $serializer->unserializeWithTypeName($json, $typename);
        else
            return $serializer->unserialize($json);

    }

}

// Database classes
class DatabaseObject extends SerializableModel{
    protected $Id;
    public function getId()
    {
        return $this->Id;
    }
    public function setId($Id)
    {
        $this->Id = $Id;
    }

}
class AimlSet extends DatabaseObject
{
    private $BotId;
    private $AimlFile;
    private $Load;

}
class Competition extends DatabaseObject
{
private $Start ;
private $Name;
private $Description;
private $Status ;
      // Prize
private $PointsPerWin ;
private $Prize ;
private $ParticipantNumber ;
}
class Game extends  DatabaseObject
{
    private $RoundId;
    private $Status;
    private $Start ;
    private $Duration;
    private $PlayerSleepTime ;
    private $WinnerId;
    private $ChatHistoryFile;
}
class Participation extends DatabaseObject
    {
         private $BotId;
        private $CompetitionId;
            private $JoinDate;
    }
class Personality extends DatabaseObject
    {
    private $BotId ;
    private $PersonalityFile;
    private $Active;
    }
class Ranking extends  DatabaseObject
{
private $BotId;
private $CompetitionId;
private $Rank;
}
class Round extends DatabaseObject
{
private $CompetitionId;
private $Number;
}
class Player extends DatabaseObject
{
    private $GameId ;
private $BotId ;
private $Score ;
    private $Votes;
}
class Visitor extends DatabaseObject
{
    private $BotId;
    private $VisitorIdentifier;
}
class User extends DatabaseObject {
    private $Username;
    private $Password;
    private $Email;
    private $FirstName;
    private $LastName;
    private $Role;

    // Bot part
    private $BotName;
    private $BotDescription;
    private $BotScore;
    private $BotActive;
}






/*

$content = new User();
$content->setId(5);
$json= $content->serialize();
echo $json;
$u = User::deserialize($json,User::class);
echo $u->getId();*/

?>