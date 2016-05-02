using ABPS.Data;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using ABPS.Utils;
using System.Timers;
namespace ABPS
{
   public static class Platform
    {
       public static PlatformAPI Api { get; set; }
       public static ChatbotSmackdownDb DBManager { get; set; }
       public static HttpService Service { get; set; }
        public static System.Timers.Timer UpdateTimer {get;set;}
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
           DBManager.Votes.Load();
       }
        
       public static void Start()
       {
           Service.listen();
       }

       public static void OnTimedEvent(Object source, ElapsedEventArgs e)
       {
           try
           {
               Load();
           }
           catch (Exception ex)
           {
               Console.WriteLine("Failed to update records : " + ex.Message);
           }
       }
    }
}
