using ABPS.Data;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABPS
{
   public class PlatformAPI
    {
       public string ErrorMessage = "{\"status\":\"{0}\",\"error\":\"{1}\"}";
       public PlatformAPI()
       {
      
       }

       public string AddBot(string id)
       {
           try
           {
               long bid = long.Parse(id);
               Platform.LogEvent("Add bot "+id, ConsoleColor.DarkCyan);

               List<User> bots = Platform.DBManager.Users.Where(x => x.Id == bid).ToList();
               if (bots.Count > 0)
               {
                   List<Chatbot> cb = Platform.Chatbots.Where(x => x.User.Id == bid).ToList();
                   if (cb.Count == 0)
                   {
                       Platform.AddBot(bots[0]);
                       return JsonConvert.SerializeObject(new GoodResponse("OK", "The bot has been successfully added"));
                   }
                   else
                       return JsonConvert.SerializeObject(new ErrorResponse("BOT_EXIST", "This bot already exists"));
           
            
               }
               else
                   return JsonConvert.SerializeObject(new ErrorResponse("BOT_NOT_EXIST", "This bot does not exist"));
           }
           catch (Exception ex)
           {
               return JsonConvert.SerializeObject(new ErrorResponse("FAILED", ex.Message));
           }

       }
       public string ReloadBot(string id)
       {
           try
           {
               Platform.LogEvent("Reload bot " + id, ConsoleColor.DarkCyan);
               long bid = long.Parse(id);
               List<User> bots = Platform.DBManager.Users.Where(x => x.Id == bid).ToList();
               if (bots.Count > 0)
               {
                   Chatbot cb = Platform.Chatbots.Where(x => x.User.Id == bid).ToList()[0];
                   cb.ReloadBot();
                   return JsonConvert.SerializeObject(new GoodResponse("OK", "The bot has been successfully reloaded"));
               }
               else
                   return JsonConvert.SerializeObject(new ErrorResponse("BOT_NOT_EXIST", "This bot does not exist"));
           }
           catch (Exception ex)
           {
               return JsonConvert.SerializeObject(new ErrorResponse("FAILED", ex.Message));
           }

       }
       public string GetBotInfo(string id)
       {
           try
           {

               long bid = long.Parse(id);
               List<User> bots = Platform.DBManager.Users.Where(x => x.Id == bid).ToList();
               if (bots.Count > 0)
                   return JsonConvert.SerializeObject(new BotInfoResponse("OK", bots[0].Id, bots[0].BotActive, bots[0].BotName, bots[0].BotDescription, bots[0].BotScore));

               else
                   return JsonConvert.SerializeObject(new ErrorResponse("BOT_NOT_EXIST", "This bot does not exist"));
           }
           catch (Exception ex)
           {
               return JsonConvert.SerializeObject(new ErrorResponse("FAILED", ex.Message));
           }

       }
       public string GetBotStatus(string id)
       {
           try

           {

               long bid =long.Parse(id);
               List<User> bots = Platform.DBManager.Users.Where(x => x.Id == bid ).ToList();
               if (bots.Count > 0)
                   return JsonConvert.SerializeObject(new BotStatusResponse("OK", bots[0].Id, bots[0].BotActive));

               else
                   return JsonConvert.SerializeObject(new ErrorResponse("BOT_NOT_EXIST", "This bot does not exist"));
           }
           catch (Exception ex)
           {
               return JsonConvert.SerializeObject(new ErrorResponse("FAILED",ex.Message));
           }
         
       }
       public string TalkWithBot(string id, string user, string message)
       {
        

        try
        {
            long bid = long.Parse(id);
            List<Chatbot> bots = Platform.Chatbots.Where(x => x.User.Id == bid).ToList();
            if (bots.Count > 0)
            {
                if(bots[0].IsInGame)
                    return JsonConvert.SerializeObject(new ErrorResponse("BOT_IS_BUSY", "This bot is in game"));

                List<Visitor> vis = Platform.DBManager.Visitors.Where(x => x.VisitorIdentifier == user && x.BotId == bid).ToList();
                if (vis.Count > 0)
                {
                  
                    string answer = bots[0].Answer(message, vis[0]);

                    return JsonConvert.SerializeObject(new BotAnswerResponse("OK",answer));

                }
                else
                {
                    Visitor v = new Visitor();
                    v.BotId = bid;
                    v.VisitorIdentifier = user;
                    Platform.DBManager.Visitors.Add(v);
                    Platform.DBManager.SaveChanges();

                    string answer = bots[0].Answer(message, v);
                    return JsonConvert.SerializeObject(new BotAnswerResponse("OK", answer));
                }
              
            }
            else
                return JsonConvert.SerializeObject(new ErrorResponse("BOT_NOT_EXIST", "This bot does not exist"));
        }
        catch (Exception ex)
        {
            return JsonConvert.SerializeObject(new ErrorResponse("FAILED", ex.Message));
        }

       }

       public string SpectateGame(string gid)
       {
           try
           {
               long bid = long.Parse(gid);
               List<Game> games = Platform.DBManager.Games.Where(x => x.Id == bid).ToList();
               if (games.Count > 0)
               {
                   List<TournamentInstance> compet = TournamentManager.Tournaments.Where(x => x.Competition.Id == games[0].Round.CompetitionId).ToList();
                   if (games[0].Status == GameStatus.Completed)
                       return JsonConvert.SerializeObject(new GameHistoryResponse("OK", JsonConvert.DeserializeObject<GameHistory>(File.ReadAllText(Environment.CurrentDirectory + "\\history\\" + games[0].ChatHistoryFile))));
                   else
                   {
                       if (compet.Count > 0)
                       {
                          List< GameInstance> gi = compet[0].ExecutedGames.Where(x => x.Game.Id == games[0].Id).ToList();
                           if(gi.Count > 0)
                          return JsonConvert.SerializeObject(new GameHistoryResponse("OK", gi[0].Driver.CurrentGameHistory));
                           else return JsonConvert.SerializeObject(new ErrorResponse("GAME_NOT_STARTED", "This game didn't start"));

                       }
                       else return JsonConvert.SerializeObject(new ErrorResponse("TOURNAMENT_NOT_FOUND", "This game had no tournament"));

                   }

               }
               else
                   return JsonConvert.SerializeObject(new ErrorResponse("GAME_NOT_EXIST", "This game does not exist"));
           }
           catch (Exception ex)
           {
               return JsonConvert.SerializeObject(new ErrorResponse("FAILED", ex.Message));
           }
       }
       public string TournamentStructure(string tid)
       {  try
           {
           long bid = long.Parse(tid);
           List<TournamentInstance> compet = TournamentManager.Tournaments.Where(x => x.Competition.Id == bid).ToList();
           if (compet.Count > 0)
                      return JsonConvert.SerializeObject(new TournamentResponse("OK", compet[0]));
           else return JsonConvert.SerializeObject(new ErrorResponse("TOURNAMENT_NOT_FOUND", "This tournament does not exist"));


           }
       catch (Exception ex)
       {
           return JsonConvert.SerializeObject(new ErrorResponse("FAILED", ex.Message));
       }
       }
       public string RedirectRequest(string method, NameValueCollection nvc)
       {
           if (method == "status" && nvc["id"] != null)
               return GetBotStatus(nvc["id"]);
           else if (method == "add" && nvc["id"] != null)
               return AddBot(nvc["id"]);
           else if (method == "reload" && nvc["id"] != null)
               return ReloadBot(nvc["id"]);
           else if (method == "info" && nvc["id"] != null)
               return GetBotInfo(nvc["id"]);
           else if (method == "talk" && nvc["id"] != null && nvc["user"] != null && nvc["message"] != null)
               return TalkWithBot(nvc["id"], nvc["user"], nvc["message"]);
           else if (method == "tournament" && nvc["tid"] != null)
               return TournamentStructure(nvc["tid"]);

           else if (method == "spectate" && nvc["gid"] != null)
               return SpectateGame(nvc["gid"]);

           else return JsonConvert.SerializeObject(new ErrorResponse("NOT_SUPPORTED", "This method is not supported by the platform"));
        
       }
    }
}
