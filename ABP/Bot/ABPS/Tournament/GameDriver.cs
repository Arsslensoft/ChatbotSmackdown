using ABPS.Data;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace ABPS
{

    public class GameHistoryEntry
    {
        public long? BotId { get; set; }
        public string Name { get; set; }
        public string Message { get; set; }

        public GameHistoryEntry()
        {

        }
        public GameHistoryEntry(User bot, string msg)
        {
            BotId = bot.Id;
            Name = bot.BotName;
            Message = msg;
        }

        public override string ToString()
        {
            return Name + ": "+Message;
        }
    }
    public class GameHistory
    {
        public List<GameHistoryEntry> Entries { get; set; }

        public GameHistory()
        {
            Entries = new List<GameHistoryEntry>();
        }
        public override string ToString()
        {
      

            return JsonConvert.SerializeObject(this);
        }
    }
  public  class GameDriver
    {
      public Game Game;
      public GameDriver(Game game)
      {
          Game = game;
      }
      public Chatbot First { get; set; }
      public Chatbot Second { get; set; }

      public User FirstUser { get; set; }
      public User SecondUser { get; set; }
      public GameHistory CurrentGameHistory { get; set; }

      /// <summary>
      /// Initialize's a game
      /// </summary>
      public void InitializeGame()
      {
        

          CurrentGameHistory = new GameHistory();
        
          FirstUser = Game.Players[0].Bot;
          SecondUser = Game.Players[1].Bot;

          First = Platform.Chatbots.Where(x => x.User.Id == FirstUser.Id).ToList()[0];
          Second = Platform.Chatbots.Where(x => x.User.Id == SecondUser.Id).ToList()[0];

          // Initialize bots
          Second.InitializeUserBot(First.BotEngine);
          First.InitializeUserBot(Second.BotEngine);
          First.IsInGame = true;
          Second.IsInGame = true;
          Platform.LogEvent("Game " + Game.Id.ToString() + " Initialized ", ConsoleColor.DarkCyan);
      }

      public DateTime Start { get; set; }

      /// <summary>
      /// Start chat between 2 bots
      /// </summary>
      public void StartChat()
      {
          Start = DateTime.Now;
          CurrentGameHistory.Entries.Add(new GameHistoryEntry(SecondUser, "Hi"));
        string answer =  First.Answer("Hi", Second);
        CurrentGameHistory.Entries.Add(new GameHistoryEntry(FirstUser, answer));
         

          while ((DateTime.Now - Start) < Game.Duration)
          {
              try
              {
                  answer = Second.Answer(answer, First);
                  CurrentGameHistory.Entries.Add(new GameHistoryEntry(SecondUser, answer));

                  answer = First.Answer(answer, Second);
                  CurrentGameHistory.Entries.Add(new GameHistoryEntry(FirstUser, answer));
                
              }
              catch (Exception ex)
              {
                  Platform.LogEvent("A bot caused error: " + ex.Message, ConsoleColor.Red);
              }
              Thread.Sleep(Game.PlayerSleepTime);
          }

          First.IsInGame = false;
          Second.IsInGame = false;
          Platform.LogEvent("Game " + Game.Id.ToString() + " Started ", ConsoleColor.DarkCyan);

      }

      /// <summary>
      /// Saves game history
      /// </summary>
      public void FinalizeGame()
      {
          string file = DateTime.Now.ToFileTime().ToString() + ".dat";
          File.WriteAllText(Environment.CurrentDirectory + "\\history\\" + file, CurrentGameHistory.ToString());

          Game.ChatHistoryFile = file;
          Platform.DBManager.SaveChanges();
          Platform.LogEvent("Game " + Game.Id.ToString() + " Finalized ", ConsoleColor.DarkCyan);

      }

    }
}
