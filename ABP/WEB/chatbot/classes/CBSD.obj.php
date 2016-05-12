<?php
require_once(dirname(__FILE__)."/JsonSerializer/JsonSerializer.php");
require_once(dirname(__FILE__)."/Enum.obj.php");
require_once(dirname(__FILE__)."/ObjectRelationalModel.class.php");


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


class DataMappingManager
{
    public static $connection;
    public static function initializeMapper($conn = null)
    {
    if($conn == null) {
        // Connect to the database using mysqli
        $conn = new mysqli($GLOBALS["mysql_hostname"], $GLOBALS["mysql_username"], $GLOBALS["mysql_password"], $GLOBALS["mysql_database"]);
        if( $conn->connect_error )
            throw new Exception("MySQL connection could not be established: ".$conn->connect_error);
    }
    $connection = $conn;

ObjectRelationalModel::useConnection($conn, $GLOBALS["mysql_database"]);

    }
}

abstract class SerializableModel   {
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
class DatabaseObject extends ObjectRelationalModel{
    public $Id;


}
class AimlSet extends DatabaseObject
{  protected static  $table = 'aimlsets';
    public $BotId;
    public $AimlFile;

}
class Competition extends DatabaseObject
{protected static  $table = 'competitions';
public $Start ;
public $Name;
public $Description;
public $Status ;
      // Prize
public $PointsPerWin ;
public $Prize ;
public $ParticipantNumber ;
}
class Game extends  DatabaseObject
{  protected static  $table = 'games';
    public $RoundId;
    public $Status;
    public $Start ;
    public $Duration;
    public $PlayerSleepTime ;
    public $WinnerId;
    public $ChatHistoryFile;
}
class Participation extends DatabaseObject
    {  protected static  $table = 'participations';
         public $BotId;
        public $CompetitionId;
            public $JoinDate;
    }
class Personality extends DatabaseObject
    {
    protected static  $table = 'personalities';
    public $BotId ;
    public $PersonalityFile;
    }
class Ranking extends  DatabaseObject
{
    protected static  $table = 'rankings';
public $BotId;
public $CompetitionId;
public $Rank;
}
class Round extends DatabaseObject
{  protected static  $table = 'rounds';
public $CompetitionId;
public $Number;
}
class Player extends DatabaseObject
{  protected static  $table = 'players';
    public $GameId ;
public $BotId ;
public $Score ;
    public $Votes;
}
class Visitor extends DatabaseObject
{
    protected static  $table = 'visitors';
    public $BotId;
    public $VisitorIdentifier;
}
class User extends DatabaseObject {
    protected static  $table = 'users';
    public $Username;
    public $Password;
    public $Email;
    public $FirstName;
    public $LastName;
    public $Role;
    public $Salt;
    // Bot part
    public $BotName;
    public $BotDescription;
    public $BotScore;
    public $BotActive;
}






/*

$content = new User();
$content->setId(5);
$json= $content->serialize();
echo $json;
$u = User::deserialize($json,User::class);
echo $u->getId();*/

?>