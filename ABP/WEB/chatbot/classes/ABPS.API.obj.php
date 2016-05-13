<?php
require_once(dirname(__FILE__)."/CBSD.obj.php");
require_once(dirname(__FILE__)."/HttpRequest.php");



class Response extends SerializableModel
{
public $Code;
}
class GoodResponse extends Response
   {
       public $message;
   }
class ErrorResponse extends Response
   {
       public $error;

   }
class BotStatusResponse extends Response
   {
       public $status;
       public $bot;
   }
class BotInfoResponse extends Response
   {
       public $status ;
       public $bot;
       public $name;
       public $description;
       public $score;

   }
class BotAnswerResponse extends Response
   {
       public $message;
   }
class TournamentResponse extends Response
   {
       public $id ;
       public $name;
       public $start;
       public $participants;
       public $status;


       public $rounds;
       public $teams;

   }
class GameHistoryResponse extends Response
   {
       public $history;


   }
class GameHistoryEntry
{
public $BotId;
public $Name;
public $Message ;

}
class GameHistory
{
public $Entries;
}


class SDLBotPlatformServiceAPI
{
        private $api_url;
        private $api_key;
    private $last_response;

    /**
     * @return mixed
     */
    public function getLastResponse()
    {
        return $this->last_response;
    }
    /**
     * SDLBotPlatformServiceAPI constructor.
     * @param $api_url
     * @param $api_key
     */
    public function __construct($api_url, $api_key)
    {
        $this->api_url = $api_url;
        $this->api_key = $api_key;

    
    }

        private function makeUrl($query)
        {
            return $this->api_url."api?".$query."&key=".$this->api_key;
        }
        private function makeRequest($url)
        {
            $this->last_response =null;
            $r = new HttpRequest("get",$this->makeUrl($url));
            if ($r->getError()) {
                $error = new ErrorResponse();
                $error->Code = "REQUEST_ERROR";
                $error->error = "sorry, an error occured";
                return $error;
            } else {
                // parse json and show tweets
               $response = $r->getResponse();
                $this->last_response = Response::deserialize($response);
                return $this->last_response ;
            }
        }
    public function makeRequestJson($url)
    {
        $this->last_response =null;
        $r = new HttpRequest("get",$this->makeUrl($url));
        if ($r->getError())return null;
       else return  $r->getResponse();
    }
    // API Methods
        public function getBotStatus($id)
        {
            $resp = $this->makeRequest("method=status&id=".$id);
             if($resp instanceof BotStatusResponse)
                return $resp;
            else return null;
        }
        public function getBotInfo($id)
    {
        $resp = $this->makeRequest("method=info&id=".$id);
        if($resp instanceof BotInfoResponse)
            return $resp;
        else return null;
    }
        public function addBot($id)
    {
        $resp = $this->makeRequest("method=add&id=".$id);
        if($resp instanceof GoodResponse)
            return $resp;
        else return null;
    }
    public function reloadBot($id)
    {
        $resp = $this->makeRequest("method=reload&id=".$id);
        if($resp instanceof GoodResponse)
            return $resp;
        else return null;
    }
        public function getTournamentStructure($tid)
    {
        $resp = $this->makeRequest("method=tournament&id=".$tid);
        if($resp instanceof TournamentResponse)
            return $resp;
        else return null;
    }
        public function spectateGame($gid)
    {
        $resp = $this->makeRequest("method=spectate&gid=".$gid);

        if($resp instanceof GameHistoryResponse)
            return $resp;
        else return null;
    }

    public function getGameHistory($gid)
    {
       return $this->makeRequestJson("method=spectate&gid=".$gid);
    }
  public function talkWithBot($id, $user, $message)
    {
        $resp = $this->makeRequest("method=talk&id=".$id."&user=".$user."&message=".$message);
        if($resp instanceof BotAnswerResponse)
            return $resp;
        else return null;
    }
    public function synchronize()
    {
        $resp = $this->makeRequest("method=sync");

        if($resp instanceof GoodResponse)
            return true;
        else return false;
    }
    public function isAvailable()
    {
        $resp = $this->makeRequest("method=ping");

        if($resp instanceof GoodResponse)
            return true;
        else return false;
    }
    public function reloadCompetitions()
    {
        $resp = $this->makeRequest("method=competreload");

        if($resp instanceof GoodResponse)
            return true;
        else return false;
    }
    public function getCompetitionStatus($id)
    {
        $resp = $this->makeRequest("method=cstat&id=$id");

        if($resp instanceof GoodResponse)
            return $resp->message;
        else return "3";
    }
    public function getGameStatus($id)
    {
        $resp = $this->makeRequest("method=gstat&id=$id");

        if($resp instanceof GoodResponse)
            return $resp->message;
        else return "3";
    }

}



?>