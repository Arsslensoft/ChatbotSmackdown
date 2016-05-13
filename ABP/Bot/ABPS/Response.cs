using ABPS.Data;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABPS
{
   public class Response
    {
       string tp;
            [JsonProperty("@type")]
       public string type
       {
           get
           {
              return  this.GetType().Name;
           }
           set
           {
               tp = value;
           }
       }
       [JsonProperty("code")]
       public string Code { get; set; }
       public Response(string code)
       {
           Code = code;
    
       }
    }
   public class GoodResponse : Response
   {
       public string message { get; set; }
       public GoodResponse(string code, string message)
           : base(code)
       {
           this.message = message;
       }
   }
   public class ErrorResponse : Response
   {
       public string error { get; set; }
       public ErrorResponse(string code, string error)
           : base(code)
       {
           this.error = error;
       }
   }
   public class BotStatusResponse : Response
   {
       public int status { get; set; }
       public long bot { get; set; }
   
       public BotStatusResponse(string code, long id, bool active) : base(code)
       {
           bot = id;
           status = active ? 1 : 0;
       }
   }
   public class BotInfoResponse : Response
   {
       public int status { get; set; }
       public long bot { get; set; }
       public string name {get;set;}
       public string description { get; set; }
       public long score { get; set; }

       public BotInfoResponse(string code, long id, bool active,string name,string desc,long sc)
           : base(code)
       {
           bot = id;
           status = active ? 1 : 0;
           this.name = name;
           description = desc;
           score = sc;
       }
   }
   public class BotAnswerResponse : Response
   {
    
       public string message { get; set; }


       public BotAnswerResponse(string code, string msg)
           : base(code)
       {
         message = msg;
       }
   }
   public class TournamentResponse : Response
   {
       public long id { get; set; }
       public string name { get; set; }
       public DateTime start { get; set; }
       public long participants { get; set; }
       public CompetitionStatus status { get; set; }


       public List<Tournaments.TournamentRound> rounds { get; set; }
       public List<Tournaments.TournamentTeam> teams { get; set; }

       public TournamentResponse(string code, TournamentInstance ti)
           : base(code)
       {
           id = ti.Competition.Id;
           name = ti.Competition.Name;
           start = ti.Competition.Start;
           status = ti.Competition.Status;
           participants = ti.Competition.ParticipantNumber;
           rounds = ti.Rounds;
           teams = ti.Teams;
       }
   }
   public class GameHistoryResponse : Response
   {
       public GameHistory history { get; set; }


       public GameHistoryResponse(string code, GameHistory his)
           : base(code)
       {
           history = his;

       }
   }
}
