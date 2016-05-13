using ABPS.Data;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using ABPS.Utils;
using System.Timers;
using System.Threading;
namespace ABPS
{
    public static class PlatformSettings
    {
        public static TimeSpan GameSpacing = new TimeSpan(0, 0, 2);
        public static TimeSpan GameDuration = new TimeSpan(0,0,15);
        public static TimeSpan PlayerPause = new TimeSpan(0, 0, 2);
        public static TimeSpan RoundInterval = new TimeSpan(0,1,0);
       
    }
   public static class Platform
    {
       public static PlatformAPI Api { get; set; }
       public static ChatbotSmackdownDb DBManager { get; set; }
       public static HttpService Service { get; set; }
       public static System.Timers.Timer UpdateTimer {get;set;}
       public static List<Chatbot> Chatbots { get; set; }
       public static object sync_lock = new object();
       public static void Synchronize()
       {
           try
           {
               lock (sync_lock)
               {
                   foreach (var entity in Platform.DBManager.ChangeTracker.Entries())
                       entity.Reload();
               }
           }
           catch (Exception ex)
           {
               Platform.LogEvent("Synchronization error : " + ex.Message, ConsoleColor.Red);
           }
       }

       public static void LogEvent(string ev, ConsoleColor color)
       {
           Console.ForegroundColor = ConsoleColor.Green;
           Console.Write("["+DateTime.Now + "] : ");
           Console.ForegroundColor = color;
           Console.Write(ev);
           Console.ForegroundColor = ConsoleColor.White;
           Console.WriteLine();
       }
       public static void AddBot(User bot)
       {
        
           Chatbot chat = new Chatbot(bot);
           Chatbots.Add(chat);

           chat.ReloadBot(bot);
       }
       public static void ReloadBots()
       {
           Chatbots.Clear();
           Load();
           foreach (User bot in DBManager.Users.ToList())
               AddBot(bot);
   
       }
       public static void Initialize(int port,  int update_timeout)
       {
           DBManager = new ChatbotSmackdownDb();
                  UpdateTimer = new System.Timers.Timer(update_timeout);
                  Api = new PlatformAPI();
            UpdateTimer.Elapsed += OnTimedEvent;
            UpdateTimer.AutoReset = true;
            UpdateTimer.Enabled = true;

           Service = new HttpService(port);
                Load();
                Chatbots = new List<Chatbot>();
                ReloadBots();
                TournamentManager.Initialize();
                TournamentManager.Reload();
       }
       public static void Load()
       {
           DBManager.AimlSets.Load();
           DBManager.Competitions.Load();
           DBManager.Games.Load();
           DBManager.Participations.Load();
           DBManager.Personalities.Load();
           DBManager.Users.Load();
           DBManager.Visitors.Load();
        

       }

        
       public static void Start()
       {
           Service.listen();
        
       }

       public static void OnTimedEvent(Object source, ElapsedEventArgs e)
       {
           try
           {
               Synchronize();
           }
           catch (Exception ex)
           {
               Console.WriteLine("Failed to update records : " + ex.Message);
           }
       }
    }
}
